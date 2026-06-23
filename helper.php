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
			'cpb_3d' => '3d_default',
		];

		foreach($g_cpb_config['cpb'] as &$bar) { // iterate progress bars
			if(!$bar['cpb_enabled']) { // if progress bar disabled, remove from list
				$bar = NULL;
				continue;
			} elseif($bar['cpb_lang_force'] && !array_key_exists($g_cpb_config['current_lang'], $bar['lang_alt'])) { // if progress bar lang forced and unavailable, remove from list
				$bar = NULL;
				continue;
			} elseif(array_key_exists($g_cpb_config['current_lang'], $bar['lang_alt'])) { // map alternative lang
				$bar['cpb_title'] =  $bar['lang_alt'][$g_cpb_config['current_lang']]['title'];
				$bar['cpb_progress_label'] =  $bar['lang_alt'][$g_cpb_config['current_lang']]['progress_label'];
			}
			foreach($simple_defaults as $cpb_set => $sd) { // set defaults for selects with default option
				if($bar[$cpb_set] == 0)
					$bar[$cpb_set] = $g_cpb_config[$sd];
			}
			$bar['display_title'] = $bar['cpb_title_show'] ? $bar['cpb_title'] : FALSE;
			if($bar['cpb_progress_percent']) {
				$tmp_display_progress = round(100 / $bar['cpb_progress_max'] * $bar['cpb_progress_min']) . ' %';
			} else {
				$tmp_display_progress = $bar['cpb_progress_min'] . ' / ' . $bar['cpb_progress_max'];
				$tmp_display_progress .= (empty($bar['cpb_progress_min']) ? '' : ' ' . $bar['cpb_progress_label']);
			}
			if($bar['cpb_progress_show']) { // prepare progress text
				$bar['display_progress'] = $tmp_display_progress;
			} else {
				$bar['display_progress'] = FALSE;
			}
			$bar['cpb_height'] = str_replace(' ', '', str_replace(';', '', $bar['cpb_height']));
			if(is_numeric($bar['cpb_height'])) {
				$bar['cpb_height'] .= 'px';
			}
			/* build tooltip */
			$bar['tooltip'] = ''; // None (1) or out of bounds
			if($bar['cpb_mouseover'] == 2) // Show title
				$bar['tooltip'] = ' title="' . $bar['cpb_title'] . '"';
			elseif($bar['cpb_mouseover'] == 3) // Show progress
				$bar['tooltip'] = ' title="' . $tmp_display_progress . '"';
			elseif($bar['cpb_mouseover'] == 4) { // Show progress (no label)
				if($bar['cpb_progress_percent']) {
					$bar['tooltip'] = ' title="' . round(100 / $bar['cpb_progress_max'] * $bar['cpb_progress_min']) . '"';
				} else {
					$bar['tooltip'] = ' title="' . $bar['cpb_progress_min'] . ' / ' . $bar['cpb_progress_max'] . '"';
				}
			}
			/* set colors */
			if(empty($bar['color_overwrite'])) {
				$bar['cpb_color_text'] = $g_cpb_config['color_text_inherit_default'] ? '' : $g_cpb_config['color_text_default'];
				$bar['cpb_color_bg'] = $g_cpb_config['color_bg_default'];
				$bar['cpb_color_border'] = $g_cpb_config['color_border_default'];
				$bar['cpb_color_filled'] = $g_cpb_config['color_filled_default'];
				$bar['cpb_color_empty'] = $g_cpb_config['color_empty_default'];
				$bar['cpb_color_3d'] = $g_cpb_config['color_3d_default'];
			} else {
				$bar['cpb_color_text'] = $bar['color_overwrite']['cpb_color_text'] == 0 ? '' : $bar['color_overwrite']['cpb_color_text'];
				$bar['cpb_color_bg'] = $bar['color_overwrite']['cpb_color_bg'];
				$bar['cpb_color_border'] = $bar['color_overwrite']['cpb_color_border'];
				$bar['cpb_color_filled'] = $bar['color_overwrite']['cpb_color_filled'];
				$bar['cpb_color_empty'] = $bar['color_overwrite']['cpb_color_empty'];
				$bar['cpb_color_3d'] = $bar['color_overwrite']['cpb_color_3d'];
			}
			/* calculate progress width */
			if($bar['cpb_progress_min'] >= $bar['cpb_progress_max'])
				$bar['progress_width'] = '100%';
			else
				$bar['progress_width'] = (100 / $bar['cpb_progress_max'] * $bar['cpb_progress_min']) . '%';
		}
		unset($bar);
		return array_filter($g_cpb_config['cpb']);
	}
}