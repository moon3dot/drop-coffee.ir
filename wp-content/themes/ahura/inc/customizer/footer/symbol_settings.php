<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting('footer_namad_check',['default' => false]);
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'footer_namad_check',
    array(
        'label' => __( 'Show Footer Symbol', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
    )));

$this->customizer->add_setting('use_enamad_html',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_enamad_html',
    array(
        'label' => __('Use enamad html code', 'ahura'),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbols() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer();
        },
    )
));

$this->customizer->add_setting('footer_enamad_html_code');
$this->customizer->add_control(new WP_Customize_Code_Editor_Control($this->customizer, 'footer_enamad_html_code', array(
    'label' => __( 'Symbol Html Code', 'ahura' ),
    'code_type' => 'text/html',
    'settings' => 'footer_enamad_html_code',
    'section' => $this->current_section,
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_show_footer_symbols', 'get_mod_is_not_active_custom_footer', 'get_mod_enamad_use_html_code']);
    },
)));

$this->customizer->add_setting('show_symbol1',['default' => true]);
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_symbol1',
    array(
        'label' => __( 'Show Footer Symbol 1', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbols() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));

$this->customizer->add_setting('show_symbol2',['default' => true]);
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_symbol2',
    array(
        'label' => __( 'Show Footer Symbol 2', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbols() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));

$this->customizer->add_setting('footer_namad1');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'footer_namad1',
    array(
        'label' => __( 'Footer Symbol 1', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'footer_namad1',
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbol1() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));

$this->customizer->add_setting('footer_namad1_url',['default' => '#']);
$this->customizer->add_control( new simple_text( $this->customizer, 'footer_namad1_url',
    array(
        'label' => __( 'Footer Symbol 1 Url', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbol1() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));

$this->customizer->add_setting('footer_namad2');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'footer_namad2',
    array(
        'label' => __( 'Footer Symbol 2', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'footer_namad2',
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbol2() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));

$this->customizer->add_setting('footer_namad2_url', ['default' => '#']);
$this->customizer->add_control( new simple_text( $this->customizer, 'footer_namad2_url',
    array(
        'label' => __( 'Footer Symbol 2 Url', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_footer_symbol2() && \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_mod_not_enamad_use_html_code();
        },
    )));