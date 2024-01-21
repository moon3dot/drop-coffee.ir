<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting('ahura_show_preloader');
$this->customizer->add_control(
    new ios_checkbox( $this->customizer, 'ahura_show_preloader',array(
        'label' => __('Show Preloader','ahura'),
        'section' => $this->current_section,
    ) )
);

$this->customizer->add_setting('ahura_use_ready_preloader');
$this->customizer->add_control(
    new ios_checkbox( $this->customizer, 'ahura_use_ready_preloader',array(
        'label' => __('Use Ready Preloader','ahura'),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_preloader'],
    ) )
);

$preview_dir_url = get_template_directory_uri() . '/img/preview/';

$preloader_types = array(
    'cube' => [
        'image_url' => $preview_dir_url . 'cube-loader.webp',
    ],
    'line' => [
        'image_url' => $preview_dir_url . 'line-loader.webp',
    ],
    'heart-rate' => [
        'image_url' => $preview_dir_url . 'heart-rate-loader.webp',
    ],
    'spinner' => [
        'image_url' => $preview_dir_url . 'spinner-loader.webp',
    ],
);

$this->customizer->add_setting('ahura_ready_preloader_type', ['default' => 'cube']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_ready_preloader_type',array(
    'label' => __( 'Preloader Type', 'ahura' ),
    'section' => $this->current_section,
    'choices' => $preloader_types,
    'active_callback' => ['\ahura\app\mw_options','get_mod_use_ready_preloader'],
)));

$this->customizer->add_setting('ahura_preloader_picture');
$this->customizer->add_control(
    new WP_Customize_Image_Control( $this->customizer, 'ahura_preloader_picture',array(
        'label' => __('Preloader Center Picture','ahura'),
        'section' => $this->current_section,
        'setting' => 'ahura_preloader_picture',
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_show_preloader() && !\ahura\app\mw_options::get_mod_use_ready_preloader();
        },
    ) )
);

$this->customizer->add_setting('ahura_preloader_text', ['default' => __('Please wait...', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_preloader_text', array(
    'label' => __('Preloader Text', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'text',
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_preloader'],
)));

$this->customizer->add_setting('ahura_preloader_background');
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_preloader_background',array(
        'label' => __('Preloader Background','ahura'),
        'section' => $this->current_section,
        'setting' => 'ahura_preloader_background',
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_preloader'],
    ) )
);

$this->customizer->add_setting('ahura_preloader_text_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_preloader_text_color',array(
        'label' => __('Preloader Text Color','ahura'),
        'section' => $this->current_section,
        'setting' => 'ahura_preloader_text_color',
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_preloader'],
    ) )
);