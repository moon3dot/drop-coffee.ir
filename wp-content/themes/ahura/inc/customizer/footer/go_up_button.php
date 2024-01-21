<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\simple_range;

$this->customizer->add_setting('ahura_goto_top_position', ['default' => 'right']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_goto_top_position', [
    'section' => $this->current_section,
    'label' => __("Goto-top button position", 'ahura'),
    'choices' => [
        'right' => [
            'label' => __("Right", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/layout/goto_top_button_right.png',
        ],
        'left' => [
            'label' => __("Left", 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/layout/goto_top_button_left.png',
        ],
        'none' => [
            'label' => __('None', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/layout/goto_top_button_none.png',
        ]
    ]
]));

$this->customizer->add_setting('ahura_gototop_widget_radius', ['default' => 5]);
$this->customizer->add_control(
    new simple_range( $this->customizer, 'ahura_gototop_widget_radius',array(
        'label' => __('Got to top border radius','ahura'),
        'description' => __('Default 5px','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
        'active_callback' => ['\ahura\app\mw_options','get_show_goto_top_button'],
    ) )
);