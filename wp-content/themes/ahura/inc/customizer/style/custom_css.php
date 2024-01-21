<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$this->customizer->add_setting('ahura_custom_css_code');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_custom_css_code', array(
    'label' => __( 'Custom Css Code', 'ahura' ),
    'code_type' => 'text/css',
    'settings' => 'ahura_custom_css_code',
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_tablet_custom_css_code');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_tablet_custom_css_code', array(
    'label' => __( 'Custom Css Code for Tablet', 'ahura' ),
    'code_type' => 'text/css',
    'settings' => 'ahura_tablet_custom_css_code',
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_mobile_custom_css_code');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'ahura_mobile_custom_css_code', array(
    'label' => __( 'Custom Css Code for Mobile', 'ahura' ),
    'code_type' => 'text/css',
    'settings' => 'ahura_mobile_custom_css_code',
    'section' => $this->current_section,
)));