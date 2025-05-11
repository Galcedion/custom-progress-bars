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
?>
<div>
	<?php if($cpb['cpb_title_show'] && $cpb['cpb_title_position'] == 2): ?>
	<div><?=$cpb['cpb_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['cpb_progress_show'] && $cpb['cpb_progress_position'] == 2): ?>
	<strong><?=['cpb_progress_min'] . ' / ' . $cpb['cpb_progress_max'];?></strong>
	<?php endif; ?>
	<div class="progress">
		<div class="bg-info" style="width:<?=(100/$cpb['cpb_progress_max']*$cpb['cpb_progress_min']);?>%">
		<?php if($cpb['cpb_title_show'] && $cpb['cpb_title_position'] == 1): ?>
		<div class="text-center"><?=$cpb['cpb_title'];?></div>
		<?php endif; ?>
		<?php if($cpb['cpb_progress_show'] && $cpb['cpb_progress_position'] == 1): ?>
		<div class="text-center"><?=$cpb['cpb_progress_min'] . ' / ' . $cpb['cpb_progress_max'];?></div>
		<?php endif; ?>
		</div>
	</div>
	<?php if($cpb['cpb_title_show'] && $cpb['cpb_title_position'] == 3): ?>
	<strong><?=$cpb['cpb_title'];?></strong>
	<?php endif; ?>
	<?php if($cpb['cpb_progress_show'] && $cpb['cpb_progress_position'] == 3): ?>
	<strong><?=$cpb['cpb_progress_min'] . ' / ' . $cpb['cpb_progress_max'];?></strong>
	<?php endif; ?>
</div>