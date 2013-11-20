<form action="admin.php?page=<?php echo self::$name ?>&action=designer_save" method="POST">
<?php

require UCONTEXT4A_APP_PATH.'/Ucontext4a_Form.php';

if (!count(self::$form_errors))
{
	self::$form_vars['ucontext4a_nofollow']			= get_option('ucontext4a_nofollow');
	self::$form_vars['ucontext4a_new_window']		= get_option('ucontext4a_new_window');
	self::$form_vars['ucontext4a_intext_class']		= get_option('ucontext4a_intext_class');
	self::$form_vars['ucontext4a_use_style']			= get_option('ucontext4a_use_style');
	self::$form_vars['ucontext4a_link_style']		= get_option('ucontext4a_link_style');
	self::$form_vars['ucontext4a_link_underline']	= get_option('ucontext4a_link_underline');
	self::$form_vars['ucontext4a_link_color']		= get_option('ucontext4a_link_color', '#009900');
}

Ucontext4a_Form::fadeSave();

Ucontext4a_Form::startTable();

Ucontext4a_Form::listErrors(self::$form_errors);

Ucontext4a_Form::section('Basic Settings');

Ucontext4a_Form::checkboxField('Use nofollow', 'form_vars[ucontext4a_nofollow]', self::$form_vars['ucontext4a_nofollow'], 'Includes "nofollow" attribute on links (anchor tags) created by this plug-in.');

Ucontext4a_Form::checkboxField('Open New Window', 'form_vars[ucontext4a_new_window]', self::$form_vars['ucontext4a_new_window'], 'Includes target="_blank" attribute on links (anchor tags) created by this plug-in.');

$extra = <<<END
<div style="width: 400px;">This is a style sheet class name to included on
all links (anchor tags) created by this plug-in.<br />
HTML will look like:<br />
<pre>&lt;a href="link_to_product" class="<b>your_css_class</b>"&gt;keyord_phrase&lt;/a&gt;</pre>
<a href="http://www.w3schools.com/css/" target="_blank">Click here for
more information about CSS</a><br />
</div>
END;

Ucontext4a_Form::textField('Anchor CSS Class', 'form_vars[ucontext4a_intext_class]', self::$form_vars['ucontext4a_intext_class'], 20, $extra);

Ucontext4a_Form::clearRow();

Ucontext4a_Form::section('Customize link');

require dirname(__FILE__).'/designer_style.php';

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