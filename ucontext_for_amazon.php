<?php
/*
 Plugin Name: uContext for Amazon
 Plugin URI: http://www.uContext.com/
 Description: In-text Amazon affiliate links
 Version: 3.9.1
 Author: Summit Media Concepts LLC
 Author URI: http://www.SummitMediaConcepts.com/
 */

define('UCONTEXT4A_VERSION',		'3.9.1');

define('UCONTEXT4A_PATH',			dirname(__FILE__));
define('UCONTEXT4A_APP_PATH',		UCONTEXT4A_PATH.'/app');
define('UCONTEXT4A_LIST_PATH',	UCONTEXT4A_APP_PATH.'/lists');
define('UCONTEXT4A_PLUGIN_URL',	plugins_url(NULL, __FILE__));

define('UCONTEXT4A_INTEGRATION_TITLE',	'Amazon');
define('UCONTEXT4A_INTEGRATION_HANDLE',	'amazon');
define('UCONTEXT4A_INTEGRATION_PATH',	UCONTEXT4A_APP_PATH.'/integration/'.UCONTEXT4A_INTEGRATION_HANDLE);


if (is_admin())
{
	// Do admin stuff

	require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Admin.php';
	Ucontext4a_Admin::init();

	function Ucontext4a_activatePlugin()
	{
		if (UCONTEXT4A_INTEGRATION_PATH.'/activate.php')
		{
			include UCONTEXT4A_INTEGRATION_PATH.'/activate.php';
		}

		Ucontext4a_Admin::upgradePlugin();

		require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Cron.php';
		Ucontext4a_Cron::init();
		Ucontext4a_Cron::updateAgents();
	}

	function Ucontext4a_displayView()
	{
		Ucontext4a_Admin::displayView();
	}

	function Ucontext4a_addAdminMenu()
	{
		add_menu_page('uContext for '.UCONTEXT4A_INTEGRATION_TITLE, 'uC for '.UCONTEXT4A_INTEGRATION_TITLE, 'activate_plugins', 'ucontext4a', 'Ucontext4a_displayView', UCONTEXT4A_PLUGIN_URL.'/includes/icons/ucontext-icon.png');
	}

	function Ucontext4a_enqueueScripts()
	{
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-dialog');
	}

	function Ucontext4a_admin_notice()
	{
		$notice = get_option('ucontext4a_notification');

		if ($notice)
		{
			echo '<div class="updated"><p>'.$notice.'</p></div>';
		}
	}

	add_action('admin_notices', 'Ucontext4a_admin_notice');

	add_action('admin_menu', 'Ucontext4a_addAdminMenu');

	add_action('wp_enqueue_scripts', 'Ucontext4a_enqueueScripts');

	register_activation_hook(__FILE__, 'Ucontext4a_activatePlugin');

	@include(dirname(__FILE__).'/postmeta.php');

	// Carry meta from old plugin version to current
	if (!get_option('rlm_license_key_'.Ucontext4a_Base::$name) && get_option('ucontext4a_api_key'))
	{
		update_option('rlm_license_key_'.Ucontext4a_Base::$name, get_option('ucontext4a_api_key'));
	}
}
else
{
	// Do public stuff

	require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Public.php';
	Ucontext4a_Public::init();

	function Ucontext4a_filterContent($content)
	{
		global $post;

		Ucontext4a_Public::processPost($post->ID);

		$content = Ucontext4a_Public::filterContent($content);

		return $content;
	}

	function Ucontext4a_publicHead()
	{
		if (get_option('ucontext4a_active', 1))
		{
			if (get_option('ucontext4a_use_style', 0))
			{
				$link_css = get_option('ucontext4a_link_css');

				if ($link_css)
				{
					echo "\n".'<style type="text/css" media="screen">'.$link_css.'</style>'."\n";
				}
			}
		}
	}

	function Ucontext4a_checkRedirect()
	{
		$ucontext4a_redirect_slug = trim(@get_option('ucontext4a_redirect_slug', 'recommends'));

		if (!$ucontext4a_redirect_slug)
		{
			$ucontext4a_redirect_slug = 'recommends';
		}

		if (isset($_REQUEST[$ucontext4a_redirect_slug]) && $_REQUEST[$ucontext4a_redirect_slug])
		{
			$post_id = @$_REQUEST['post_id'];
			$keyword = @$_REQUEST[$ucontext4a_redirect_slug];
		}
		else
		{
			$request_url = str_ireplace(parse_url(site_url(), PHP_URL_PATH), '', $_SERVER['REQUEST_URI']);

			$parts = explode('/', trim($request_url, '/'));

			$slug		= @$parts[0];
			$post_id	= @$parts[1];
			$keyword	= urldecode(@$parts[2]);
		}

		if ($slug == $ucontext4a_redirect_slug && (int)$post_id && $keyword)
		{
			global $wpdb;

			$keyword = $wpdb->get_row('SELECT * FROM '.Ucontext4a_Base::$table['keyword'].' WHERE keyword = "'.esc_sql($keyword).'"', ARRAY_A);

			if ($keyword)
			{
				$search_results = unserialize($keyword['search_results']);

				$url = $search_results[$keyword['product_id']]['url'];

				header('location: '.$url);

				$spider = (int)$wpdb->get_var('SELECT spider_agent_id FROM '.Ucontext4a_Base::$table['spider_agent'].' WHERE "'.esc_sql($_SERVER['HTTP_USER_AGENT']).'" LIKE CONCAT("%", sig, "%") LIMIT 1');

				if ($spider)
				{
					$spider = 1;
				}

				//@file_put_contents('/tmp/uc_spider_sql.log', $spider.' = SELECT spider_agent_id FROM '.Ucontext4a_Base::$table['spider_agent'].' WHERE "'.esc_sql($_SERVER['HTTP_USER_AGENT']).'" LIKE CONCAT("%", sig, "%")'."\n", FILE_APPEND);

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

				$wpdb->insert(Ucontext4a_Public::$table['click_log'], $click_log);

				exit();
			}
		}
	}

	add_action('plugins_loaded', 'Ucontext4a_checkRedirect', 0);

	add_filter('the_content', 'Ucontext4a_filterContent', 9999);
	add_filter('the_content_feed', 'Ucontext4a_filterContent', 9999);

	add_action('wp_head', 'Ucontext4a_publicHead');
}

