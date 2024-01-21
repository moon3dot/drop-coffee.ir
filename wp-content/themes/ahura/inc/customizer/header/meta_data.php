<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting('ahura_use_meta_data', ['default' => true]);
$this->customizer->add_control(
    new ios_checkbox(
        $this->customizer, 'ahura_use_meta_data', array(
        'label'      => __( 'Use Meta Data', 'ahura' ),
        'section'    => $this->current_section,
    ) )
);

$this->customizer->add_setting('theme_viewport_maximum_scale', ['default' => 1]);
$this->customizer->add_control(new simple_text($this->customizer, 'theme_viewport_maximum_scale', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Maximum Scale', 'ahura'),
    'description' => __('For Mobile Device', 'ahura'),
    'input_attrs' => [
        'min' => 1,
    ],
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_use_meta_data']
]));

$this->customizer->add_setting('theme_viewport_user_scalable', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'theme_viewport_user_scalable', [
    'label' => __('User Scalable', 'ahura'),
    'section' => $this->current_section,
    'description' => __('For Mobile Device', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_use_meta_data']
]));