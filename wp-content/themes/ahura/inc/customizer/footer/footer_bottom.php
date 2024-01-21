<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting( 'footer-copyright', [ 'default' => __( 'All rights reserved.', 'ahura' ) ] );
$this->customizer->add_control(new simple_text($this->customizer, 'footer-copyright', array(
    'label' => __( 'Footer Right Copyright', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
)));

$this->customizer->get_setting( 'footer-copyright' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'footer-copyright', array(
    'selector' => '.footer-copyright',
    'render_callback' => '__return_false',
) );

$this->customizer->add_setting('footer-copyright2');
$this->customizer->add_control(new simple_text($this->customizer, 'footer-copyright2', array(
    'label' => __( 'Footer Left Copyright', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
)));

$this->customizer->get_setting( 'footer-copyright2' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'footer-copyright2', array(
    'selector' => '.footer-copyright2',
    'render_callback' => '__return_false',
) );

$this->customizer->add_setting('change_footer_namad_and_copyright_direction');
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'change_footer_namad_and_copyright_direction',
    array(
        'label' => __( 'Change Copyright And Namad Direction', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_footer_style() == 1;
        },
    )));