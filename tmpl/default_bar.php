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
	<?php if($cpb['display_title'] && $cpb['cpb_title_position'] == 2): ?>
	<div><?=$cpb['display_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && $cpb['cpb_progress_position'] == 2): ?>
	<strong><?=$cpb['display_progress'];?></strong>
	<?php endif; ?>
	<div class="progress">
		<div class="bg-info" style="<?=$cpb['progress_with'];?>">
		<?php if($cpb['display_title'] && $cpb['cpb_title_position'] == 1): ?>
		<div class="text-center"><?=$cpb['display_title'];?></div>
		<?php endif; ?>
		<?php if($cpb['display_progress'] && $cpb['cpb_progress_position'] == 1): ?>
		<div class="text-center"><?=$cpb['display_progress'];?></div>
		<?php endif; ?>
		</div>
	</div>
	<?php if($cpb['display_title'] && $cpb['cpb_title_position'] == 3): ?>
	<strong><?=$cpb['display_title'];?></strong>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && $cpb['cpb_progress_position'] == 3): ?>
	<strong><?=$cpb['display_progress'];?></strong>
	<?php endif; ?>
</div>