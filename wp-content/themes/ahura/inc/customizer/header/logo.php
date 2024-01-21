<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_notice;
use ahura\app\customization\simple_text;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_theme_logo');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'ahura_theme_logo',
    array(
        'label' => __( 'Your Logo', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'ahura_theme_logo',
        'description' => __( 'Recommended size: 304 X 98px', 'ahura' ),
        'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_not_active_custom_header'],
    ) ) );

$this->customizer->add_setting('ahura_logo_notice');
$this->customizer->add_control( new simple_notice( $this->customizer, 'ahura_logo_notice',[
        'description' => __( 'Please change logo from custom header created in wp admin area > theme settings > Ahura header builder', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_custom_header'],
    ]
));

$this->customizer->get_setting( 'ahura_theme_logo' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'ahura_theme_logo', array(
    'selector' => '.logo',
    'render_callback' => '__return_false',
));

$this->customizer->add_setting('ahura_use_mobile_logo', ['default' => false]);
$this->customizer->add_control(
    new ios_checkbox(
        $this->customizer, 'ahura_use_mobile_logo', array(
        'label'      => __( 'Use Mobile Logo', 'ahura' ),
        'section'    => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
    ) )
);

$this->customizer->add_setting('ahura_theme_mobile_logo');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'ahura_theme_mobile_logo',
    array(
        'label' => __( 'Mobile Logo', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'ahura_theme_mobile_logo',
        'description' => __( 'The maximum width of the logo should be 450px.', 'ahura' ),
        'active_callback' => function (){
            return \ahura\app\mw_options::get_mod_theme_use_mobile_logo() && \ahura\app\mw_options::get_mod_is_not_active_custom_header();
        },
    ) ) );
$this->customizer->get_setting( 'ahura_theme_mobile_logo' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'ahura_theme_mobile_logo', array(
    'selector' => '.logo',
    'render_callback' => '__return_false',
) );

$this->customizer->add_setting('ahura_logo_text', ['default' => get_bloginfo('name')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_logo_text', array(
    'label' => __('Logo Text', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'text',
    'active_callback' => function(){
        return !\ahura\app\mw_options::get_mod_logo_option();
    }
)));

$logo_alignments = [
    'right' => [
        'label' => __('Right', 'ahura'),
        'image_url' => get_template_directory_uri() . '/img/customization/header/logo_alignment_right.png',
    ],
    'center' => [
        'label' => __("Center", 'ahura'),
        'image_url' => get_template_directory_uri() . '/img/customization/header/logo_alignment_center.png',
    ],
    'left' => [
        'label' => __("Left", 'ahura'),
        'image_url' => get_template_directory_uri() . '/img/customization/header/logo_alignment_left.png',
    ],
];

$this->customizer->add_setting('ahura_header_logo_alignment', ['default' => 'right']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_header_logo_alignment', [
    'label' => __("Logo alignment", 'ahura'),
    'section' => $this->current_section,
    'choices' => $logo_alignments,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    }
]));

unset($logo_alignments['center']);
$this->customizer->add_setting('ahura_header_logo_alignment_rl', ['default' => 'right']);
$this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_header_logo_alignment_rl', [
    'label' => __("Logo alignment", 'ahura'),
    'section' => $this->current_section,
    'choices' => $logo_alignments,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(2);
    }
]));
