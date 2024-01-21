<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_text;
use ahura\app\mw_options;

$this->customizer->add_setting('ahura_remove_header_search_box');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_remove_header_search_box', [
    'label' => __("Remove Header Search Box", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_search_box_placeholder');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_search_box_placeholder', [
    'label' => __("Search Box Placeholder", 'ahura'),
    'section' => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_searhc_box']
]));

$this->customizer->add_setting('ahura_search_icon_color', ['default' => '#35495C']);
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_search_icon_color', array(
        'label'      => __( 'Search icon color', 'ahura' ),
        'section'    => $this->current_section,
        'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_searhc_box']
    ) )
);

$this->customizer->add_setting('ahura_search_in_product');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_search_in_product', [
    'label' => __("Search in Products", 'ahura'),
    'section' => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_searhc_box']
]));

$this->customizer->add_setting('ahura_is_active_ajax_search', ['default' => true]);
$this->customizer->add_control(
    new ios_checkbox($this->customizer, 'ahura_is_active_ajax_search', [
        'label' =>  __('Active ajax search', "ahura"),
        'section' => $this->current_section,
        'active_callback' => function(){
            return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
        },
    ])
);
$this->customizer->add_setting('ajax_search_results_number');
$this->customizer->add_control(new simple_text($this->customizer, 'ajax_search_results_number', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Ajax search results number', 'ahura'),
    'description' => __('Leave it blank for unlimited results', 'ahura'),
]));
$this->customizer->add_setting('ajax_search_background_opacity', ['default' => 80]);
$this->customizer->add_control(new simple_range($this->customizer, 'ajax_search_background_opacity', [
    'label' => __('Ajax search background opacity','ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    },
    'input_attrs' => [
        'min' => 0,
        'max' => 100
    ],
]));
$this->customizer->add_setting('ajax_seach_font_color');
$this->customizer->add_control('ajax_seach_font_color', [
    'section' => $this->current_section,
    'type' => 'color',
    'label' => __('Ajax search font color', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
]);
$this->customizer->add_setting('ajax_search_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ajax_search_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Ajax search font size', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_not_active_custom_header'],
]));
$this->customizer->add_setting('ajax_search_result_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ajax_search_result_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Ajax search result font size', 'ahura'),
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(1);
    }
]));
$this->customizer->selective_refresh->add_partial('ahura_is_active_ajax_search',[
    'selector' => '.header-mode-1 .search-form, .header-mode-3 .search-form, .header-mode-2 .action-box #action_search'
]);