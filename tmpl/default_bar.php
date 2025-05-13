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
$cpb_progress_class = 'progress my-auto';
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
<div style="color:<?=$cpb['cpb_color_text'];?>" <?=$cpb['cpb_class'];?><?=$cpb['tooltip'];?>>
	<?php if($cpb['display_title'] && ($cpb['cpb_title_position'] == 2 || $cpb['cpb_title_position'] == 4)): ?>
	<div<?=$cpb_title_class;?>><?=$cpb['display_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && ($cpb['cpb_progress_position'] == 2 || $cpb['cpb_progress_position'] == 4)): ?>
	<div<?=$cpb_progress_label_class;?>><?=$cpb['display_progress'];?></div>
	<?php endif; ?>
	<div class="<?=$cpb_progress_class;?>" style="background-color:<?=$cpb['cpb_color_bg'];?>">
		<div style="<?=$cpb['progress_with'];?>;background-color:<?=$cpb['cpb_color_empty'];?>">
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