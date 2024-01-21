<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_select_box;

$this->customizer->add_setting('use_custom_404_page');
$custom404Args = [
    'label' => __('Use custom 404 Page','ahura'),
    'section' => $this->current_section,
];
if(!\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $customFooterArgs['input_attrs']['disabled'] = true;
    $customFooterArgs['description'] = esc_html__('Install Elementor plugin to use this option', 'ahura');
}
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_custom_404_page', $custom404Args));

$pages_arr = array();
if(\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $sectionBuilder = new \ahura\app\elementor\Ahura_Elementor_Builder();
    $pages = $sectionBuilder->getPages('error-404', get_theme_mod('custom_404_page'));
    if($pages){
        foreach($pages as $page) {
            $pages_arr[$page->ID] = $page->post_title;
        }
    }
}else{
    $pages_arr[0] = esc_html__('Nothing found', 'ahura');
}

$custom_404_id = get_theme_mod('custom_404_page') ? get_theme_mod('custom_404_page') : 0;
$this->customizer->add_setting('custom_404_page');
$this->customizer->add_control(new simple_select_box($this->customizer, 'custom_404_page', [
    'section' => $this->current_section,
    'label' => __('Custom 404 Page', 'ahura'),
    'choices' => $pages_arr,
    'input_attrs' => [
        'load-ajax' => true,
        'class' => 'ahura-section-select-on-change ahura-section-select-ajax-load-options',
        'data-affected' => '.page-404-select-on-change-affected',
        'data-affected-attr' => 'href',
        'data-affected-pattern' => 'post=(.*)&',
        'data-type' => 'page',
        'data-template' => 'error-404'
    ],
    'links' => [
        [
            'title' => esc_html__('All Pages', 'ahura'),
            'url' => admin_url('edit.php?post_type=section_builder'),
            'target' => '_blank'
        ],
        [
            'title' => esc_html__('Edit Page', 'ahura'),
            'url' => admin_url("post.php?post={$custom_404_id}&action=elementor"),
            'target' => '_blank',
            'class' => 'page-404-select-on-change-affected'
        ]
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_show_text',['default'=>true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_404_show_text',[
    'label' => __( 'Show Text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_text',['default'=>__('Page Not Found!','ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_404_text',[
    'label' => __( 'Text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_show_image',['default'=>true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_404_show_image',[
    'label' => __( 'Show Image', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_image');
$this->customizer->add_control(new WP_Customize_Image_Control($this->customizer, 'ahura_404_image',[
    'label' => __( 'Image', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ahura_404_image',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_show_go_home');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_404_show_go_home',[
    'label' => __( 'Show Go Back Button', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_404_page'],
]));

$this->customizer->add_setting('ahura_404_go_home_text',['default'=>__('Title Here','ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_404_go_home_text',[
    'label' => __( 'Go Back Button Text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
    },
]));

$this->customizer->add_setting('ahura_404_go_home_url');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_404_go_home_url',[
    'label' => __( 'Go Back Button Text URL', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
    },
]));

$this->customizer->add_setting('ahura_404_go_home_background_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_404_go_home_background_color',[
    'label' => __( 'Go Back Button Background Color', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ahura_404_go_home_background_color',
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
    },
]));

$this->customizer->add_setting('ahura_404_go_home_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_404_go_home_color',[
    'label' => __( 'Go Back Button Text Color', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ahura_404_go_home_color',
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
    },
]));

$this->customizer->add_setting('ahura_404_go_home_shadow_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_404_go_home_shadow_color',[
    'label' => __( 'Go Back Button Shadow Color', 'ahura' ),
    'section' => $this->current_section,
    'settings' => 'ahura_404_go_home_shadow_color',
    'active_callback' => function(){
        return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
    },
]));

$this->customizer->add_setting('ahura_404_go_home_border_radius', ['default' => 10]);
$this->customizer->add_control(new simple_range( $this->customizer, 'ahura_404_go_home_border_radius',array(
        'label' => __('Go Back Button Border Radius','ahura'),
        'section' => $this->current_section,
        'input_attrs' => array(
            'min' => 0,
            'max' => 100,
        ),
        'active_callback' => function(){
            return $this->active_conditions(['get_mod_is_not_active_custom_404_page', 'get_show_404_page_back_button']);
        },
    ) )
);