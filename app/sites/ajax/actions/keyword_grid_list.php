<?php

$limit = 10;

$page = '';
$result = '';
$search_exp = '';

if (isset($_REQUEST['p']))
{
	$page = (int)$_REQUEST['p'];
}

if (!$page)
{
	$page = 1;
}

if (isset($_REQUEST['search']) && trim($_REQUEST['search']))
{
	$search = trim(strtolower($_REQUEST['search']));

	if ($search)
	{
		$search_exp = ' WHERE keyword LIKE "%'.$search.'%"';
	}
}

$start = ($page - 1) * $limit;

//$sql = '
//SELECT
//	*
//FROM
//	'.self::$table['keyword'].'
//'.$search_exp.'
//ORDER BY
//	keyword
//LIMIT
//	'.$start.', '.$limit;

$sql = '
SELECT
	*
FROM
	'.self::$table['keyword'].'
'.$search_exp.'
ORDER BY
	keyword';

$keyword_list = $wpdb->get_results($sql, ARRAY_A);

ob_end_clean();

if ($keyword_list)
{
	foreach ($keyword_list as $keyword)
	{
		$icon = '';

		if ($keyword['disabled'])
		{
			$icon = '<img src="'.UAMAZON_PLUGIN_URL.'/includes/icons/bullet_red.png" width="16" height="16" alt="Disabled" style="float: right; margin: 0 0 0 5px;" />';
		}
		elseif ($keyword['last_updated'] && !$keyword['num_results'])
		{
			$icon = '<img src="'.UAMAZON_PLUGIN_URL.'/includes/icons/bullet_error.png" width="16" height="16" alt="No search results" style="float: right; margin: 0 0 0 5px;" />';
		}

		$result .=<<<END
<table width="100%" cellspacing="0" cellpadding="0" class="uamazon_list_table">
<tr>
	<td width="1%"><input type="checkbox" name="keyword_list[{$keyword['keyword_id']}]" value="{$keyword['keyword_id']}" /></td>
	<td onclick="AZL_editKeyword({$keyword['keyword_id']})">{$keyword['keyword']}{$icon}</td>
</tr>
</table>
END;
	}
}
else
{
	$result .=<<<END
<table width="100%" cellspacing="0" cellpadding="0" class="uamazon_list_table">
<tr>
	<td colspan="2"><br /><center><strong>No keywords found yet</strong></center><br /></td>
</tr>
</table>
END;
}

exit('<form id="uamazon_keyword_list_form">'.$result.'</form>');