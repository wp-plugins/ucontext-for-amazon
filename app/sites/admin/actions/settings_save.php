<?php

$form_vars = self::$form_vars;

$form_vars['uamazon_redirect_slug'] = preg_replace('/[^0-9a-zA-Z\-\_]+/is', '', $form_vars['uamazon_redirect_slug']);

if (!strlen(trim($form_vars['uamazon_associate_tag'])))
{
	$form_vars['uamazon_associate_tag'] = get_option('uamazon_associate_tag');
}

if (!strlen(trim($form_vars['uamazon_associate_tag'])))
{
	self::$form_errors['uamazon_associate_tag'] = 'Your Amazon Associate Tag is required';
}

//===

if (!strlen(trim($form_vars['uamazon_public_key'])))
{
	$form_vars['uamazon_public_key'] = get_option('uamazon_public_key');
}

if (!strlen(trim($form_vars['uamazon_public_key'])))
{
	self::$form_errors['uamazon_public_key'] = 'Your Amazon Access Key ID is required';
}

//===

if (!strlen(trim($form_vars['uamazon_private_key'])))
{
	$form_vars['uamazon_private_key'] = get_option('uamazon_private_key');
}

if (!strlen(trim($form_vars['uamazon_private_key'])))
{
	self::$form_errors['uamazon_private_key'] = 'Your Amazon Secret Access Key is required';
}

if (!strlen(trim($form_vars['uamazon_redirect_slug'])))
{
	self::$form_errors['uamazon_redirect_slug'] = 'Redirect Slug is required';
}

update_option('uamazon_associate_tag',		trim(@$form_vars['uamazon_associate_tag']));
update_option('uamazon_public_key',			trim(@$form_vars['uamazon_public_key']));
update_option('uamazon_private_key',		trim(@$form_vars['uamazon_private_key']));
update_option('uamazon_amazon_site',		trim(@$form_vars['uamazon_amazon_site']));
update_option('uamazon_dflt_search_index',	trim(@$form_vars['uamazon_dflt_search_index']));
update_option('uamazon_dflt_condition',		trim(@$form_vars['uamazon_dflt_condition']));
update_option('uamazon_max_links',			(int)@$form_vars['uamazon_max_links']);
update_option('uamazon_redirect_slug',		@$form_vars['uamazon_redirect_slug']);
update_option('uamazon_no_autokeywords',	(int)@$form_vars['uamazon_no_autokeywords']);
update_option('uamazon_site_keywords',		trim(@$form_vars['uamazon_site_keywords'], ','));
update_option('uamazon_links_display',		(int)@$form_vars['uamazon_links_display']);
update_option('uamazon_hide_rss_links',		(int)@$form_vars['uamazon_hide_rss_links']);

Uamazon_Admin::saveKeywordsToMainList($form_vars['uamazon_site_keywords'], 'manual');

$wpdb->query('UPDATE '.Uamazon_Base::$table['keyword'].' SET last_updated = 0');

if (!self::$form_errors)
{
	header('location: admin.php?page=uamazon&action=settings&saved=1');
	exit();
}

self::$action = 'settings';