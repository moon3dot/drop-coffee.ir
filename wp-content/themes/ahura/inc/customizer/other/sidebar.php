<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_select_box;

if (class_exists('LifterLMS')) {
    if(is_rtl()){
        $llms_columns_items = [
            'right' => [
                'label' => __( 'Right Sidebar', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/layout/site_columns_right.png',
            ],
            'left' => [
                'label' => __( 'Left Sidebar', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/layout/site_columns_left.png',
            ],
        ];
    } else {
        $llms_columns_items = [
            'left' => [
                'label' => __( 'Left Sidebar', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/layout/site_columns_left.png',
            ],
            'right' => [
                'label' => __( 'Right Sidebar', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/layout/site_columns_right.png',
            ],
        ];
    }
    $this->customizer->add_setting('ahura_llms_sidebar_position',array(
        'default' => 'left',
    ));
    $this->customizer->add_control(new image_radio_box($this->customizer, 'ahura_llms_sidebar_position', array(
        'section' => $this->current_section,
        'label' => __('LifterLMS sidebar position', 'ahura'),
        'choices' => $llms_columns_items
    )));
}

$this->customizer->add_setting('ahura_sidebar_mode', ['default' => 1]);
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_sidebar_mode', [
    'section' => $this->current_section,
    'label' => __('Sidebar Style', 'ahura'),
    'choices' => [
        1 => __('Style 1', 'ahura'),
        2 => __('Style 2', 'ahura'),
    ],
]));

$this->customizer->add_setting('ahura_fixed_sidebar');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_fixed_sidebar',array(
    'section' => $this->current_section,
    'label' => __( 'Fixed sidebar', 'ahura' ),
)));

$this->customizer->add_setting( 'ahura_hidden_mobile_sidebar' );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_hidden_mobile_sidebar', [
    'section' => $this->current_section,
    'label' => __( 'Hide mobile sidebar', 'ahura' ),
] ) );

$this->customizer->add_setting( 'ahura_hidden_post_mobile_sidebar' );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_hidden_post_mobile_sidebar', [
    'section' => $this->current_section,
    'label' => __( 'Hide mobile post sidebar', 'ahura' ),
    'active_callback'   =>  [ '\ahura\app\mw_options', 'get_mod_is_active_hidden_mobile_sidebar' ]
] ) );

$this->customizer->add_setting( 'ahura_hidden_shop_mobile_sidebar' );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_hidden_shop_mobile_sidebar', [
    'section' => $this->current_section,
    'label' => __( 'Hide mobile shop sidebar', 'ahura' ),
    'active_callback'   =>  [ '\ahura\app\mw_options', 'get_mod_is_active_hidden_mobile_sidebar' ]
] ) );

$this->customizer->add_setting('ahura_border_sidebar_title_color',array('default' => '#35495c',));
$this->customizer->add_control(
    new WP_Customize_Color_Control( $this->customizer, 'ahura_border_sidebar_title_color',array(
        'label' => __('Border right sidebar title color','ahura'),
        'setting' => 'ahura_border_sidebar_title_color',
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_sidebar_mode() == 1;
        }
    ) )
);