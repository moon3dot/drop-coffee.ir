<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_mobile_menu_button_color', ['default' => '#35495C']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mobile_menu_button_color', [
    'label' => __("Mobile menu button color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_change_mobile_menu_style', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_change_mobile_menu_style', [
    'label' => __('Change mobile menu style','ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    },
]));

$this->customizer->add_setting('ahura_open_mobile_menu_from_left', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_open_mobile_menu_from_left', [
    'label' => __('Open mobile menu from left','ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_open_mobile_submenu_with_click_title', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_open_mobile_submenu_with_click_title', [
    'label' => __('Open mobile submenu with click item title','ahura'),
    'section' => $this->current_section,
]));