<?php
defined('ABSPATH') or die('No script kiddies please!');

$this->customizer->add_setting('ahura_additional_code_in_footer');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_additional_code_in_footer', array(
    'label' => __( 'Add Code to Footer', 'ahura' ),
    'description' => __('HTML tags are allowed.', 'ahura'),
    'code_type' => 'text/html',
    'settings' => 'ahura_additional_code_in_footer',
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_custom_js');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_custom_js', array(
    'label' => __( 'Custom JS', 'ahura' ),
    'code_type' => 'javascript',
    'settings' => 'ahura_custom_js',
    'section' => $this->current_section,
)));