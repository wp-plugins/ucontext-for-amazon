<!--

- list manual and found keywords
	- icon to identify each
	- ability to disable keywords

- manual keywords take precedence
	- find keywords on submission
	- auto-search amazon for links

- pop-over UI to add/edit keyword
	- amazon search w/ button to "use"
	- search by top browser nodes

- post/page editor icon to create direct link
	- use keyword search UI

actions
- amazon_search
- keyword_save

-->

<table id="uamazon_keyword_viewport" cellpadding="0" cellspacing="5">
<tr class="uamazon_toolbar">
	<td colspan="2">
		<div class="uamazon_button" onclick="AZL_editKeyword(0);"><img src="<?php echo UAMAZON_PLUGIN_URL.'/includes/icons/add.png' ?>" width="16" height="16" alt="" /> Add Keyword</div>
		<div class="uamazon_button" onclick="AZL_bulkEditSelectedKeywords();"><img src="<?php echo UAMAZON_PLUGIN_URL.'/includes/icons/pencil.png' ?>" width="16" height="16" alt="" /> Bulk Edit</div>
		<div class="uamazon_button" onclick="AZL_disableSelectedKeywords();"><img src="<?php echo UAMAZON_PLUGIN_URL.'/includes/icons/bullet_red.png' ?>" width="16" height="16" alt="" /> Disable Selected</div>
		<div class="uamazon_button" onclick="AZL_deleteSelectedKeywords();"><img src="<?php echo UAMAZON_PLUGIN_URL.'/includes/icons/delete.png' ?>" width="16" height="16" alt="" /> Delete Selected</div>
	</td>
</tr>
<tr>
	<td style="height: 1%;">
		<form>
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td style="width: 98%;"><input type="text" name="search" id="uamazon_keyword_search" /></td>
				<td><input type="button" value="Search" class="uamazon_button" id="uamazon_keyword_search_button" /></td>
				<td style="padding-left: 5px;"><input type="button" value="Clear" class="uamazon_button" id="uamazon_keyword_clear_button" /></td>
			</tr>
			</table>
		</form>
	</td>
	<td id="uamazon_keyword_edit_td" rowspan="2"><div id="uamazon_keyword_edit"></div></td>
</tr>
<tr>
	<td id="uamazon_keyword_list_td"><div id="uamazon_keyword_list"></div></td>
</tr>
</table>

<script type="text/javascript">

var ajax_url = '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action';

jQuery(document).ready(function(){
	AZL_loadKeywordList('');

	jQuery('#uamazon_keyword_search').keypress(function(e){
		if (e.which == 13){
			e.preventDefault();
			AZL_doSearch();
		}
	});	

	jQuery('#uamazon_keyword_search_button').click(function(){
		AZL_doSearch();
	});	

	jQuery('#uamazon_keyword_clear_button').click(function(){
		jQuery('#uamazon_keyword_search').val('');

		AZL_loadKeywordList('');
	});	
});

function AZL_doSearch()
{
	AZL_loadKeywordList(jQuery('#uamazon_keyword_search').val());
}

function AZL_editKeyword(keyword_id, saved)
{
	if (saved == null || saved == '')
	{
		saved = 0;
	}

	AZL_mask('uamazon_keyword_edit');
	jQuery.get(ajax_url + '&do=keyword_edit&keyword_id=' + keyword_id + '&saved=' + parseInt(saved), function(data) {
		jQuery('#uamazon_keyword_edit').html(data);
	});
}

function AZL_deleteKeyword(keyword_id)
{
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_delete&keyword_id=' + keyword_id,
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
}

function AZL_disableSelectedKeywords()
{
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_disable',
		dataType: 'json',
		data: jQuery('#uamazon_keyword_list_form').serialize(),
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
}

function AZL_deleteSelectedKeywords()
{
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo admin_url( 'admin-ajax.php' ) ?>?action=uamazon_action&do=keyword_delete',
		dataType: 'json',
		data: jQuery('#uamazon_keyword_list_form').serialize(),
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
}

function AZL_bulkEditSelectedKeywords()
{
	AZL_mask('uamazon_keyword_edit');

	var bulk_list = [];

	jQuery('#uamazon_keyword_list_form input:checked').each(function(index, value) {
		bulk_list.push(jQuery(this).val());
	});

	jQuery.get(ajax_url + '&do=keyword_bulk_edit&bulk_list=' + bulk_list.join(','), function(data) {
		jQuery('#uamazon_keyword_edit').html(data);
	});
}

function AZL_loadKeywordList(search)
{
	AZL_mask('uamazon_keyword_list');
	jQuery.get(ajax_url + '&do=keyword_grid_list&search=' + search, function(data) {
		jQuery('#uamazon_keyword_list').html(data);
	});
}

function AZL_mask(id)
{
	jQuery('#' + id).html('<div class="uamazon_loader" style="line-height: ' + jQuery('#' + id).height() + 'px;"><img src="<?php echo UAMAZON_PLUGIN_URL.'/includes/images/ajax-loading.gif'; ?>" width="220" height="19" alt="Loading..." /></div>');
}

</script>