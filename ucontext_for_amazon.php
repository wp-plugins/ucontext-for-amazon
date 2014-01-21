<?php
/*
 Plugin Name: uContext for Amazon
 Plugin URI: http://www.uContext.com/
 Description: In-text Amazon affiliate links
 Version: 1.1
 Author: Summit Media Concepts LLC
 Author URI: http://www.uContext.com/
 */

define('UAMAZON_VERSION',	'1.3');

define('UAMAZON_PATH',		dirname(__FILE__));
define('UAMAZON_APP_PATH',	UAMAZON_PATH.'/app');
define('UAMAZON_LIST_PATH',	UAMAZON_APP_PATH.'/lists');

define('UAMAZON_PLUGIN_URL', plugins_url(NULL, __FILE__));

if (is_admin())
{
	// Do admin stuff

	require_once UAMAZON_APP_PATH.'/Uamazon_Admin.php';
	Uamazon_Admin::init();

	function Uamazon_activatePlugin()
	{
		Uamazon_Admin::upgradePlugin();

		require_once UAMAZON_APP_PATH.'/Uamazon_Cron.php';
		Uamazon_Cron::init();
		Uamazon_Cron::updateAgents();
	}

	function Uamazon_displayView()
	{
		Uamazon_Admin::displayView();
	}

	function Uamazon_addAdminMenu()
	{
		add_menu_page('uContext for Amazon', 'uC for Amazon', 'update_core', 'uamazon', 'Uamazon_displayView', UAMAZON_PLUGIN_URL.'/includes/icons/ucontext-icon.png');

		add_meta_box('uamazon', __('uContext for Amazon', 'uamazon'), array('Uamazon_Admin', 'displayPostMeta'), 'post');
		add_meta_box('uamazon', __('uContext for Amazon', 'uamazon'), array('Uamazon_Admin', 'displayPostMeta'), 'page');
	}

	function Uamazon_enqueueScripts()
	{
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
	}

	add_action('admin_menu',		'Uamazon_addAdminMenu');

	add_action('wp_enqueue_scripts', 'Uamazon_enqueueScripts');

	add_action('activate_ucontext_for_amazon/ucontext_for_amazon.php', 'Uamazon_activatePlugin');

	add_action('edit_post',			array('Uamazon_Admin', 'savePostMeta'));
	add_action('publish_post',		array('Uamazon_Admin', 'savePostMeta'));
	add_action('save_post',			array('Uamazon_Admin', 'savePostMeta'));
	add_action('edit_page_form',	array('Uamazon_Admin', 'savePostMeta'));
}
else
{
	// Do public stuff

	require_once UAMAZON_APP_PATH.'/Uamazon_Public.php';
	Uamazon_Public::init();

	function Uamazon_filterContent($content)
	{
		global $post;

		Uamazon_Public::processPost($post->ID);

		$content = Uamazon_Public::filterContent($content);

		return $content;
	}

	function Uamazon_publicHead()
	{
		if (get_option('uamazon_active', 1))
		{
			if (get_option('uamazon_use_style', 0))
			{
				$link_css = get_option('uamazon_link_css');

				if ($link_css)
				{
					echo "\n".'<style type="text/css" media="screen">'.$link_css.'</style>'."\n";
				}
			}
		}
	}

	function Uamazon_checkRedirect()
	{
		$parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

		$slug		= @$parts[0];
		$post_id	= @$parts[1];
		$keyword	= urldecode(@$parts[2]);

		if ($slug == get_option('uamazon_redirect_slug', 'recommends') && (int)$post_id && $keyword)
		{
			global $wpdb;

			$keyword = $wpdb->get_row('SELECT * FROM '.Uamazon_Base::$table['keyword'].' WHERE keyword = "'.$wpdb->escape($keyword).'"', ARRAY_A);

			if ($keyword)
			{
				$search_results = unserialize($keyword['search_results']);

				$url = $search_results[$keyword['aws_asin']]['url'];

				header('location: '.$url);

				$spider = (int)$wpdb->get_var('SELECT spider_agent_id FROM '.Uamazon_Base::$table['spider_agent'].' WHERE "'.$wpdb->escape($_SERVER['HTTP_USER_AGENT']).'" LIKE CONCAT("%", sig, "%") LIMIT 1');

				if ($spider)
				{
					$spider = 1;
				}

				@file_put_contents('/tmp/uc_spider_sql.log', $spider.' = SELECT spider_agent_id FROM '.Uamazon_Base::$table['spider_agent'].' WHERE "'.$wpdb->escape($_SERVER['HTTP_USER_AGENT']).'" LIKE CONCAT("%", sig, "%")'."\n", FILE_APPEND);

				$timezone = ini_get('date.timezone');
				if ($timezone)
				{
					date_default_timezone_set($timezone);
				}

				$click_log = array(
				'post_id'	=> $post_id,
				'keyword'	=> $keyword['keyword'],
				'agent'		=> $_SERVER['HTTP_USER_AGENT'],
				'spider'	=> $spider,
				'date_time'	=> date('Y-m-d H:i:s'),
				'year'		=> date('Y'),
				'month'		=> date('m'),
				'day'		=> date('d'),
				'weekday'	=> date('N'),
				'hour'		=> date('H')
				);

				$wpdb->insert(Uamazon_Public::$table['click_log'], $click_log);

				exit();
			}
		}
	}

	add_action('plugins_loaded', 'Uamazon_checkRedirect');

	add_filter('the_content', 'Uamazon_filterContent', 9999);
	add_filter('the_content_feed', 'Uamazon_filterContent', 9999);

	add_action('wp_head', 'Uamazon_publicHead');
}

