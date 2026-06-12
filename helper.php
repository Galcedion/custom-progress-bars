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

/**
 * Helper class for the Module Custom Progress Bars
 */
class ModCustomProgressBars
{
	/**
	 * static function to create data for progress bar display
	 *
	 * @param associative array containing the module config
	 *
	 * @return array of finished progress bars (assoc arrays)
	 */
	public static function prepare_progress_bars($g_cpb_config) {
		$simple_defaults = [ // progress bar option => default value for option
			'cpb_title_position' => 'title_position_default',
			'cpb_progress_position' => 'progress_position_default',
			'cpb_mouseover' => 'mouseover_default',
			'cpb_gradient' => 'gradient_default',
			'cpb_style' => 'style_default',
		];

		foreach($g_cpb_config['cpb'] as &$key) { // iterate progress bars
			if(!$key['cpb_enabled']) { // if progress bar disabled, remove from list
				$key = NULL;
				continue;
			} elseif($key['cpb_lang_force'] && !array_key_exists($g_cpb_config['current_lang'], $key['lang_alt'])) { // if progress bar lang forced and unavailable, remove from list
				$key = NULL;
				continue;
			} elseif(array_key_exists($g_cpb_config['current_lang'], $key['lang_alt'])) { // map alternative lang
				$key['cpb_title'] =  $key['lang_alt'][$g_cpb_config['current_lang']]['title'];
				$key['cpb_progress_label'] =  $key['lang_alt'][$g_cpb_config['current_lang']]['progress_label'];
			}
			foreach($simple_defaults as $cpb_set => $sd) { // set defaults for selects with default option
				if($key[$cpb_set] == 0)
					$key[$cpb_set] = $g_cpb_config[$sd];
			}
			$key['display_title'] = $key['cpb_title_show'] ? $key['cpb_title'] : FALSE;
			if($key['cpb_progress_percent']) {
				$tmp_display_progress = round(100 / $key['cpb_progress_max'] * $key['cpb_progress_min']) . ' %';
			} else {
				$tmp_display_progress = $key['cpb_progress_min'] . ' / ' . $key['cpb_progress_max'];
				$tmp_display_progress .= (empty($key['cpb_progress_min']) ? '' : ' ' . $key['cpb_progress_label']);
			}
			if($key['cpb_progress_show']) { // prepare progress text
				$key['display_progress'] = $tmp_display_progress;
			} else {
				$key['display_progress'] = FALSE;
			}
			$key['cpb_height'] = str_replace(' ', '', str_replace(';', '', $key['cpb_height']));
			if(is_numeric($key['cpb_height'])) {
				$key['cpb_height'] .= 'px';
			}
			/* build tooltip */
			$key['tooltip'] = ''; // None (1) or out of bounds
			if($key['cpb_mouseover'] == 2) // Show title
				$key['tooltip'] = ' title="' . $key['cpb_title'] . '"';
			elseif($key['cpb_mouseover'] == 3) // Show progress
				$key['tooltip'] = ' title="' . $tmp_display_progress . '"';
			elseif($key['cpb_mouseover'] == 4) { // Show progress (no label)
				if($key['cpb_progress_percent']) {
					$key['tooltip'] = ' title="' . round(100 / $key['cpb_progress_max'] * $key['cpb_progress_min']) . '"';
				} else {
					$key['tooltip'] = ' title="' . $key['cpb_progress_min'] . ' / ' . $key['cpb_progress_max'] . '"';
				}
			}
			/* set colors */
			if(empty($key['color_overwrite'])) {
				$key['cpb_color_text'] = $g_cpb_config['color_text_inherit_default'] ? '' : $g_cpb_config['color_text_default'];
				$key['cpb_color_bg'] = $g_cpb_config['color_bg_default'];
				$key['cpb_color_border'] = $g_cpb_config['color_border_default'];
				$key['cpb_color_filled'] = $g_cpb_config['color_filled_default'];
				$key['cpb_color_empty'] = $g_cpb_config['color_empty_default'];
			} else {
				$key['cpb_color_text'] = $key['color_overwrite']['cpb_custom_colors0']['cpb_color_text'] == 0 ? '' : $key['color_overwrite']['cpb_custom_colors0']['cpb_color_text'];
				$key['cpb_color_bg'] = $key['color_overwrite']['cpb_custom_colors0']['cpb_color_bg'];
				$key['cpb_color_border'] = $key['color_overwrite']['cpb_custom_colors0']['cpb_color_border'];
				$key['cpb_color_filled'] = $key['color_overwrite']['cpb_custom_colors0']['cpb_color_filled'];
				$key['cpb_color_empty'] = $key['color_overwrite']['cpb_custom_colors0']['cpb_color_empty'];
			}
			/* calculate progress width */
			if($key['cpb_progress_min'] >= $key['cpb_progress_max'])
				$key['progress_width'] = 'width:100%;';
			else
				$key['progress_width'] = 'width:' . (100 / $key['cpb_progress_max'] * $key['cpb_progress_min']) . '%;';
		}
		unset($key);
		return array_filter($g_cpb_config['cpb']);
	}
}