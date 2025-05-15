<?php
/**
 * @package    Joomla.Site
 * @subpackage mod_customprogressbars
 *
 * @author     Galcedion https://galcedion.com
 * @copyright  Copyright (c) 2025 Galcedion
 * @license    GNU/GPL: https://gnu.org/licenses/gpl.html
 */
defined('_JEXEC') or die;
$cpb_color_text = $cpb['cpb_color_text'] == '' ? '' : ' style="color:' . $cpb['cpb_color_text'] . '"';
$cpb_progress_class = 'progress my-auto';
$cpb_progress_style = 'background-color:' . $cpb['cpb_color_bg'] . ';border: 1px solid ' . $cpb['cpb_color_border'] . ';';
$cpb_bar_style = $cpb['progress_width'];
if($cpb['cpb_gradient'] == 1) { // creating gradient
	$cpb_bar_style .= 'background-color:' . $cpb['cpb_color_filled'] . ';';
} elseif($cpb['cpb_gradient'] == 2) {
	$cpb_bar_style .= 'background-color:' . $cpb['cpb_color_empty'] . ';';
} elseif($cpb['cpb_gradient'] == 3) {
	$cpb_bar_style .= 'background-color:color-mix(in hsl,';
	if($cpb['cpb_progress_min'] > $cpb['cpb_progress_max'])
		$cpb['cpb_progress_min'] = $cpb['cpb_progress_max'];
	if($cpb['cpb_progress_min'] > 100 || $cpb['cpb_progress_max'] > 100) {
		$min_len = strlen(strval($cpb['cpb_progress_min'])) - 2;
		$max_len = strlen(strval($cpb['cpb_progress_max'])) - 2;
		$cpb['cpb_progress_min'] = $cpb['cpb_progress_min'] / (pow(10, max($min_len, $max_len)));
		$cpb['cpb_progress_max'] = $cpb['cpb_progress_max'] / (pow(10, max($min_len, $max_len)));
	}
	$cpb_bar_style .= $cpb['cpb_color_filled'] . ' ' . $cpb['cpb_progress_min'] . '%,' . $cpb['cpb_color_empty'] . ' ' . ($cpb['cpb_progress_max'] - $cpb['cpb_progress_min']) . '%);';
} elseif($cpb['cpb_gradient'] == 4) {
	$cpb_bar_style .= 'background-image:linear-gradient(90deg,' . $cpb['cpb_color_empty'] . ',' . $cpb['cpb_color_filled'] . ');';
}
$cpb_title_class = '';
$cpb_progress_label_class = '';
$colcount = 0;
if($cpb['cpb_title_position'] >= 4) {
	++$colcount;
	$cpb_title_class = ' class="col"';
}
if($cpb['cpb_progress_position'] >= 4) {
	++$colcount;
	$cpb_progress_label_class = ' class="col"';
}
if($colcount > 0) {
	$cpb_progress_class .= ' col-' . (12 - $colcount);
	$cpb['cpb_class'] .= ' row g-0';
}
$cpb['cpb_class'] = 'class="text-center my-1 ' . $cpb['cpb_class'] . '"'; // TODO: possible whitespace
?>
<div<?=$cpb_color_text;?> <?=$cpb['cpb_class'];?><?=$cpb['tooltip'];?>>
	<?php if($cpb['display_title'] && ($cpb['cpb_title_position'] == 2 || $cpb['cpb_title_position'] == 4)): ?>
	<div<?=$cpb_title_class;?>><?=$cpb['display_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && ($cpb['cpb_progress_position'] == 2 || $cpb['cpb_progress_position'] == 4)): ?>
	<div<?=$cpb_progress_label_class;?>><?=$cpb['display_progress'];?></div>
	<?php endif; ?>
	<div class="<?=$cpb_progress_class;?>" style="<?=$cpb_progress_style;?>">
		<div style="<?=$cpb_bar_style;?>">
		<?php if($cpb['display_title'] && $cpb['cpb_title_position'] == 1): ?>
		<div class="text-center"><?=$cpb['display_title'];?></div>
		<?php endif; ?>
		<?php if($cpb['display_progress'] && $cpb['cpb_progress_position'] == 1): ?>
		<div class="text-center"><?=$cpb['display_progress'];?></div>
		<?php endif; ?>
		</div>
	</div>
	<?php if($cpb['display_title'] && ($cpb['cpb_title_position'] == 3 || $cpb['cpb_title_position'] == 5)): ?>
	<div<?=$cpb_title_class;?>><?=$cpb['display_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && ($cpb['cpb_progress_position'] == 3 || $cpb['cpb_progress_position'] == 3)): ?>
	<div<?=$cpb_progress_label_class;?>><?=$cpb['display_progress'];?></div>
	<?php endif; ?>
</div>