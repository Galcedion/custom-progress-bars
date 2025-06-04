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
		foreach($g_cpb_config['cpb'] as $key => $bar) { // iterate progress bars
			if(!$g_cpb_config['cpb'][$key]['cpb_enabled']) { // if progress bar disabled, remove from list
				unset($g_cpb_config['cpb'][$key]);
				continue;
			} elseif($g_cpb_config['cpb'][$key]['cpb_lang_force'] && !array_key_exists($g_cpb_config['current_lang'], $g_cpb_config['cpb'][$key]['lang_alt'])) { // if progress bar lang forced and unavailable, remove from list
				unset($g_cpb_config['cpb'][$key]);
				continue;
			} elseif(array_key_exists($g_cpb_config['current_lang'], $g_cpb_config['cpb'][$key]['lang_alt'])) { // map alternative lang
				$g_cpb_config['cpb'][$key]['cpb_title'] =  $g_cpb_config['cpb'][$key]['lang_alt'][$g_cpb_config['current_lang']]['title'];
				$g_cpb_config['cpb'][$key]['cpb_progress_label'] =  $g_cpb_config['cpb'][$key]['lang_alt'][$g_cpb_config['current_lang']]['progress_label'];
			}
			if($g_cpb_config['cpb'][$key]['cpb_title_position'] == 0)
				$g_cpb_config['cpb'][$key]['cpb_title_position'] = $g_cpb_config['title_position_default'];
			if($g_cpb_config['cpb'][$key]['cpb_progress_position'] == 0)
				$g_cpb_config['cpb'][$key]['cpb_progress_position'] = $g_cpb_config['progress_position_default'];
			if($g_cpb_config['cpb'][$key]['cpb_mouseover'] == 0)
				$g_cpb_config['cpb'][$key]['cpb_mouseover'] = $g_cpb_config['mouseover_default'];
			if($g_cpb_config['cpb'][$key]['cpb_gradient'] == 0)
				$g_cpb_config['cpb'][$key]['cpb_gradient'] = $g_cpb_config['gradient_default'];
			if($g_cpb_config['cpb'][$key]['cpb_style'] == 0)
				$g_cpb_config['cpb'][$key]['cpb_style'] = $g_cpb_config['style_default'];
			$g_cpb_config['cpb'][$key]['display_title'] = $g_cpb_config['cpb'][$key]['cpb_title_show'] ? $g_cpb_config['cpb'][$key]['cpb_title'] : FALSE;
			if($g_cpb_config['cpb'][$key]['cpb_progress_percent']) {
				$tmp_display_progress = round(100 / $g_cpb_config['cpb'][$key]['cpb_progress_max'] * $g_cpb_config['cpb'][$key]['cpb_progress_min']) . ' %';
			} else {
				$tmp_display_progress = $g_cpb_config['cpb'][$key]['cpb_progress_min'] . ' / ' . $g_cpb_config['cpb'][$key]['cpb_progress_max'];
				$tmp_display_progress .= (empty($g_cpb_config['cpb'][$key]['cpb_progress_min']) ? '' : ' ' . $g_cpb_config['cpb'][$key]['cpb_progress_label']);
			}
			if($g_cpb_config['cpb'][$key]['cpb_progress_show']) { // prepare progress text
				$g_cpb_config['cpb'][$key]['display_progress'] = $tmp_display_progress;
			} else {
				$g_cpb_config['cpb'][$key]['display_progress'] = FALSE;
			}
			/* build tooltip */
			$g_cpb_config['cpb'][$key]['tooltip'] = ''; // None (1) or out of bounds
			if($g_cpb_config['cpb'][$key]['cpb_mouseover'] == 2) // Show title
				$g_cpb_config['cpb'][$key]['tooltip'] = ' title="' . $g_cpb_config['cpb'][$key]['cpb_title'] . '"';
			elseif($g_cpb_config['cpb'][$key]['cpb_mouseover'] == 3) // Show progress
				$g_cpb_config['cpb'][$key]['tooltip'] = ' title="' . $tmp_display_progress . '"';
			elseif($g_cpb_config['cpb'][$key]['cpb_mouseover'] == 4) { // Show progress (no label)
				if($g_cpb_config['cpb'][$key]['cpb_progress_percent']) {
					$g_cpb_config['cpb'][$key]['tooltip'] = ' title="' . round(100 / $g_cpb_config['cpb'][$key]['cpb_progress_max'] * $g_cpb_config['cpb'][$key]['cpb_progress_min']) . '"';
				} else {
					$g_cpb_config['cpb'][$key]['tooltip'] = ' title="' . $g_cpb_config['cpb'][$key]['cpb_progress_min'] . ' / ' . $g_cpb_config['cpb'][$key]['cpb_progress_max'] . '"';
				}
			}
			/* set colors */
			if(empty($g_cpb_config['cpb'][$key]['color_overwrite'])) {
				$g_cpb_config['cpb'][$key]['cpb_color_text'] = $g_cpb_config['color_text_inherit_default'] ? '' : $g_cpb_config['color_text_default'];
				$g_cpb_config['cpb'][$key]['cpb_color_bg'] = $g_cpb_config['color_bg_default'];
				$g_cpb_config['cpb'][$key]['cpb_color_border'] = $g_cpb_config['color_border_default'];
				$g_cpb_config['cpb'][$key]['cpb_color_filled'] = $g_cpb_config['color_filled_default'];
				$g_cpb_config['cpb'][$key]['cpb_color_empty'] = $g_cpb_config['color_empty_default'];
			} else {
				$g_cpb_config['cpb'][$key]['cpb_color_text'] = $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_text'] == 0 ? '' : $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_text'];
				$g_cpb_config['cpb'][$key]['cpb_color_bg'] = $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_bg'];
				$g_cpb_config['cpb'][$key]['cpb_color_border'] = $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_border'];
				$g_cpb_config['cpb'][$key]['cpb_color_filled'] = $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_filled'];
				$g_cpb_config['cpb'][$key]['cpb_color_empty'] = $g_cpb_config['cpb'][$key]['color_overwrite']['cpb_custom_colors0']['cpb_color_empty'];
			}
			/* calculate progress width */
			if($g_cpb_config['cpb'][$key]['cpb_progress_min'] >= $g_cpb_config['cpb'][$key]['cpb_progress_max'])
				$g_cpb_config['cpb'][$key]['progress_width'] = 'width:100%;';
			else
				$g_cpb_config['cpb'][$key]['progress_width'] = 'width:' . (100 / $g_cpb_config['cpb'][$key]['cpb_progress_max'] * $g_cpb_config['cpb'][$key]['cpb_progress_min']) . '%;';
		}
		return $g_cpb_config['cpb'];
	}
}