add_action('wp_ajax_uamazon_action', 'Uamazon_Ajax_Action');

function Uamazon_Ajax_Action()
{
	require_once UAMAZON_APP_PATH.'/Uamazon_Ajax.php';
	Uamazon_Ajax::init();
	Uamazon_Ajax::doAjax($_REQUEST['do']);
	exit();
}

// Cron ===================================================

function Uamazon_scheduleCron()
{
	if (!wp_next_scheduled('Uamazon_5MinuteCronEvent'))
	{
		wp_schedule_event(time(), '5minutes', 'Uamazon_5MinuteCronEvent');
	}

	if (!wp_next_scheduled('Uamazon_30DayCronEvent'))
	{
		wp_schedule_event(time(), '30days', 'Uamazon_30DayCronEvent');
	}
}

function Uamazon_do5MinuteCron()
{
	require_once UAMAZON_APP_PATH.'/Uamazon_Cron.php';
	Uamazon_Cron::init();
	Uamazon_Cron::updateKeywordSearchResults();
}

function Uamazon_do30DayCron()
{
	require_once UAMAZON_APP_PATH.'/Uamazon_Cron.php';
	Uamazon_Cron::init();
	Uamazon_Cron::updateAgents();
}

function Uamazon_addSchedules( $schedules )
{
	$schedules['5minutes']	= array('interval' => 300, 'display' => __('Every 5 Minutes'));
	$schedules['30days']	= array('interval' => 2592000, 'display' => __('Every 30 Days'));
	return $schedules;
}

add_filter('cron_schedules', 'Uamazon_addSchedules');

add_action('Uamazon_5MinuteCronEvent', 'Uamazon_do5MinuteCron');
add_action('Uamazon_30DayCronEvent', 'Uamazon_do30DayCron');

add_action('wp', 'Uamazon_scheduleCron');


class uContext_for_Amazon_Widget extends WP_Widget
{

	function __construct()
	{
		parent::__construct(
	 		'ucontext_for_amazon_widget',
			'uContext for Amazon Widget',
		array('description' => __('uContext for Amazon text ads', 'ucontext_for_amazon'))
		);
	}

	function widget($args, $instance)
	{
		extract($args);

		global $post;

		$keyword_list = Uamazon_Public::getPostKeywordList($post);

		if (is_array($keyword_list) && count($keyword_list))
		{
			$title = apply_filters('widget_title', $instance['ucontext_for_amazon_widget_title']);

			echo "\n";
			echo '<li class="widget ucontext_for_amazon_widget">'."\n";
			echo '<h2>'.$title.'</h2>'."\n";
			echo '<ul>'."\n";

			if (!$instance['ucontext_for_amazon_widget_max'])
			{
				$instance['ucontext_for_amazon_widget_max'] = 5;
			}

			$row = 0;
			$used_titles = array();

			foreach ($keyword_list as $keyword => $record)
			{
				if (!(int)@$used_titles[strtolower(trim($record['title']))])
				{
					$row++;

					$used_titles[strtolower(trim($record['title']))] = 1;

					echo '<li><a href="'.$record['url'].'">'.$record['title'].'</a></li>'."\n";

					if ($row >= $instance['ucontext_for_amazon_widget_max'])
					{
						break;
					}
				}
			}

			echo '</ul>'."\n";
			echo '</li>'."\n";
		}
	}

	function update($new_instance, $old_instance)
	{
		$new_instance['ucontext_for_amazon_widget_title'] = $new_instance['ucontext_for_amazon_widget_title'];
		$new_instance['ucontext_for_amazon_widget_max'] = (int)$new_instance['ucontext_for_amazon_widget_max'];

		return $new_instance;
	}

	function form($instance)
	{
		if (!$instance['ucontext_for_amazon_widget_max'])
		{
			$instance['ucontext_for_amazon_widget_max'] = 5;
		}

		echo '
		<p>
			<label for="' . $this->get_field_id('ucontext_for_amazon_widget_title') . '">Title:</label>
			<input id="' . $this->get_field_id('ucontext_for_amazon_widget_title') . '" name="' . $this->get_field_name('ucontext_for_amazon_widget_title') . '" value="' . $instance['ucontext_for_amazon_widget_title'] . '" style="width: 100px;" />
		</p>
		<p>
			<label for="' . $this->get_field_id('ucontext_for_amazon_widget_max') . '">Max. Links:</label>
			<input id="' . $this->get_field_id('ucontext_for_amazon_widget_max') . '" name="' . $this->get_field_name('ucontext_for_amazon_widget_max') . '" value="' . $instance['ucontext_for_amazon_widget_max'] . '" style="width: 100px;" />
		</p>
		';
	}
}

function Uamazon_initWidgets()
{
	register_widget('uContext_for_Amazon_Widget');
}

add_action('widgets_init', 'Uamazon_initWidgets');