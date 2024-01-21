<?php
defined('ABSPATH') or die('No script kiddies please!');

$this->customizer->add_setting('ahura_additional_code_in_header');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_additional_code_in_header', array(
    'label' => __( 'Add Code to Header', 'ahura' ),
    'description' => __('HTML tags are allowed.', 'ahura'),
    'code_type' => 'text/html',
    'settings' => 'ahura_additional_code_in_header',
    'section' => $this->current_section,
)));