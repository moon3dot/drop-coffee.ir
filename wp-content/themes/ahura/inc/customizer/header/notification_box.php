<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_active_alert_box', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_active_alert_box', array(
    'label' => __('Notification Bar', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(2);
    },
)));

$this->customizer->add_setting('ahura_alert_box_text', ['default' => __('Notification Bar Text', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_alert_box_text', [
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Notification Bar Text', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar() && mw_options::is_active_header_style(2);
    },
]));

$this->customizer->add_setting('ahura_active_alert_box_button', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_active_alert_box_button', array(
    'label' => __('Notification Bar Button', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::is_active_notification_bar() && mw_options::is_active_header_style(2);
    },
)));

$this->customizer->add_setting('ahura_alert_box_btn_text', ['default' => __('Button Text', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_alert_box_btn_text', [
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Notification Bar Button Text', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar_button() && mw_options::is_active_header_style(2);
    },
]));

$this->customizer->add_setting('ahura_alert_box_btn_link', ['default' => '#']);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_alert_box_btn_link', [
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Notification Bar Button Link', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar_button() && mw_options::is_active_header_style(2);
    },
]));

$this->customizer->add_setting('ahura_alert_box_text_color');
$this->customizer->add_control('ahura_alert_box_text_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Alert box text color', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar() && mw_options::is_active_header_style(2);
    },
]);

$this->customizer->add_setting('ahura_alert_box_bg_color');
$this->customizer->add_control('ahura_alert_box_bg_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Alert box background color', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar() && mw_options::is_active_header_style(2);
    },
]);

$this->customizer->add_setting('ahura_alert_btn_text_color');
$this->customizer->add_control('ahura_alert_btn_text_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Alert button text color', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar_button() && mw_options::is_active_header_style(2);
    },
]);

$this->customizer->add_setting('ahura_alert_btn_bg_color');
$this->customizer->add_control('ahura_alert_btn_bg_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Alert button background color', 'ahura'),
    'active_callback' => function(){
        return mw_options::is_active_notification_bar_button() && mw_options::is_active_header_style(2);
    },
]);