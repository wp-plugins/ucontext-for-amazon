<?php

// Copyright 2013 - Summit Media Concepts LLC - http://SummitMediaConcepts.com

require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Base.php';

class Ucontext4a_Public extends Ucontext4a_Base
{
	public static function init()
	{
		self::initBase();
	}

	public static function filterContent($content)
	{
		require_once UCONTEXT4A_INTEGRATION_PATH.'/Ucontext4a_Integration.php';

		if (Ucontext4a_Integration::isValidLicense())
		{
			global $wpdb, $post;

			$display = (int)get_option('ucontext4a_links_display', 0);

			if (!$display || ($display == 1 && $post->post_type == 'post') || ($display == 2 && $post->post_type == 'page'))
			{
				if (!(int)get_post_meta($post->ID, 'ucontext4a_disable', true))
				{
					$keyword_list = self::getPostKeywordList($post);

					$content = Ucontext4a_Intext::addInTextLinks($content, $keyword_list, @get_option('ucontext4a_max_links', 5));
				}
			}
		}

		return $content;
	}

	public static function getPostKeywordList($post)
	{
		global $wpdb;

		require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Intext.php';
		require_once UCONTEXT4A_APP_PATH.'/Ucontext4a_Keyword.php';

		Ucontext4a_Intext::$settings = array(
		'intext_class'	=> get_option('ucontext4a_intext_class'),
		'nofollow'		=> get_option('ucontext4a_nofollow'),
		'new_window'	=> get_option('ucontext4a_new_window')
		);

		$keyword_list = array();

		$ucontext4a_manual_keywords = get_post_meta($post->ID, 'ucontext4a_manual_keywords', true);
		$ucontext4a_manual_keywords = explode(',', strtolower($ucontext4a_manual_keywords));

		if (is_array($ucontext4a_manual_keywords))
		{
			foreach ($ucontext4a_manual_keywords as $keyword)
			{
				$keyword = trim($keyword);

				if ($keyword)
				{
					$keyword_list[$keyword] = array();
				}
			}
		}

		$ucontext4a_site_keywords = get_option('ucontext4a_site_keywords');
		$ucontext4a_site_keywords = explode(',', strtolower($ucontext4a_site_keywords));

		if (is_array($ucontext4a_site_keywords))
		{
			foreach ($ucontext4a_site_keywords as $keyword)
			{
				$keyword = trim($keyword);

				if ($keyword)
				{
					$keyword_list[$keyword] = array();
				}
			}
		}

		if (!(int)@get_post_meta($post->ID, 'ucontext4a_processed', TRUE))
		{
			self::saveKeywordsToMainList(array_keys($keyword_list));
		}

		if (!(int)@get_option('ucontext4a_no_autokeywords', 0))
		{
			$ucontext4a_auto_keywords = get_post_meta($post->ID, 'ucontext4a_auto_keywords', true);

			if (!is_array($ucontext4a_auto_keywords) || !count($ucontext4a_auto_keywords))
			{
				$ucontext4a_auto_keywords = Ucontext4a_Keyword::findKeywordsInContent($post->post_title, $post->post_content, array_keys($keyword_list));

				update_post_meta($post->ID, 'ucontext4a_auto_keywords', $ucontext4a_auto_keywords);

				Ucontext4a_Base::saveKeywordsToMainList(array_keys($ucontext4a_auto_keywords), 'auto');
			}

			if (is_array($ucontext4a_auto_keywords))
			{
				foreach ($ucontext4a_auto_keywords as $keyword => $count)
				{
					$keyword = trim($keyword);

					if ($keyword)
					{
						$keyword_list[$keyword] = array();
					}
				}
			}

			if (!(int)@get_post_meta($post->ID, 'ucontext4a_processed', TRUE))
			{
				self::saveKeywordsToMainList(array_keys($keyword_list), 'auto');

				update_post_meta($post->ID, 'ucontext4a_processed', 1);
			}
		}

		if (is_array($keyword_list))
		{
			$in_list = array();
			foreach ($keyword_list as $keyword => $keyword_data)
			{
				$in_list[] = '"'.addslashes($keyword).'"';
			}

			if ($in_list)
			{
				$data_list = $wpdb->get_results('SELECT keyword_id, product_id, keyword, search_results FROM '.self::$table['keyword'].' WHERE keyword IN ('.implode(',', $in_list).') AND disabled = 0', ARRAY_A);

				if ($data_list)
				{
					$aws_check = 0;

					foreach ($data_list as $data)
					{
						$search_results = unserialize($data['search_results']);

						if (is_array($search_results))
						{
							if ($data['product_id'] && isset($search_results[$data['product_id']]))
							{
								$keyword_list[$data['keyword']]['title'] = $search_results[$data['product_id']]['title'];
								$keyword_list[$data['keyword']]['url'] = $search_results[$data['product_id']]['url'];
							}
							else
							{
								$temp = array_shift($search_results);

								$keyword_list[$data['keyword']]['title'] = $temp['title'];
								$keyword_list[$data['keyword']]['url'] = $temp['url'];
							}
						}
					}
				}
			}
		}

		foreach ($keyword_list as $keyword => $keyword_data)
		{
			if (!isset($keyword_data['url']) || !trim($keyword_data['url']))
			{
				unset($keyword_list[$keyword]);
			}
			else
			{
				$slug = trim(@get_option('ucontext4a_redirect_slug', 'recommends'));

				if (!$slug)
				{
					$slug = 'recommends';
				}

				if (trim(get_option('permalink_structure', '')))
				{
					$keyword_list[$keyword]['url'] = trim(site_url(), '/').'/'.$slug.'/'.$post->ID.'/'.urlencode($keyword);
				}
				else
				{
					$keyword_list[$keyword]['url'] = trim(site_url(), '/').'?'.$slug.'='.urlencode($keyword).'&post_id='.$post->ID;
				}
			}
		}

		return $keyword_list;
	}
}