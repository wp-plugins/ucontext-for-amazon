<?php

/*
 Summary
 - Clicks this month
 - Clicks this year
 - All time

Page Report (Top 10)
- Page title
- Page URL
- # of clicks

Keyword Report (Top 25)
- Keyword phrase
- # of clicks

Monthly Report
clicks by type with total column

Daily Report
show days of current month with counts

Days of Week Report

Time of Day Report

*/

$cache = array(
'keywords'	=> array(),
'yearly'	=> array(),
'weekly'	=> array(),
'daily'		=> array(),
'hourly'	=> array()
);

$site_id = (int)@$_REQUEST['site_id'];

$year = (int)@$_REQUEST['yr'];
$month = (int)@$_REQUEST['mn'];

if (!$year)
{
	$year = date('Y', time());
}

if (!$month)
{
	$month = date('n', time());
}

$t_prev_month = mktime(0, 0, 0, $month-1, 1, $year);
$prev_year = date('Y', $t_prev_month);
$prev_month = date('n', $t_prev_month);

if (mktime(0, 0, 0, $month, 1, $year) < mktime(0, 0, 0, date('n', time()), 1, date('Y', time())))
{
	$t_next_month = mktime(0, 0, 0, $month+1, 1, $year);
	$next_year = date('Y', $t_next_month);
	$next_month = date('n', $t_next_month);
}

$month_list[1] = 'Jan';
$month_list[2] = 'Feb';
$month_list[3] = 'Mar';
$month_list[4] = 'Apr';
$month_list[5] = 'May';
$month_list[6] = 'Jun';
$month_list[7] = 'Jul';
$month_list[8] = 'Aug';
$month_list[9] = 'Sep';
$month_list[10] = 'Oct';
$month_list[11] = 'Nov';
$month_list[12] = 'Dec';

$weekday_list[0] = 'Sun';
$weekday_list[1] = 'Mon';
$weekday_list[2] = 'Tue';
$weekday_list[3] = 'Wed';
$weekday_list[4] = 'Thu';
$weekday_list[5] = 'Fri';
$weekday_list[6] = 'Sat';


function horiz_bar_graph($bar_list, $max_count, $max_width)
{
	$result = "\n";

	$color_list[] = '#fe5855';
	$color_list[] = '#3a7cd9';
	$color_list[] = '#69aa6f';
//	$color_list[] = '#F55';
//	$color_list[] = '#DB3';
//	$color_list[] = '#2A9';

	foreach ($bar_list as $row => $bar)
	{
		$width = 0;
		if ((int)$max_count)
		{
			$width = (int)$max_width * (int)$bar / (int)$max_count;
			// echo "$width = $max_width * $bar / $max_count<br>";
		}

		$color = $color_list[$row];

		$result .= '<img src="'.UAMAZON_PLUGIN_URL.'/includes/images/s.gif" width="'.(int)$width.'" height="5" style="background-color: '.$color.'; margin: 0; padding: 0;" />'."\n";
	}

	return $result;
}

