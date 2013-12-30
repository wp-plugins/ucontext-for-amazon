<?php

if (!strlen(trim($form_vars['ucontext4a_associate_tag'])))
{
	$form_vars['ucontext4a_associate_tag'] = @get_option('ucontext4a_associate_tag');
}

if (!strlen(trim($form_vars['ucontext4a_associate_tag'])))
{
	self::$form_errors['ucontext4a_associate_tag'] = 'Your Amazon Associate Tag is required';
}

//===

if (!strlen(trim($form_vars['ucontext4a_public_key'])))
{
	$form_vars['ucontext4a_public_key'] = @get_option('ucontext4a_public_key');
}

if (!strlen(trim($form_vars['ucontext4a_public_key'])))
{
	self::$form_errors['ucontext4a_public_key'] = 'Your Amazon Access Key ID is required';
}

//===

if (!strlen(trim($form_vars['ucontext4a_private_key'])))
{
	$form_vars['ucontext4a_private_key'] = @get_option('ucontext4a_private_key');
}

if (!strlen(trim($form_vars['ucontext4a_private_key'])))
{
	self::$form_errors['ucontext4a_private_key'] = 'Your Amazon Secret Access Key is required';
}

update_option('ucontext4a_associate_tag',		trim(@$form_vars['ucontext4a_associate_tag']));
update_option('ucontext4a_public_key',		trim(@$form_vars['ucontext4a_public_key']));
update_option('ucontext4a_private_key',		trim(@$form_vars['ucontext4a_private_key']));
update_option('ucontext4a_amazon_site',		trim(@$form_vars['ucontext4a_amazon_site']));
update_option('ucontext4a_dflt_search_index',	trim(@$form_vars['ucontext4a_dflt_search_index']));
update_option('ucontext4a_dflt_condition',	trim(@$form_vars['ucontext4a_dflt_condition']));