<div style="padding: 20px;">
<?php

require UAMAZON_APP_PATH.'/Uamazon_Form.php';

if (isset($_REQUEST['keyword_id']) && (int)$_REQUEST['keyword_id'])
{
	$form_vars = $wpdb->get_row('SELECT * FROM '.self::$table['keyword'].' WHERE keyword_id = '.(int)$_REQUEST['keyword_id'], ARRAY_A);
}

if (!@$form_vars['custom_search'] && @$form_vars['keyword'])
{
	$form_vars['custom_search'] = $form_vars['keyword'];
}

?>
<form id="uamazon_keyword_edit_form">
<?php

function array_unshift_assoc($arr, $key, $val)
{
	$arr = array_reverse($arr, true);
	$arr[$key] = $val;
	return array_reverse($arr, true);
}

Uamazon_Form::fadeSave();

Uamazon_Form::startTable();

Uamazon_Form::textField('Keyword', 'keyword', @$form_vars['keyword'], 50);

Uamazon_Form::checkboxField('Disable', 'disabled', @$form_vars['disabled'], 'Disables this keyword site-wide');

Uamazon_Form::textField('Customize Search', 'custom_search', @$form_vars['custom_search'], 50, 'Alternate keyword to be searched on Amazon.');

require UAMAZON_LIST_PATH.'/search_index_list.php';
$search_index_list = array_unshift_assoc($search_index_list, 'default', '-- Default Category --');
Uamazon_Form::selectField('Category', 'search_index', @$form_vars['search_index'], $search_index_list);

require UAMAZON_LIST_PATH.'/condition_list.php';
$condition_list = array_unshift_assoc($condition_list, 'default', '-- Default Condition --');
Uamazon_Form::selectField('Condition', 'condition', @$form_vars['condition'], $condition_list);

?>
	<tr>
		<td colspan="2"><div id="uamazon_search_results"></div></td>
	</tr>
	<tr>
		<td colspan="2">
			<input id="uamazon_save_button" type="button" class="uamazon_button" value="Save" />&nbsp;
			<?php if ((int)@$form_vars['keyword_id']){ ?>
			<input id="uamazon_delete_button" type="button" class="uamazon_button" value="Delete" onclick="AZL_deleteKeyword(<?php echo (int)@$form_vars['keyword_id'] ?>)" />
			<?php } ?>
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
jQuery(document).ready(function(){

	<?php if ((int)@$form_vars['keyword_id']){ ?>
	jQuery.get('<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_search&keyword_id=<?php echo (int)@$form_vars['keyword_id'] ?>', function(data) {
		jQuery('#uamazon_search_results').html(data);
	});
	<?php } ?>

	jQuery('#uamazon_save_button').click( function() {
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_save&keyword_id=<?php echo (int)@$form_vars['keyword_id'] ?>',
			data: jQuery('#uamazon_keyword_edit_form').serialize(),
			dataType: 'json',
			success: function( response ) {
				if (response.success == false)
				{
					if (response.error != null && response.error != '')
					{
						alert(response.error);
					}
					else
					{
						alert('There was an error. Please check your information.');
					}
				}
				else
				{
					if (response.keyword_id != null && response.keyword_id > 0)
					{
						AZL_editKeyword(response.keyword_id, 1);

						if (response.new_keyword == true || response.refresh_list == true)
						{
							AZL_loadKeywordList('');
						}
					}
					else
					{
						alert('There was an error. Please check your information.');
					}
				}
      		}
		});
	});

	jQuery('#uamazon_delete_button').click( function() {
		jQuery.ajax({
			type: 'POST',
			url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_delete&keyword_id=<?php echo (int)@$form_vars['keyword_id'] ?>',
			dataType: 'json',
			success: function( response ) {
				if (response.success == false)
				{
					if (response.error != null && response.error != '')
					{
						alert(response.error);
					}
					else
					{
						alert('There was an error. Please check your information.');
					}
				}
				else
				{
					jQuery('#uamazon_keyword_edit').html('');
					AZL_loadKeywordList('');
				}
	  		}
		});
	});
});
</script>
</div>