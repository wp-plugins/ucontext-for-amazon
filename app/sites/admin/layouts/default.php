<script type="text/javascript">

function uamazon_fadeSaved(id)
{
	jQuery('#' + id).show();
	jQuery('#' + id).fadeOut(2000);
}

</script>

<div id="uamazon_admin">

	<img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/images/logo.png" width="200" height="58" border="0" alt="uContext for Amazon" style="float: left;" /> <div style="float: left; width: 100px;"><strong>v<?php echo UAMAZON_VERSION ?></strong></div>
	<div style="clear: both;"></div>
<?php

if (version_compare(UAMAZON_VERSION, get_option('uamazon_latest_version', UAMAZON_VERSION), '<'))
{
	echo '<div style="color: #900;">A new version is available <a href="http://ucontext.com/members/" target="_blank">here</a></div>';
}

?>
	<br />
	<table id="uamazon_layout_table" style="width: 99%;">
	<tr>
		<td>
			<ul id="uamazon_nav_tabs">
				<li<?php if (self::$action == 'keywords'){ echo ' class="selected"'; } ?>><a href="admin.php?page=<?= self::$name ?>&action=keywords"><img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/icons/application_side_list.png" width="16" height="16" border="0" />Keywords</a></li>
				<li<?php if (self::$action == 'reports'){ echo ' class="selected"'; } ?>><a href="admin.php?page=<?= self::$name ?>&action=reports"><img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/icons/chart_bar.png" width="16" height="16" border="0" />Reports</a></li>
				<li<?php if (self::$action == 'designer'){ echo ' class="selected"'; } ?>><a href="admin.php?page=<?= self::$name ?>&action=designer"><img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/icons/palette.png" width="16" height="16" border="0" />Link Designer</a></li>
				<li<?php if (self::$action == 'settings'){ echo ' class="selected"'; } ?>><a href="admin.php?page=<?= self::$name ?>&action=settings"><img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/icons/cog.png" width="16" height="16" border="0" />Settings</a></li>
				<li<?php if (self::$action == 'help'){ echo ' class="selected"'; } ?>><a href="admin.php?page=<?= self::$name ?>&action=help');"><img src="<?php echo UAMAZON_PLUGIN_URL ?>/includes/icons/help.png" width="16" height="16" border="0" />Help</a></li>
			</ul>
			<div id="uamazon_view_wrapper">
				<div id="uamazon_view_box">
					<div style="margin: 15px;">
					<?php require($view_path); ?>
					</div>
				</div>
				<div id="uamazon_spacer"></div>
				<div style="clear: both;"></div>
			</div>

			<p>
				<center><a href="http://ucontext.com">uContext</a>, a <a href="http://summitmediaconcepts.com">Summit Media Concepts LLC</a> business, is not affiliated with <a href="http://amazon.com">Amazon.com, Inc.</a></center>
			</p>
		</td>
	</tr>
	</table>
</div>