<?php
namespace ahura\app\customization;

class Customizer
{
	 /**
     *
     *
     * Reset customizer all settings
     *
	 * @param array $options_key
     *
     */
	public static function reset($options_key = []){
		global $wp_customize, $options;
		
		$settings = $wp_customize->settings();
        
        if (!empty($settings)){
			if(is_array($options_key) && !empty($options_key) && count($options_key) > 0){
				foreach($options_key as $key){
					remove_theme_mod($key);
				}
			} else {
				/**
				 * Filter the settings that will be removed.
				 *
				 * @param array $settings Theme modifications.
				 * @return array
				 */
				$settings = apply_filters('customizer_reset_settings', $settings);
				foreach($settings as $setting){
					if('theme_mod' === $setting->type){
						remove_theme_mod($setting->id);
					}
				}
			}
        } else {
			return false;
		}
		
		return true;
	}
}