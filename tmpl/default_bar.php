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
<div style="color:<?=$cpb['cpb_color_text'];?>"<?=$cpb['tooltip'];?>>
	<?php if($cpb['display_title'] && $cpb['cpb_title_position'] == 2): ?>
	<div><?=$cpb['display_title'];?></div>
	<?php endif; ?>
	<?php if($cpb['display_progress'] && $cpb['cpb_progress_position'] == 2): ?>
	<strong><?=$cpb['display_progress'];?></strong>
	<?php endif; ?>
	<div class="progress" style="background-color:<?=$cpb['cpb_color_bg'];?>">
		<div style="<?=$cpb['progress_with'];?>;background-color:<?=$cpb['cpb_color_empty'];?>">
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