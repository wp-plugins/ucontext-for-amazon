<?php

$form_vars = self::$form_vars;

@include UCONTEXT4A_INTEGRATION_PATH.'/admin/snippets/settings_save.php';

$form_vars['ucontext4a_redirect_slug'] = preg_replace('/[^0-9a-zA-Z\-\_]+/is', '', trim(@$form_vars['ucontext4a_redirect_slug']));

update_option('ucontext4a_max_links',			(int)@$form_vars['ucontext4a_max_links']);
update_option('ucontext4a_redirect_slug',		$form_vars['ucontext4a_redirect_slug']);
update_option('ucontext4a_no_autokeywords',	(int)@$form_vars['ucontext4a_no_autokeywords']);
update_option('ucontext4a_site_keywords',		trim(@$form_vars['ucontext4a_site_keywords'], ','));
update_option('ucontext4a_links_display',		(int)@$form_vars['ucontext4a_links_display']);
update_option('ucontext4a_hide_rss_links',	(int)@$form_vars['ucontext4a_hide_rss_links']);

Ucontext4a_Admin::saveKeywordsToMainList($form_vars['ucontext4a_site_keywords'], 'manual');

$wpdb->query('UPDATE '.Ucontext4a_Base::$table['keyword'].' SET last_updated = 0');
$wpdb->query('DELETE FROM '.$wpdb->base_prefix.'postmeta WHERE meta_key = "ucontext4a_auto_keywords"');

if (!self::$form_errors)
{
	update_option('ucontext4a_notification', '');
	update_option('ucontext4a_api_disabled', 0);

	header('location: admin.php?page='.self::$name.'&action=settings&saved=1');
	exit();
}

self::$action = 'settings';