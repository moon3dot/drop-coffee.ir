<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\heading_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\mw_assets;

$this->customizer->add_setting('ah_footer_show_information_box', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ah_footer_show_information_box', array(
    'label' => __( 'Show Information Box', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_footer_style() == 2;
    }
)));

$default_active_callback = function(){
    return \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_footer_style() == 2 && \ahura\app\mw_options::get_show_information_box();
};

$this->customizer->add_setting('ah_footer_information_box_bg_color', ['default' => '#3c4b6d0d']);
$this->customizer->add_control(
    new \WP_Customize_Color_Control(
        $this->customizer, 'ah_footer_information_box_bg_color', array(
        'label'      => __( 'Background Color', 'ahura' ),
        'settings'   => 'ah_footer_information_box_bg_color',
        'section'    => $this->current_section,
        'active_callback' => $default_active_callback
    ) )
);

$this->customizer->add_setting('ah_footer_information_box_text_color', ['default' => '#333']);
$this->customizer->add_control(
    new \WP_Customize_Color_Control(
        $this->customizer, 'ah_footer_information_box_text_color', array(
        'label'      => __( 'Text Color', 'ahura' ),
        'settings'   => 'ah_footer_information_box_text_color',
        'section'    => $this->current_section,
        'active_callback' => $default_active_callback
    ) )
);

$this->customizer->add_setting('ah_heading_contact_info');
$this->customizer->add_control(new heading_box($this->customizer, 'ah_heading_contact_info', [
    'label' => __('Contact Information', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
]));

$this->customizer->add_setting('ah_footer_contact_phone_number', ['default' => '09123456789']);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_contact_phone_number', array(
    'label' => __( 'Phone Number', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_contact_email', ['default' => 'info@domain.com']);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_contact_email', array(
    'label' => __( 'Email', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_contact_address', ['default' => __('Iran, Fars, Shiraz', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_contact_address', array(
    'label' => __( 'Address', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_heading_icons');
$this->customizer->add_control(new heading_box($this->customizer, 'ah_heading_icons', [
    'label' => __('Icons', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
]));

$this->customizer->add_setting('ah_footer_icon1', ['default' => mw_assets::get_img('icons.svg.icon-refund', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon1', array(
    'label' => __( 'Icon 1', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon1',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon1_title', ['default' => __('Refund', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon1_title', array(
    'label' => __( 'Icon Title 1', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon2', ['default' => mw_assets::get_img('icons.svg.icon-warranty', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon2', array(
    'label' => __( 'Icon 2', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon2',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon2_title', ['default' => __('Product warranty', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon2_title', array(
    'label' => __( 'Icon Title 2', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon3', ['default' => mw_assets::get_img('icons.svg.icon-payout', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon3', array(
    'label' => __( 'Icon 3', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon3',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon3_title', ['default' => __('Pay on site', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon3_title', array(
    'label' => __( 'Icon Title 3', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon4', ['default' => mw_assets::get_img('icons.svg.icon-support', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon4', array(
    'label' => __( 'Icon 4', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon4',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon4_title', ['default' => __('Fast support', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon4_title', array(
    'label' => __( 'Icon Title 4', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon5', ['default' => mw_assets::get_img('icons.svg.icon-refund', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon5', array(
    'label' => __( 'Icon 5', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon5',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon5_title', ['default' => __('Refund', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon5_title', array(
    'label' => __( 'Icon Title 5', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon6', ['default' => mw_assets::get_img('icons.svg.icon-payout', 'svg')]);
$this->customizer->add_control( new \WP_Customize_Image_Control( $this->customizer, 'ah_footer_icon6', array(
    'label' => __( 'Icon 6', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ah_footer_icon6',
    'active_callback' => $default_active_callback
)));

$this->customizer->add_setting('ah_footer_icon6_title', ['default' => __('Pay on site', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ah_footer_icon6_title', array(
    'label' => __( 'Icon Title 6', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => $default_active_callback
)));