//$cache_dir = CACHE_PATH . '/report_data/' . (int)App::$owner_account['account_id'];
//
//if (!is_dir(@$cache_dir))
//{
//	@mkdir(@$cache_dir, 0775, TRUE);
//}
//
//$cache_path = @$cache_dir.'/'.(int)$_REQUEST['site_id'].'_report_main_'.$year.'_'.$month.'.dat';
//
//if (filemtime(@$cache_path) > (time() - 3600))
//{
//	@$cache = unserialize(file_get_contents(@$cache_path));
//}
//else
//{
	$sql = '
	SELECT
		`keyword`,
		COUNT(*) AS total
	FROM
		'.self::$table['click_log'].'
	WHERE
		`keyword` != ""
	AND
		spider = 0
	AND
		month = '.(int)$month.'
	AND
		year = '.(int)$year.'
	GROUP BY
		`keyword`
	ORDER BY
		`total` DESC
	LIMIT
		10';

	$result_list = $wpdb->get_results($sql, ARRAY_A);
	foreach ($result_list as $record)
	{
		@$cache['keywords'][$record['keyword']]['total'] += (int)$record['total'];
	}

	$sql = '
	SELECT
		`year`,
		`month`,
		`day`,
		`weekday`,
		`hour`,
		`spider`,
		COUNT(*) AS total
	FROM
		'.self::$table['click_log'].'
	WHERE
		month = '.(int)$month.'
	AND
		year = '.(int)$year.'
	GROUP BY
		`year`,
		`month`,
		`day`,
		`weekday`,
		`hour`,
		`spider`
	ORDER BY
		`year`,
		`month`,
		`day`,
		`weekday`,
		`hour`';

	$result_list = $wpdb->get_results($sql, ARRAY_A);
	foreach ($result_list as $record)
	{
		$y	= (int)$record['year'];
		$m	= (int)$record['month'];
		$wd	= (int)$record['weekday'];
		$d	= (int)$record['day'];
		$h	= (int)$record['hour'];

		if ($record['spider'])
		{
			@$cache['weekly'][$y][$m][$wd]['spider']	+= (int)$record['total'];
			@$cache['daily'][$y][$m][$d]['spider']	+= (int)$record['total'];
			@$cache['hourly'][$y][$m][$h]['spider']	+= (int)$record['total'];
		}
		else
		{
			@$cache['weekly'][$y][$m][$wd]['human']	+= (int)$record['total'];
			@$cache['daily'][$y][$m][$d]['human']	+= (int)$record['total'];
			@$cache['hourly'][$y][$m][$h]['human']	+= (int)$record['total'];
		}

		@$cache['weekly'][$y][$m][$wd]['total']		+= (int)$record['total'];
		@$cache['daily'][$y][$m][$d]['total']		+= (int)$record['total'];
		@$cache['hourly'][$y][$m][$h]['total']		+= (int)$record['total'];
	}

	$sql = '
	SELECT
		`year`,
		`month`,
		`spider`,
		COUNT(*) AS total
	FROM
		'.self::$table['click_log'].'
	GROUP BY
		`year`,
		`month`,
		`spider`
	ORDER BY
		`year`,
		`month`';

	$result_list = $wpdb->get_results($sql, ARRAY_A);
	foreach ($result_list as $record)
	{
		$y	= (int)$record['year'];
		$m	= (int)$record['month'];

		if ($record['spider'])
		{
			@$cache['yearly'][$y]['spider']			+= (int)$record['total'];
			@$cache['monthly'][$y][$m]['spider']		+= (int)$record['total'];
		}
		else
		{
			@$cache['yearly'][$y]['human']			+= (int)$record['total'];
			@$cache['monthly'][$y][$m]['human']		+= (int)$record['total'];
		}

		@$cache['yearly'][$y]['total']				+= (int)$record['total'];
		@$cache['monthly'][$y][$m]['total']			+= (int)$record['total'];
	}

	if (is_array(@$cache['weekly'][(int)$year][(int)$month]))
	{
		foreach (@$cache['weekly'][(int)$year][(int)$month] as $weekday => $info)
		{
			if (@$cache['weekly'][(int)$year][(int)$month]['max'] < $info['total'])
			{
				@$cache['weekly'][(int)$year][(int)$month]['max'] = $info['total'];
			}
		}
	}

	if (is_array(@$cache['daily'][(int)$year][(int)$month]))
	{
		foreach (@$cache['daily'][(int)$year][(int)$month] as $day => $info)
		{
			if (@$cache['daily'][(int)$year][(int)$month]['max'] < $info['total'])
			{
				@$cache['daily'][(int)$year][(int)$month]['max'] = $info['total'];
			}
		}
	}

	if (is_array(@$cache['hourly'][(int)$year][(int)$month]))
	{
		foreach (@$cache['hourly'][(int)$year][(int)$month] as $hour => $info)
		{
			if (@$cache['hourly'][(int)$year][(int)$month]['max'] < $info['total'])
			{
				@$cache['hourly'][(int)$year][(int)$month]['max'] = $info['total'];
			}
		}
	}

//	file_put_contents(@$cache_path, serialize(@$cache));
//}

?>
<br />

