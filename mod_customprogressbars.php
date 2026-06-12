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

/**
 * types of config parameters (only these will be used)
 * each param has a name (key) with an array of type and default value
 * types: bool, int, str
 */
$cpb_params_basic = [
	'g_class' => ['str', 'g-mod-cpb'],
	'width' => ['int', 100],
	'horizontal_position' => ['int', 1],
	'header' => ['str', ''],
	'custom_css' => ['str', ''],
	'title_position_default' => ['int', 1],
	'progress_position_default' => ['int', 1],
	'mouseover_default' => ['int', 1],
	'3d_default' => ['int', 1],
	'color_text_inherit_default' => ['bool', TRUE],
	'color_text_default' => ['str', '#000000'],
	'color_bg_default' => ['str', '#FFFFFF'],
	'color_border_default' => ['str', '#777777'],
	'color_filled_default' => ['str', '#66CC66'],
	'color_empty_default' => ['str', '#FF4D4D'],
	'gradient_default' => ['int', 1],
	'style_default' => ['int', 1],
	'color_3d_default' => ['str', 'rgba(0,0,0,0.5)'],
];
$cpb_params_bar = [
	'cpb_enabled' => ['bool', TRUE],
	'cpb_class' => ['str', ''],
	'cpb_height' => ['str', ''],
	'cpb_3d' => ['int', 0],
	'cpb_lang_force' => ['bool', FALSE],
	'cpb_title_show' => ['bool', TRUE],
	'cpb_title' => ['str', ''],
	'cpb_title_position' => ['int', 0],
	'cpb_progress_min' => ['int', 0],
	'cpb_progress_max' => ['int', 100],
	'cpb_progress_show' => ['bool', TRUE],
	'cpb_progress_position' => ['int', 0],
	'cpb_progress_percent' => ['bool', TRUE],
	'cpb_progress_label' => ['str', ''],
	'cpb_mouseover' => ['int', 0],
	'cpb_gradient' => ['int', 0],
	'cpb_style' => ['int', 0],
];

$cpb_params_bar_overwrite_col = [
	'cpb_color_text_inherit' => ['bool', TRUE],
	'cpb_color_text' => ['str', '#000000'],
	'cpb_color_bg' => ['str', '#FFFFFF'],
	'cpb_color_border' => ['str', '#777777'],
	'cpb_color_filled' => ['str', '#66CC66'],
	'cpb_color_empty' => ['str', '#FF4D4D'],
	'cpb_color_3d' => ['str', 'rgba(0,0,0,0.5)'],
];

/* building main config */
$stored_config = $params->toArray();
$g_cpb_config = [];
foreach($cpb_params_basic as $name => $arr) {
	if(!isset($stored_config[$name])) {
		$g_cpb_config[$name] = $arr[1];
		continue;
	}
	if($arr[0] == 'bool') { // turn params to bool
		$g_cpb_config[$name] = $stored_config[$name] == 1 ? TRUE : FALSE;
	} elseif($arr[0] == 'int') { // sanitize int params
		$g_cpb_config[$name] = intval($stored_config[$name]);
	} elseif($arr[0] == 'str') {  // clean up str params
		$g_cpb_config[$name] = $stored_config[$name] === NULL ? '' : trim($stored_config[$name]);
	}
}

$g_cpb_config['cpb'] = [];
foreach($stored_config['cbp_form'] as $cbp_form => $form_data) {
	$cbp_form = intval(str_replace('cbp_form', '', $cbp_form));
	$g_cpb_config['cpb'][$cbp_form] = [];
	foreach($cpb_params_bar as $name => $arr) {
		if(!isset($form_data[$name])) {
			$g_cpb_config['cpb'][$cbp_form][$name] = $arr[1];
			continue;
		}
		if($arr[0] == 'bool') { // turn params to bool
			$g_cpb_config['cpb'][$cbp_form][$name] = $form_data[$name] == 1 ? TRUE : FALSE;
		} elseif($arr[0] == 'int') { // sanitize int params
			$g_cpb_config['cpb'][$cbp_form][$name] = intval($form_data[$name]);
		} elseif($arr[0] == 'str') {  // clean up str params
			$g_cpb_config['cpb'][$cbp_form][$name] = $form_data[$name] === NULL ? '' : trim($form_data[$name]);
		}
	}
	if(!empty($form_data['cpb_custom_colors'])) { // set color overwrites if available
		$g_cpb_config['cpb'][$cbp_form]['color_overwrite'] = [];
		foreach($cpb_params_bar_overwrite_col as $name => $arr) {
			if(!isset($form_data['cpb_custom_colors']['cpb_custom_colors0'][$name])) {
				$g_cpb_config['cpb'][$cbp_form]['color_overwrite'][$name] = $arr[1];
				continue;
			}
			if($arr[0] == 'bool') { // turn params to bool
				$g_cpb_config['cpb'][$cbp_form]['color_overwrite'][$name] = $form_data['cpb_custom_colors']['cpb_custom_colors0'][$name] == 1 ? TRUE : FALSE;
			} elseif($arr[0] == 'int') { // sanitize int params
				$g_cpb_config['cpb'][$cbp_form]['color_overwrite'][$name] = intval($form_data['cpb_custom_colors']['cpb_custom_colors0'][$name]);
			} elseif($arr[0] == 'str') {  // clean up str params
				$g_cpb_config['cpb'][$cbp_form]['color_overwrite'][$name] = $form_data['cpb_custom_colors']['cpb_custom_colors0'][$name] === NULL ? '' : trim($form_data['cpb_custom_colors']['cpb_custom_colors0'][$name]);
			}
		}
	}
	$g_cpb_config['cpb'][$cbp_form]['lang_alt'] = [];
	foreach($form_data['cpb_lang_sub'] as $lang_form) { // load alternative languages
		$g_cpb_config['cpb'][$cbp_form]['lang_alt'][trim($lang_form['cpb_lang_sub_lang'])] = [
			'title' => $lang_form['cpb_lang_sub_title'] === NULL ? '' : trim($lang_form['cpb_lang_sub_title']),
			'progress_label' => $lang_form['cpb_lang_sub_progress_label'] === NULL ? '' : trim($lang_form['cpb_lang_sub_progress_label']),
		];
	}
}
$g_cpb_config['current_lang'] = Factory::getLanguage()->getTag(); // the language the user is currently using
foreach($stored_config['header_form'] as $header_lang) { // overwrite header if lang set
	if($g_cpb_config['current_lang'] == $header_lang['header_lang'])
		$g_cpb_config['header'] = $header_lang['header_alt'] === NULL ? '' : trim($header_lang['header_alt']);
}
/* config ready */

$g_cpb_config['cpb'] = ModCustomProgressBars::prepare_progress_bars($g_cpb_config);

require ModuleHelper::getLayoutPath('mod_customprogressbars'); // this loads the tmpl/default.php