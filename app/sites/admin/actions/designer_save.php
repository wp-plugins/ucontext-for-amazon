<?php

$form_vars = self::$form_vars;

update_option('uamazon_nofollow',		(int)@$form_vars['uamazon_nofollow']);
update_option('uamazon_new_window',		(int)@$form_vars['uamazon_new_window']);
update_option('uamazon_intext_class',	trim(@$form_vars['uamazon_intext_class']));
update_option('uamazon_use_style',		(int)@$form_vars['uamazon_use_style']);
update_option('uamazon_link_style',		(int)@$form_vars['uamazon_link_style']);
update_option('uamazon_link_underline',	(int)@$form_vars['uamazon_link_underline']);
update_option('uamazon_link_color',		trim(@$form_vars['uamazon_link_color']));

if (!self::$form_errors)
{
	if ((int)$form_vars['uamazon_use_style'])
	{
		$parts = array();

		$underline_width = 1;

		switch ((int)$form_vars['uamazon_link_style'])
		{
			case 1:
				$parts[] = 'font-weight: bold;';
				$underline_width = 2;
				break;
			case 2:
				$parts[] = 'font-style: italic;';
				break;
			case 3:
				$parts[] = 'font-weight: bold;';
				$parts[] = 'font-style: italic;';
				$underline_width = 2;
				break;
		}

		switch ((int)$form_vars['uamazon_link_underline'])
		{
			case 1:
				$parts[] = 'text-decoration: underline;';
				break;
			case 2:
				$parts[] = 'padding-bottom: 1px;';
				$parts[] = 'text-decoration: underline;';
				$parts[] = 'border-bottom: '.$underline_width.'px solid '.trim($form_vars['uamazon_link_color']).';';
				break;
		}

		$parts[] = 'color: '.trim($form_vars['uamazon_link_color']).';';

		$link_css = 'a.uamazon {'.implode(' ', $parts).'}';

		update_option('uamazon_link_css', $link_css);
		update_option('uamazon_intext_class', 'uamazon');

	}

	header('location: admin.php?page='.self::$name.'&action=designer&saved=1');
	exit();
}

self::$action = 'designer';