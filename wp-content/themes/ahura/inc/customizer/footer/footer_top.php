<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\heading_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$default_active_callback = function(){
    return \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_footer_style() == 2;
};

$this->customizer->add_setting('ah_heading_about_us');
$this->customizer->add_control(new heading_box($this->customizer, 'ah_heading_about_us', [
    'label' => __('About Us', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
]));

$this->customizer->add_setting('ah_footer_about_us_title', ['default' => __('About Us', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_about_us_title', array(
    'label' => __( 'Title', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_about_us_text', ['default' => ahura_get_lorem_ipsum()]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_about_us_text', array(
    'label' => __( 'Text', 'ahura' ),
    'type' => 'textarea',
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_heading_legend');
$this->customizer->add_control(new heading_box($this->customizer, 'ah_heading_legend', [
    'label' => __('Footer Slogan', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
]));

$this->customizer->add_setting('ahura_legend', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_legend', array(
    'label' => __( 'Footer Slogan', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
)));
$this->customizer->get_setting( 'ahura_legend' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'ahura_legend', array(
    'selector' => '.footer-legend',
    'render_callback' => '__return_false',
) );
$this->customizer->add_setting('ahura_legend_text');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_legend_text', array(
    'label' => __( 'Footer Slogan Text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan']
)));
$this->customizer->get_setting( 'ahura_legend_text' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'ahura_legend_text', array(
    'selector' => '.footer-legend h5',
    'render_callback' => '__return_false',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan']
) );
$this->customizer->add_setting('ahura_legend_ctalink');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_legend_ctalink', array(
    'label' => __( 'Footer Slogan Link', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan'] // check
)));
$this->customizer->get_setting( 'ahura_legend_ctalink' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'ahura_legend_ctalink', array(
    'selector' => '.footer-legend a',
    'render_callback' => '__return_false',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan'] //check
) );
$this->customizer->add_setting('ahura_legend_ctatext');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_legend_ctatext', array(
    'label' => __( 'Footer Slogan Button Text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan'] //check
)));
$this->customizer->add_setting('ahura_legend_ctatext_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_legend_ctatext_color', array(
    'label' => __( 'Footer Slogan Button Text Color', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan'] //check
)));

$this->customizer->add_setting('ahura_legend_background');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'ahura_legend_background',
    array(
        'label' => __( 'Footer Slogan Background', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'ahura_legend_background',
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_footer_slogan'],
    )));