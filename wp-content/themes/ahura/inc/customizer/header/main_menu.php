<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_menu_position', ['default' => 'middle']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_menu_position', [
    'label' => __("Menu position", 'ahura'),
    'section' => $this->current_section,
    'choices' => [
        'top' => [
            'label' => __('Top', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_top.png',
        ],
        'middle' => [
            'label' => __("Middle", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_middle.png',
        ],
        'bottom' => [
            'label' => __("Bottom", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_bottom.png',
        ],
    ],
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    }
]));
$this->customizer->add_setting('ahura_menu_position_sticky_header', ['default' => 'middle']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_menu_position_sticky_header', [
    'label' => __("Menu position in sticky header", 'ahura'),
    'section' => $this->current_section,
    'choices' => [
        'top' => [
            'label' => __('Top', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_top.png',
        ],
        'middle' => [
            'label' => __("Middle", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_middle.png',
        ],
        'bottom' => [
            'label' => __("Bottom", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_position_bottom.png',
        ],
        'hide' => [
            'label' => __("Hide", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/hide.png',
        ],
    ],
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    }
]));
$this->customizer->add_setting('ahura_menu_alignment', ['default' => 'left']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_menu_alignment', [
    'label' => __("Menu alignment", 'ahura'),
    'section' => $this->current_section,
    'choices' => [
        'right' => [
            'label' => __('Right', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_alignment_right.png',
        ],
        'left' => [
            'label' => __("Left", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/header/menu_alignment_left.png',
        ],
    ],
    'active_callback' => function(){
        return mw_options::check_is_header_menu_alignment_accessible() && mw_options::is_active_header_style(1);
    }
]));
$this->customizer->add_setting('ahura_menu_color');
$this->customizer->add_control('ahura_menu_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Menu Color', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
]);
$this->customizer->add_setting('ahura_menu_hover_color');
$this->customizer->add_control('ahura_menu_hover_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Menu Hover Color', 'ahura'),
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(2);
    },
]);