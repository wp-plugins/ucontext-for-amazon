<?php

$keyword = NULL;

$response = array('success' => true);

$form_vars['disabled']		= (int)@$_POST['disabled'];
$form_vars['custom_search']	= stripslashes(trim(@$_POST['custom_search']));
$form_vars['search_index']	= trim(@$_POST['search_index']);
$form_vars['condition']		= trim(@$_POST['condition']);
$form_vars['aws_asin']		= trim(@$_POST['aws_asin']);

if (!$form_vars['custom_search'])
{
	$response = array('success' => false, 'error' => 'Custom Search is required');
}

if ($response['success'] == true && trim($_POST['bulk_list']))
{
	$sql = '
	UPDATE
		`'.self::$table['keyword'].'`
	SET
		`disabled`		= '.(int)$form_vars['disabled'].',
		`custom_search`	= "'.$wpdb->escape($form_vars['custom_search']).'",
		`search_index`	= "'.$wpdb->escape($form_vars['search_index']).'",
		`condition`		= "'.$wpdb->escape($form_vars['condition']).'",
		`aws_asin`		= "'.$wpdb->escape($form_vars['aws_asin']).'"
	WHERE
		`keyword_id` IN ('.$_POST['bulk_list'].')';
	
	$wpdb->query($sql);
}

exit(json_encode($response));