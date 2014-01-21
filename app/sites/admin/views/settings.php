<form action="admin.php?page=<?php echo self::$name ?>&action=settings_save" method="POST">
<?php

require UCONTEXT4A_APP_PATH.'/Ucontext4a_Form.php';

Ucontext4a_Form::fadeSave();

Ucontext4a_Form::startTable();

Ucontext4a_Form::listErrors(self::$form_errors);

@include UCONTEXT4A_INTEGRATION_PATH.'/admin/snippets/settings.php';

Ucontext4a_Form::clearRow();
Ucontext4a_Form::section('Link Settings');

$max_links_list = array();
for ($i = 1; $i <= 25; $i++)
{
	$max_links_list[$i] = $i;
}
Ucontext4a_Form::selectField('Max. Number of Links', 'form_vars[ucontext4a_max_links]', @get_option('ucontext4a_max_links', 5), $max_links_list);

$display_list = array(
'Pages &amp; Posts',
'Posts only',
'Pages only'
);

Ucontext4a_Form::selectField('Show Links on', 'form_vars[ucontext4a_links_display]', @get_option('ucontext4a_links_display'), $display_list);

Ucontext4a_Form::checkboxField('No Links in RSS', 'form_vars[ucontext4a_hide_rss_links]', @get_option('ucontext4a_hide_rss_links'), 'Check this box to remove uContext links from your standard RSS feed');

Ucontext4a_Form::checkboxField('Disable Auto-Keywords', 'form_vars[ucontext4a_no_autokeywords]', @get_option('ucontext4a_no_autokeywords', 0), 'If you don\'t want this plugin to find keywords for you, check this box.  When checked, only manually entered keywords will be used.');

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