<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;

$this->customizer->add_setting('ahura_show_portfolio_archive_breadcrumb', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_portfolio_archive_breadcrumb', array(
    'label' => __('Breadcrumb', 'ahura'),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_portfolio_archive_cover_height', ['default' => 260]);
$this->customizer->add_control(
    new simple_range($this->customizer, 'ahura_portfolio_archive_cover_height', [
        'label' => __('Portfolio cover height', 'ahura'),
        'section' => $this->current_section,
        'input_attrs' => [
            'min' => 0,
            'max' => 1000,
        ],
    ])
);

$this->customizer->add_setting('ahura_portfolio_archive_title_color', ['default' => '#333']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_portfolio_archive_title_color', [
    'label'     => __('Archive title color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_portfolio_archive_title_color',
]));

$this->customizer->add_setting('ahura_portfolio_archive_portfolio_title_color', ['default' => '#333']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_portfolio_archive_portfolio_title_color', [
    'label'     => __('Portfolio title color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_portfolio_archive_portfolio_title_color',
]));

$this->customizer->add_setting('ahura_portfolio_archive_cover_bg_color', ['default' => '#00b0ff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_portfolio_archive_cover_bg_color', [
    'label'     => __('Portfolio cover background color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_portfolio_archive_cover_bg_color',
]));

$this->customizer->add_setting('ahura_portfolio_archive_cover_text_color', ['default' => '#fff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_portfolio_archive_cover_text_color', [
    'label'     => __('Portfolio cover text color', 'ahura'),
    'section'   => $this->current_section,
    'settings'  => 'ahura_portfolio_archive_cover_text_color',
]));