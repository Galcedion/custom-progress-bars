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
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
require_once dirname(__FILE__) . '/helper.php';

/* types of config parameters (only these will be used) */
$param_list_int = [
	'title_position_default', 'progress_position_default', 'mouseover_default'
];
$param_list_str = [
	'g_class', 'custom_css', 'header',
	'color_text_default', 'color_bg_default', 'color_filled_default', 'color_empty_default'
];
$progress_form_list_bool = [
	'cpb_title_show', 'cpb_progress_show', 'cpb_progress_percent', 'cpb_lang_force',
	'cpb_enabled'
];
$progress_form_list_int = [
	'cpb_title_position', 'cpb_progress_position', 'cpb_progress_min', 'cpb_progress_max',
	'cpb_mouseover'
];
$progress_form_list_str = [
	'cpb_class', 'cpb_title', 'cpb_progress_label'
];
/* building main config */
$stored_config = $params->toArray();
$g_cpb_config = [];
foreach($param_list_int as $pli) { // sanitize int params
	$g_cpb_config[$pli] = intval($stored_config[$pli]);
}
foreach($param_list_str as $pls) { // clean up str params
	$g_cpb_config[$pls] = $stored_config[$pls] === NULL ? '' : trim($stored_config[$pls]);
}
$g_cpb_config['cpb'] = [];
foreach($stored_config['cbp_form'] as $cbp_form => $form_data) {
	$cbp_form = intval(str_replace('cbp_form', '', $cbp_form));
	$g_cpb_config['cpb'][$cbp_form] = [];
	foreach($progress_form_list_bool as $pflb) { // turn params to bool
		$g_cpb_config['cpb'][$cbp_form][$pflb] = $form_data[$pflb] == 1 ? TRUE : FALSE;
	}
	foreach($progress_form_list_int as $pfli) { // sanitize int params
		$g_cpb_config['cpb'][$cbp_form][$pfli] = intval($form_data[$pfli]);
	}
	foreach($progress_form_list_str as $pfls) { // clean up str params
		$g_cpb_config['cpb'][$cbp_form][$pfls] = $form_data[$pfls] === NULL ? '' : trim($form_data[$pfls]);
	}
	$g_cpb_config['cpb'][$cbp_form]['color_overwrite'] = $form_data['cpb_custom_colors'];
	$g_cpb_config['cpb'][$cbp_form]['lang_alt'] = [];
	foreach($form_data['cpb_lang_sub'] as $lang_form) {
		$g_cpb_config['cpb'][$cbp_form]['lang_alt'][$lang_form['cpb_lang_sub_lang']] = ['title' => $lang_form['cpb_lang_sub_title'], 'progress_label' => $lang_form['cpb_lang_sub_progress_label']];
	}
}
$g_cpb_config['current_lang'] = Factory::getLanguage()->getTag(); // the language the user is currently using
foreach($stored_config['header_form'] as $header_lang) {
	if($g_cpb_config['current_lang'] == $header_lang['header_lang'])
		$g_cpb_config['header'] = trim($header_lang['header_alt']);
}
/* config ready */

$g_cpb_config['cpb'] = ModCustomProgressBars::prepare_progress_bars($g_cpb_config);

require ModuleHelper::getLayoutPath('mod_customprogressbars'); // this loads the tmpl/default.php