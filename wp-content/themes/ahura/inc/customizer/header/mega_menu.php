<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_text;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_show_mega_menu', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_mega_menu', [
    'label' => __('Show mega menu','ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));
$this->customizer->add_setting('ahura_mega_menu_more_items_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_mega_menu_more_items_status', [
    'label' => __('Mega Menu More Items Button','ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::is_active_header_style(1);
    }
]));

$this->customizer->add_setting('ahura_megamenu_menu_height_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_megamenu_menu_height_status', [
    'label' => __('Mega Menu height limitation','ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_mega_menu']
]));
$this->customizer->add_setting('ahura_megamenu_menu_height', ['default' => 500]);
$this->customizer->add_control(new simple_range($this->customizer, 'ahura_megamenu_menu_height', [
    'label' => __('Mega Menu height','ahura'),
    'section' => $this->current_section,
    'input_attrs' => [
        'step' => 1,
        'min' => 300,
        'max' => 1000,
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_ahura_megamenu_menu_height_status']
]));

$this->customizer->add_setting('ahura_mega_menu_more_items_count', ['default' => 7]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_mega_menu_more_items_count', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Active Items Count', 'ahura'),
    'input_attrs' => [
        'min' => 1,
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_mega_menu_more_items_status']
]));
$this->customizer->add_setting('ahura_mega_menu_dynamic_alignment');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_mega_menu_dynamic_alignment', [
    'label' => __('Use Dynamic Alignment','ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_active_mega_menu() && mw_options::is_active_header_style(1);
    },
]));
$this->customizer->add_setting('ahura_mega_menu_alignment', ['default' => 'right']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_mega_menu_alignment', [
    'label' => __("Mega menu alignment", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'ahura_mega_menu_dynamic_alignment'],
    'choices' => [
        'right' => [
            'label' => __('Right', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/mega_menu_alignment_right.png',
        ],
        'left' => [
            'label' => __("Left", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/mega_menu_alignment_left.png',
        ],
    ],
]));
$this->customizer->add_setting('ahura_mega_menu_title_background_color', ['default' => '#fed700']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mega_menu_title_background_color', [
    'label' => __("Mega Menu Title Background Color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
]));
$this->customizer->add_setting('ahura_mega_menu_title_color', ['default' => '#35495c']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mega_menu_title_color', [
    'label' => __("Mega Menu Title Color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
]));
$this->customizer->add_setting('ahura_mega_menu_wrapper_background_color', ['default' => '#ffffff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mega_menu_wrapper_background_color', [
    'label' => __("Category menu background color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
]));
$this->customizer->add_setting('ahura_mega_menu_wrapper_text_color', ['default' => '#35495C']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mega_menu_wrapper_text_color', [
    'label' => __("Category menu text color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
]));
$this->customizer->add_setting('ahura_mega_menu_item_border_color', ['default' => '#f6f6f6']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_mega_menu_item_border_color', [
    'label' => __("Category menu item border color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_show_mega_menu() && mw_options::is_active_header_style(1);
    }
]));

$this->customizer->add_setting('openmenuinfrontpage', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'openmenuinfrontpage', array(
    'label' => __('Open Menu is Front Page','ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
)));

$this->customizer->add_setting('ahura_mega_menu_title',['default' => __("Category Menu", 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_mega_menu_title', [
    'label' => __('Mega menu title', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_mega_menu']
]));

$this->customizer->selective_refresh->add_partial('ahura_mega_menu_title',[
    'selector' => '.topbar .cats-list-title',
]);

