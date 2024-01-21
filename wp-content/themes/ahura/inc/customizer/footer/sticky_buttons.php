<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\icon_selector;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\multiple_checkbox_control;
use ahura\app\customization\simple_text;

$this->customizer->add_setting('ahura_show_sticky_buttons', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_sticky_buttons', array(
    'label' => __('Sticky Buttons', 'ahura'),
    'section' => $this->current_section,
)));

$places_options = [
    'all' 	    => __( 'All pages', 'ahura' ),
    'home' 	    => __( 'Home page', 'ahura' ),
    'archive'   => __( 'Archive pages', 'ahura' ),
    'page' 	    => __( 'Single pages', 'ahura' ),
];
if(\ahura\app\woocommerce::is_active()){
    $places_options['shop'] = __( 'Shop Page', 'ahura' );
    $places_options['product'] = __( 'Product Page', 'ahura' );
}
$this->customizer->add_setting( 'ahura_sticky_buttons_places', [ 'default'   => ['all' ] ] );
$this->customizer->add_control( new multiple_checkbox_control( $this->customizer, 'ahura_sticky_buttons_places', array(
    'label'    => __( 'Where to show Sticky Buttons', 'ahura' ),
    'section'  => $this->current_section,
    'choices'  => $places_options,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_sticky_buttons'],
) ) );

$this->customizer->add_setting('ahura_show_first_btn_sticky', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_first_btn_sticky', array(
    'label' => __('First Sticky Button', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_sticky_buttons'],
)));

$this->customizer->add_setting('ahura_first_btn_sticky_url', ['default' => '#']);
$this->customizer->add_control( new simple_text( $this->customizer, 'ahura_first_btn_sticky_url',
    array(
        'label' => __('First Button Url', 'ahura'),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_first_sticky_button'],
    )));

$this->customizer->add_setting('ahura_first_btn_sticky_icon', ['default' => 'fab fa-whatsapp']);
$this->customizer->add_control(new icon_selector($this->customizer, 'ahura_first_btn_sticky_icon', array(
    'label' => __('Icon', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_first_sticky_button'],
)));

$this->customizer->add_setting('ahura_first_btn_sticky_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_first_btn_sticky_color', array(
        'label'      => __('Color', 'ahura'),
        'section'    => $this->current_section,
        'settings'   => 'ahura_first_btn_sticky_color',
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_first_sticky_button'],
    ))
);

$this->customizer->add_setting('ahura_show_sec_btn_sticky', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_sec_btn_sticky', array(
    'label' => __('Second Sticky Button', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_sticky_buttons'],
)));

$this->customizer->add_setting('ahura_sec_btn_sticky_url', ['default' => '#']);
$this->customizer->add_control( new simple_text( $this->customizer, 'ahura_sec_btn_sticky_url',
    array(
        'label' => __('Second Button Url', 'ahura'),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_sec_sticky_button'],
    )));

$this->customizer->add_setting('ahura_sec_btn_sticky_icon', ['default' => 'fab fa-telegram']);
$this->customizer->add_control(new icon_selector($this->customizer, 'ahura_sec_btn_sticky_icon', array(
    'label' => __('Icon', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_sec_sticky_button'],
)));

$this->customizer->add_setting('ahura_sec_btn_sticky_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_sec_btn_sticky_color', array(
        'label'      => __('Color', 'ahura'),
        'section'    => $this->current_section,
        'settings'   => 'ahura_sec_btn_sticky_color',
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_sec_sticky_button'],
    ))
);