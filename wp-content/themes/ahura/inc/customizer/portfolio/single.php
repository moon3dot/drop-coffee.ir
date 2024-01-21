<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;

$this->customizer->add_setting('ahura_show_portfolio_breadcrumb', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_portfolio_breadcrumb', array(
    'label' => __('Breadcrumb', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_show_portfolio_excerpt', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_portfolio_excerpt', array(
    'label' => __('Excerpt', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_show_portfolio_description', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_portfolio_description', array(
    'label' => __('Content', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_show_related_portfolios', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_related_portfolios', array(
    'label' => __('Our other portfolios', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_related_portfolios_number', ['default' => 3]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_related_portfolios_number', array(
    'label' => __('Related Portfolios Number', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'number',
    'input_attrs' => [
        'min' => 1,
        'max' => 100,
    ],
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_related_portfolios']
)));

$this->customizer->add_setting('ahura_related_portfolios_text_color', ['default' => '#fff']);
$this->customizer->add_control(new WP_Customize_Color_Control( $this->customizer, 'ahura_related_portfolios_text_color', [
    'label'     => __('Related portfolios text color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_related_portfolios_text_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_related_portfolios']
]));

$this->customizer->add_setting('ahura_related_portfolios_bg_color', ['default' => '#00b0ff']);
$this->customizer->add_control(new WP_Customize_Color_Control( $this->customizer, 'ahura_related_portfolios_bg_color', [
    'label'     => __('Related portfolios background color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_related_portfolios_bg_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_related_portfolios']
]));

$this->customizer->add_setting('ahura_show_portfolio_like_box', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_portfolio_like_box', array(
    'label' => __('Portfolio like box', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_portfolio_like_box_title', ['default' => __('Do you like this portfolio?', 'ahura')]);
$this->customizer->add_control(new simple_text( $this->customizer, 'ahura_portfolio_like_box_title', [
    'label' => __('Portfolio like box title', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_portfolio_like_box'],
]));
