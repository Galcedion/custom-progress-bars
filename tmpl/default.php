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
use Joomla\CMS\Helper\ModuleHelper;
?>
<div class="<?=$g_cpb_config['g_class'];?>">
	<?php foreach($g_cpb_config['cpb'] as $cpb): ?>
		<?php require ModuleHelper::getLayoutPath('mod_customprogressbars', $params->get('layout', 'default') . '_bar'); ?>
	<?php endforeach; ?>
</div>