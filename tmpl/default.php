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
use Joomla\CMS\Factory;
if(!empty($g_cpb_config['custom_css'])) { // load custom CSS if set
	$wa = Factory::getApplication()->getDocument()->getWebAssetManager();
	$wa->addInlineStyle($g_cpb_config['custom_css']);
}
?>
<div class="<?=$g_cpb_config['g_class'];?>">
	<?=$g_cpb_config['header'];?>
	<?php foreach($g_cpb_config['cpb'] as $cpb): ?>
		<?php require ModuleHelper::getLayoutPath('mod_customprogressbars', $params->get('layout', 'default') . '_bar'); ?>
	<?php endforeach; ?>
</div>