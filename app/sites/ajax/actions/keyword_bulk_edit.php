<?php

$_REQUEST['bulk_list'] = preg_replace('/[^0-9\,]+/is', '', $_REQUEST['bulk_list']);

$keyword_id_list = explode(',', $_REQUEST['bulk_list']);

$_REQUEST['keyword_id'] = array_shift($keyword_id_list);

$form_vars = $wpdb->get_row('SELECT * FROM '.self::$table['keyword'].' WHERE keyword_id = '.(int)$_REQUEST['keyword_id'], ARRAY_A);

?>

<div style="padding: 20px;">

<form id="uamazon_keyword_edit_form">
<input type="hidden" name="bulk_list" value="<?php echo $_REQUEST['bulk_list'] ?>" />
<?php

require UAMAZON_APP_PATH.'/Uamazon_Form.php';

function array_unshift_assoc($arr, $key, $val)
{
	$arr = array_reverse($arr, true);
	$arr[$key] = $val;
	return array_reverse($arr, true);
}

Uamazon_Form::fadeSave();

Uamazon_Form::startTable();

Uamazon_Form::checkboxField('Disable', 'disabled', @$form_vars['disabled']);

Uamazon_Form::textField('Customize Search', 'custom_search', @$form_vars['custom_search'], 50, 'Alternate keyword to be searched on Amazon.');

require UAMAZON_LIST_PATH.'/search_index_list.php';
$search_index_list = array_unshift_assoc($search_index_list, 'default', '-- Default Settings --');
Uamazon_Form::selectField('Default Category', 'search_index', @$form_vars['search_index'], $search_index_list);

require UAMAZON_LIST_PATH.'/condition_list.php';
$condition_list = array_unshift_assoc($condition_list, 'default', '-- Default Settings --');
Uamazon_Form::selectField('Default Condition', 'condition', @$form_vars['condition'], $condition_list);

?>
	<tr>
		<td colspan="2"><div id="uamazon_search_results"></div></td>
	</tr>
	<tr>
		<td colspan="2">
			<input id="uamazon_save_button" type="button" class="uamazon_button" value="Save" />&nbsp;
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){

	<?php if (@$_REQUEST['bulk_list']){ ?>
	jQuery.get('<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_search&keyword_id=<?php echo @$_REQUEST['bulk_list'] ?>', function(data) {
		jQuery('#uamazon_search_results').html(data);
	});
	<?php } ?>

	jQuery('#uamazon_save_button').click( function() {
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_bulk_save&bulk_list=<?php echo @$_REQUEST['bulk_list'] ?>',
			data: jQuery('#uamazon_keyword_edit_form').serialize(),
			dataType: 'json',
			success: function( response ){
				jQuery.get('<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_search&keyword_id=<?php echo @$_REQUEST['bulk_list'] ?>', function(data) {
					jQuery('#uamazon_search_results').html(data);
				});
				uamazon_fadeSaved("uamazon_saved");
			}
		});
	});
});
</script>
</div>