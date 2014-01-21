	<form action="admin.php?page=uamazon&action=settings_save" method="POST">
<?php

require UAMAZON_APP_PATH.'/Uamazon_Form.php';

Uamazon_Form::fadeSave();

Uamazon_Form::startTable();

Uamazon_Form::listErrors(self::$form_errors);

Uamazon_Form::section('Amazon Settings');

Uamazon_Form::textField('Associate Tag', 'form_vars[uamazon_associate_tag]', @get_option('uamazon_associate_tag'), NULL, 'Your Amazon Affiliate/Associate Tag from <a href="https://affiliate-program.amazon.com/gp/associates/network/main.html" target="_blank">click here...</a>', TRUE);

Uamazon_Form::textField('Access Key ID', 'form_vars[uamazon_public_key]', @get_option('uamazon_public_key'), NULL, 'Your Amazon Access Key ID from <a href="https://portal.aws.amazon.com/gp/aws/securityCredentials" target="_blank">click here...</a>', TRUE);

Uamazon_Form::textField('Secret Access Key', 'form_vars[uamazon_private_key]', @get_option('uamazon_private_key'), NULL, 'Your Amazon Secret Access Key from <a href="https://portal.aws.amazon.com/gp/aws/securityCredentials" target="_blank">click here...</a>', TRUE);

require UAMAZON_LIST_PATH.'/amazon_site_list.php';
Uamazon_Form::selectField('Amazon Site', 'form_vars[uamazon_amazon_site]', @get_option('uamazon_amazon_site', 'US'), $amazon_site_list);

require UAMAZON_LIST_PATH.'/search_index_list.php';
Uamazon_Form::selectField('Default Category', 'form_vars[uamazon_dflt_search_index]', @get_option('uamazon_dflt_search_index'), $search_index_list);

require UAMAZON_LIST_PATH.'/condition_list.php';
Uamazon_Form::selectField('Default Condition', 'form_vars[uamazon_dflt_condition]', @get_option('uamazon_dflt_condition'), $condition_list);

Uamazon_Form::clearRow();
Uamazon_Form::section('General Settings');

$max_links_list = array();
for ($i = 1; $i <= 25; $i++)
{
	$max_links_list[$i] = $i;
}
Uamazon_Form::selectField('Max. Number of Links', 'form_vars[uamazon_max_links]', @get_option('uamazon_max_links', 5), $max_links_list);

Uamazon_Form::textField('Redirect Slug', 'form_vars[uamazon_redirect_slug]', @get_option('uamazon_redirect_slug', 'recommends'), NULL, 'The affiliate link slug. Letters, numbers, dashes, and underscores only.<br /><br />For example: <strong>http://www.mydomain.com/recommends</strong><br />...where "recommends" is the slug.', TRUE);

Uamazon_Form::checkboxField('Disable Auto-Keywords', 'form_vars[uamazon_no_autokeywords]', @get_option('uamazon_no_autokeywords', 0), 'If you don\'t want this plugin to find keywords for you, check this box.  When checked, only manually entered keywords will be used.');

Uamazon_Form::clearRow();
Uamazon_Form::section('Optional Settings');

Uamazon_Form::textareaField('Site-wide Keywords', 'form_vars[uamazon_site_keywords]', @get_option('uamazon_site_keywords'), 2, 65, 'Comma separated list of site-wide keywords you would like uContext for Amazon to consider in all posts/pages');

$display_list = array(
'Pages &amp; Posts',
'Posts only',
'Pages only'
);

Uamazon_Form::selectField('Show Links on', 'form_vars[uamazon_links_display]', @get_option('uamazon_links_display'), $display_list);

Uamazon_Form::checkboxField('No Links in RSS', 'form_vars[uamazon_hide_rss_links]', @get_option('uamazon_hide_rss_links'), 'Check this box to remove uContext for Amazon links from your standard RSS feed');

?>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="button-primary action" value="Save" />
			</td>
		</tr>
	</table>

	</form>