<div style="width: 800px; height: 22px; border-bottom: 1px solid #333;">
	<div style="width: 33%; float: left;"><a href="admin.php?page=uamazon&action=reports&mn=<?= $prev_month ?>&yr=<?= $prev_year ?>">&lt;&lt; <?= $month_list[$prev_month].' '.$prev_year ?></a></div>
	<div style="font-size: 18px; font-weight: bold; width: 33%; float: left; text-align: center;"><?= $month_list[$month].' '.$year ?></div>
	<?php if (@$next_month){ ?>
	<div style="width: 33%; float: right; text-align: right;"><a href="admin.php?page=uamazon&action=reports&mn=<?= $next_month ?>&yr=<?= $next_year ?>"><?= $month_list[$next_month].' '.$next_year ?> &gt;&gt;</a></div>
	<?php } ?>
	<div class="clearBoth"></div>
</div>

<br />

<h2>Daily History</h2>
<table cellspacing="1" class="uamazon_report_table">
	<tr>
		<td class="column_label" width="65">Day</td>
		<td class="column_label" width="65" style="background-color: #fe5855;">Clicks</td>
		<td class="column_label" width="65" style="background-color: #3a7cd9;">Spiders</td>
		<td class="column_label" width="65" style="background-color: #69aa6f;">Total</td>
		<td>&nbsp;</td>
	</tr>
<?php
$row = 0;
for ($i = 1; $i <= date('j', mktime(0, 0, 0, $month+1, 0, $year)); $i++)
{
	$row++;

	$row_class = '';
	if (!($row % 2))
	{
		$row_class = ' class="alt_row"';
	}

	$bar_list = array(
		@$cache['daily'][$year][$month][$i]['human'],
		@$cache['daily'][$year][$month][$i]['spider'],
		@$cache['daily'][$year][$month][$i]['total']
	);

	$graph = horiz_bar_graph($bar_list, @$cache['daily'][(int)$year][(int)$month]['max'], 100);
?>
	<tr<?= $row_class ?>>
		<td class="row_label"><?= $month_list[$month].' '.sprintf('%02d', $i) ?></td>
		<td class="right"><?= (int)@$cache['daily'][$year][$month][$i]['human'] ?></td>
		<td class="right"><?= (int)@$cache['daily'][$year][$month][$i]['spider'] ?></td>
		<td class="right"><?= (int)@$cache['daily'][$year][$month][$i]['total'] ?></td>
		<td class="graph"><?= $graph ?></td>
	</tr>
<?php
}
?>
</table>

<h2>Days of Week</h2>
<table cellspacing="1" class="uamazon_report_table">
	<tr>
		<td class="column_label" width="65">Day</td>
		<td class="column_label" width="65" style="background-color: #fe5855;">Clicks</td>
		<td class="column_label" width="65" style="background-color: #3a7cd9;">Spiders</td>
		<td class="column_label" width="65" style="background-color: #69aa6f;">Total</td>
		<td>&nbsp;</td>
	</tr>
<?php
$row = 0;
foreach ($weekday_list as $dow => $name)
{
	$row++;

	$row_class = '';
	if (!($row % 2))
	{
		$row_class = ' class="alt_row"';
	}

	$bar_list = array(
		@$cache['weekly'][$year][$month][$dow]['human'],
		@$cache['weekly'][$year][$month][$dow]['spider'],
		@$cache['weekly'][$year][$month][$dow]['total']
	);

	$graph = horiz_bar_graph($bar_list, @$cache['weekly'][(int)$year][(int)$month]['max'], 100);
?>
	<tr<?= $row_class ?>>
		<td class="row_label"><?= $name ?></td>
		<td class="right"><?= (int)@$cache['weekly'][$year][$month][$dow]['human'] ?></td>
		<td class="right"><?= (int)@$cache['weekly'][$year][$month][$dow]['spider'] ?></td>
		<td class="right"><?= (int)@$cache['weekly'][$year][$month][$dow]['total'] ?></td>
		<td class="graph"><?= $graph ?></td>
	</tr>
<?php
}
?>
</table>

<h2>Hours of the Day</h2>
<table cellspacing="1" class="uamazon_report_table">
	<tr>
		<td class="column_label" width="65">Hour</td>
		<td class="column_label" width="65" style="background-color: #fe5855;">Clicks</td>
		<td class="column_label" width="65" style="background-color: #3a7cd9;">Spiders</td>
		<td class="column_label" width="65" style="background-color: #69aa6f;">Total</td>
		<td>&nbsp;</td>
	</tr>
