	<form action="admin.php?page=<?php echo self::$name ?>&action=designer_save" method="POST">
<?php

require UAMAZON_APP_PATH.'/Uamazon_Form.php';

if (!count(self::$form_errors))
{
	self::$form_vars['uamazon_nofollow']			= get_option('uamazon_nofollow');
	self::$form_vars['uamazon_new_window']		= get_option('uamazon_new_window');
	self::$form_vars['uamazon_intext_class']		= get_option('uamazon_intext_class');
	self::$form_vars['uamazon_use_style']			= get_option('uamazon_use_style');
	self::$form_vars['uamazon_link_style']		= get_option('uamazon_link_style');
	self::$form_vars['uamazon_link_underline']	= get_option('uamazon_link_underline');
	self::$form_vars['uamazon_link_color']		= get_option('uamazon_link_color', '#009900');
}

Uamazon_Form::fadeSave();

Uamazon_Form::startTable();

Uamazon_Form::listErrors(self::$form_errors);

Uamazon_Form::section('Basic Settings');

Uamazon_Form::checkboxField('Use nofollow', 'form_vars[uamazon_nofollow]', self::$form_vars['uamazon_nofollow'], 'Includes "nofollow" attribute on links (anchor tags) created by this plug-in.');

Uamazon_Form::checkboxField('Open New Window', 'form_vars[uamazon_new_window]', self::$form_vars['uamazon_new_window'], 'Includes target="_blank" attribute on links (anchor tags) created by this plug-in.');

$extra = <<<END
<div style="width: 400px;">This is a style sheet class name to included on
all links (anchor tags) created by this plug-in.<br />
HTML will look like:<br />
<pre>&lt;a href="link_to_product" class="<b>your_css_class</b>"&gt;keyord_phrase&lt;/a&gt;</pre>
<a href="http://www.w3schools.com/css/" target="_blank">Click here for
more information about CSS</a><br />
</div>
END;

Uamazon_Form::textField('Anchor CSS Class', 'form_vars[uamazon_intext_class]', self::$form_vars['uamazon_intext_class'], 20, $extra);

Uamazon_Form::clearRow();

Uamazon_Form::section('Customize link');

Uamazon_Form::checkboxField('Use these settings', 'form_vars[uamazon_use_style]', self::$form_vars['uamazon_use_style'], 'Use the Style, Underline, and Link color settings below for in-text links.');

$style_list = array(
'Theme default',
'Bold',
'Italic',
'Bold Italic'
);

Uamazon_Form::selectField('Style', 'form_vars[uamazon_link_style]', self::$form_vars['uamazon_link_style'], $style_list);

$underline_list = array(
'Theme default',
'Single',
'Double'
);

Uamazon_Form::selectField('Underline', 'form_vars[uamazon_link_underline]', self::$form_vars['uamazon_link_underline'], $underline_list);

?>
		<tr>
			<th>Link color:</th>
			<td nowrap="nowrap">
				<input type="text" id="link_color" name="form_vars[uamazon_link_color]" size="12" value="<?= self::$form_vars['uamazon_link_color'] ?>" />
				<div class="caption">Leave blank for theme default</div>
			</td>
		</tr>
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

<script src="<?= UAMAZON_PLUGIN_URL ?>/includes/modcoder_excolor/jquery.modcoder.excolor.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery("#link_color").modcoder_excolor();
</script>