add_action('wp_ajax_ucontext4a_action', 'Ucontext4a_Ajax_Action');

function Ucontext4a_Ajax_Action()
{
	require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Ajax.php';
	Ucontext4a_Ajax::init();
	Ucontext4a_Ajax::doAjax($_REQUEST['do']);
	exit();
}

// Cron ===================================================

function Ucontext4a_scheduleCron()
{
	if (!wp_next_scheduled('Ucontext4a_5MinuteCronEvent'))
	{
		wp_schedule_event(current_time('timestamp'), '5minutes', 'Ucontext4a_5MinuteCronEvent');
	}

	if (!wp_next_scheduled('Ucontext4a_30DayCronEvent'))
	{
		wp_schedule_event(current_time('timestamp'), '30days', 'Ucontext4a_30DayCronEvent');
	}
}

function Ucontext4a_do5MinuteCron()
{
	require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Cron.php';
	Ucontext4a_Cron::init();
	Ucontext4a_Cron::updateKeywordSearchResults();
}

function Ucontext4a_do30DayCron()
{
	require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Cron.php';
	Ucontext4a_Cron::init();
	Ucontext4a_Cron::updateAgents();
}

function Ucontext4a_addSchedules( $schedules )
{
	$schedules['5minutes']	= array('interval' => 300, 'display' => __('Every 5 Minutes'));
	$schedules['30days']	= array('interval' => 2592000, 'display' => __('Every 30 Days'));
	return $schedules;
}

add_filter('cron_schedules', 'Ucontext4a_addSchedules');

add_action('Ucontext4a_5MinuteCronEvent', 'Ucontext4a_do5MinuteCron');
add_action('Ucontext4a_30DayCronEvent', 'Ucontext4a_do30DayCron');

add_action('wp', 'Ucontext4a_scheduleCron');

@include(dirname(__FILE__).'/widget.php');