<?php
$row = 0;
for ($i = 0; $i <= 11; $i++)
{
	$row++;

	$row_class = '';
	if (!($row % 2))
	{
		$row_class = ' class="alt_row"';
	}

	if (!$i)
	{
		$row_name = '12 AM';
	}
	else
	{
		$row_name = $i.' AM';
	}

	$bar_list = array(
		@$cache['hourly'][$year][$month][$i]['human'],
		@$cache['hourly'][$year][$month][$i]['spider'],
		@$cache['hourly'][$year][$month][$i]['total']
	);

	$graph = horiz_bar_graph($bar_list, @$cache['hourly'][(int)$year][(int)$month]['max'], 100);
?>
	<tr<?= $row_class ?>>
		<td class="row_label"><?= $row_name ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['human'] ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['spider'] ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['total'] ?></td>
		<td class="graph"><?= $graph ?></td>
	</tr>
<?php
}

for ($i = 12; $i <= 23; $i++)
{
	$row++;

	$row_class = '';
	if (!($row % 2))
	{
		$row_class = ' class="alt_row"';
	}

	if ($i == 12)
	{
		$row_name = '12 PM';
	}
	else
	{
		$row_name = ($i-12).' PM';
	}

	$bar_list = array(
		@$cache['hourly'][$year][$month][$i]['human'],
		@$cache['hourly'][$year][$month][$i]['spider'],
		@$cache['hourly'][$year][$month][$i]['total']
	);

	$graph = horiz_bar_graph($bar_list, @$cache['hourly'][(int)$year][(int)$month]['max'], 100);
?>
	<tr<?= $row_class ?>>
		<td class="row_label"><?= $row_name ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['human'] ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['spider'] ?></td>
		<td class="right"><?= (int)@$cache['hourly'][$year][$month][$i]['total'] ?></td>
		<td class="graph"><?= $graph ?></td>
	</tr>
<?php
}
?>
</table>

<h2>Monthly History</h2>
<table cellspacing="1" class="uamazon_report_table">
	<tr>
		<td class="column_label" width="65">Month</td>
		<td class="column_label" width="65" style="background-color: #fe5855;">Clicks</td>
		<td class="column_label" width="65" style="background-color: #3a7cd9;">Spiders</td>
		<td class="column_label" width="65" style="background-color: #69aa6f;">Total</td>
		<td>&nbsp;</td>
	</tr>
<?php
$row = 0;
foreach ($month_list as $mn => $name)
{
	$row++;

	$row_class = '';
	if (!($row % 2))
	{
		$row_class = ' class="alt_row"';
	}

	$bar_list = array(
		@$cache['monthly'][$year][$mn]['human'],
		@$cache['monthly'][$year][$mn]['spider'],
		@$cache['monthly'][$year][$mn]['total']
	);

	$graph = horiz_bar_graph($bar_list, @$cache['yearly'][$year]['total'], 100);
?>
	<tr<?= $row_class ?>>
		<td class="row_label"><?= $name ?></td>
		<td class="right"><?= (int)@$cache['monthly'][$year][$mn]['human'] ?></td>
		<td class="right"><?= (int)@$cache['monthly'][$year][$mn]['spider'] ?></td>
		<td class="right"><?= (int)@$cache['monthly'][$year][$mn]['total'] ?></td>
		<td class="graph"><?= $graph ?></td>
	</tr>
<?php
}
?>
</table>

<h2>Keywords (top 10)</h2>
<table cellspacing="1" class="uamazon_report_table">
	<tr>
		<td class="column_label">Keyword</td>
		<td class="column_label" width="65">Clicks</td>
	</tr>
<?php

if (@$cache['keywords'])
{
	$row = 0;
	foreach (@$cache['keywords'] as $keyword => $info)
	{
		$row++;

		$row_class = '';
		if (!($row % 2))
		{
			$row_class = ' class="alt_row"';
		}
?>
	<tr<?= $row_class ?>>
		<td class="row_label" style="text-align: left;"><?= $keyword ?></td>
		<td class="right"><?= (int)$info['total'] ?></td>
	</tr>
<?php
	}
}
else
{
?>
	<tr>
		<td colspan="2" align="center">No results</td>
	</tr>
<?php
}
?>
</table>