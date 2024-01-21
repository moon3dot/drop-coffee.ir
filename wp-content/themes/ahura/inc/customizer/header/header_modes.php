<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_select_box;
use ahura\app\mw_options;

$headers = array();
$header_list = null;
if (\ahura\app\mw_options::is_ahura_builder_accessible()){
    $sectionBuilder = new \ahura\app\elementor\Ahura_Elementor_Builder();
    $header_list = $sectionBuilder->getHeaders(get_theme_mod('custom_header'));
}
if($header_list){
    foreach($header_list as $header) {
        $headers[$header->ID] = $header->post_title;
    }
} else {
    $headers[1] = esc_html__('Nothing found', 'ahura');
}
$this->customizer->add_setting('use_custom_header');
$customHeaderArgs = [
    'label' => __('Use custom header','ahura'),
    'section' => $this->current_section,
];
if(!\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $customHeaderArgs['input_attrs']['disabled'] = true;
    $customHeaderArgs['description'] = esc_html__('Install Elementor plugin to use this option', 'ahura');
}
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_custom_header', $customHeaderArgs));
$custom_header_id = get_theme_mod('custom_header') ? get_theme_mod('custom_header') : 0;
$this->customizer->add_setting('custom_header');
$this->customizer->add_control(new simple_select_box($this->customizer, 'custom_header', [
    'section' => $this->current_section,
    'label' => __('Custom header', 'ahura'),
    'choices' => $headers,
    'input_attrs' => [
        'load-ajax' => true,
        'class' => 'ahura-section-select-on-change ahura-section-select-ajax-load-options',
        'data-affected' => '.header-select-on-change-affected',
        'data-affected-attr' => 'href',
        'data-affected-pattern' => 'post=(.*)&',
        'data-type' => 'header'
    ],
    'links' => [
        [
            'title' => esc_html__('All headers', 'ahura'),
            'url' => admin_url('edit.php?post_type=section_builder'),
            'target' => '_blank',
        ],
        [
            'title' => esc_html__('Edit header', 'ahura'),
            'url' => admin_url("post.php?post={$custom_header_id}&action=elementor"),
            'target' => '_blank',
            'class' => 'header-select-on-change-affected'
        ],
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_custom_header'],
]));

$this->customizer->add_setting('ahura_header_style', ['default' => 1]);
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_header_style', [
    'section' => $this->current_section,
    'label' => __('Header Style', 'ahura'),
    'choices' => [
        1 => __('Style 1', 'ahura'),
        2 => __('Style 2', 'ahura'),
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header'],
]));

$this->customizer->add_setting('ahura_header_is_transparent', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_is_transparent', [
    'label' => __('Transparent Header', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahorua_transparent_logo');
$this->customizer->add_control(new WP_Customize_Image_Control($this->customizer, 'ahorua_transparent_logo', [
    'label' => __("Logo in transparent mode", 'ahura'),
    'section' => $this->current_section,
    'description' => __( 'Recommended size: 304 X 98px', 'ahura' ),
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_header', 'check_is_transparent_header']);
    },
]));

$this->customizer->add_setting('ahura_header_transparent_content_color');
$this->customizer->add_control('ahura_header_transparent_content_color', [
    'label' => __("Header content color", 'ahura'),
    'type' => 'color',
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::check_is_transparent_header() && mw_options::is_active_header_style(1);
    }
]);

$this->customizer->add_setting('ahura_header_box_mode', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_box_mode', array(
    'label' => __('Box Mode', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(2);
    },
)));

$this->customizer->add_setting('ahura_header_sticking_top', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_header_sticking_top', array(
    'label' => __('Sticking Top', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && mw_options::is_active_header_style(2) && mw_options::is_active_header_box_mode();
    },
)));

$this->customizer->add_setting('ahura_change_header_dimension', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_change_header_dimension', array(
    'label' => __('Change Header Dimension', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return mw_options::get_mod_is_not_active_custom_header() && !mw_options::is_active_header_box_mode();
    },
)));

$this->customizer->add_setting('ahura_header_width', ['default' => 81.77]);
$this->customizer->add_control(new simple_range($this->customizer, 'ahura_header_width', [
    'label' => __('Width','ahura'),
    'section' => $this->current_section,
    'input_attrs' => [
        'step' => 0.01,
        'min' => 0,
        'max' => 100,
    ],
    'active_callback' => function(){
        return \ahura\app\mw_options::get_mod_is_not_active_custom_header() && get_theme_mod('ahura_change_header_dimension') == true && !mw_options::is_active_header_box_mode();
    }
]));

$this->customizer->add_setting('topmenu_dropdown_list_topmargin', ['default' => 35]);
$this->customizer->add_control(new simple_range($this->customizer, 'topmenu_dropdown_list_topmargin', [
    'label' => __('Top menu dropdown list margin from top','ahura'),
    'section' => $this->current_section,
    'input_attrs' => [
        'step' => 1,
        'min' => 0,
        'max' => 100,
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_is_show_header_top_border', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_is_show_header_top_border', [
    'label' => __('Show header top border','ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_header_top_border_height', ['default' => 4]);
$this->customizer->add_control(new simple_range($this->customizer, 'ahura_header_top_border_height', [
    'label' => __('Header top border height','ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_show_header_top_border'],
    'input_attrs' => [
        'min' => 4,
        'max' => 25
    ],
]));

$this->customizer->add_setting('ahura_header_background',['default'=>'#fff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_background', [
    'label' => __("Header Background", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_remove_header_shadow');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_remove_header_shadow', [
    'label' => __("Remove Header Shadow", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_header']
]));

$this->customizer->add_setting('ahura_header_top_box_background_color', ['default' => '#ffffff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_top_box_background_color', [
    'label' => __("Header top box", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'check_is_header_top_box_background_color_accessible']
]));

$this->customizer->add_setting('ahura_header_bottom_box_background_color', ['default' => '#ffffff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_bottom_box_background_color', [
    'label' => __("Bottom top box", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'check_is_header_bottom_box_background_color_accessible']
]));

$this->customizer->add_setting('ahura_header_top_and_bottom_box_text_color', ['default' => '#35495C']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_header_top_and_bottom_box_text_color', [
    'label' => __("Menu text color", 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'check_is_header_top_and_bottom_box_text_color_accessible']
]));