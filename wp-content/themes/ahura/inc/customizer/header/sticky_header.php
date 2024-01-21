<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;

$this->customizer->add_setting('stickyheader', [ 'default' => true ]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'stickyheader', array(
    'label' => __('Sticky Header','ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('ahura_sticky_header_show_top_scrolling');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_sticky_header_show_top_scrolling', [
    'label' => __('Sticky header show top scrolling','ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return get_theme_mod('stickyheader') == true;
    }
]));

$this->customizer->add_setting('ahura_header_sticking_only_desktop', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_sticking_only_desktop', array(
    'label' => __('Sticking Header Only on Desktop', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return get_theme_mod('stickyheader') == true;
    },
)));