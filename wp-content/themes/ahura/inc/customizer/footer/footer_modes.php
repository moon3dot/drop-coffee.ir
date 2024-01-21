<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\ios_radio_box;
use ahura\app\customization\simple_notice;
use ahura\app\customization\simple_select_box;

$footers_arr = array();
if(\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $sectionBuilder = new \ahura\app\elementor\Ahura_Elementor_Builder();
    $footers = $sectionBuilder->getFooters(get_theme_mod('custom_footer'));
    if($footers){
        foreach($footers as $footer) {
            $footers_arr[$footer->ID] = $footer->post_title;
        }
    }
}else{
    $footers_arr[1] = esc_html__('Nothing found', 'ahura');
}

$this->customizer->add_setting('use_custom_footer');
$customFooterArgs = [
    'label' => __('Use custom Footer','ahura'),
    'section' => $this->current_section,
];
if(!\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $customFooterArgs['input_attrs']['disabled'] = true;
    $customFooterArgs['description'] = esc_html__('Install Elementor plugin to use this option', 'ahura');
}
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_custom_footer', $customFooterArgs));

$custom_footer_id = get_theme_mod('custom_footer') ? get_theme_mod('custom_footer') : 0;
$this->customizer->add_setting('custom_footer');
$this->customizer->add_control(new simple_select_box($this->customizer, 'custom_footer', [
    'section' => $this->current_section,
    'label' => __('Custom Footer', 'ahura'),
    'choices' => $footers_arr,
    'input_attrs' => [
        'load-ajax' => true,
        'class' => 'ahura-section-select-on-change ahura-section-select-ajax-load-options',
        'data-affected' => '.footer-select-on-change-affected',
        'data-affected-attr' => 'href',
        'data-affected-pattern' => 'post=(.*)&',
        'data-type' => 'footer'
    ],
    'links' => [
        [
            'title' => esc_html__('All Footers', 'ahura'),
            'url' => admin_url('edit.php?post_type=section_builder'),
            'target' => '_blank'
        ],
        [
            'title' => esc_html__('Edit footer', 'ahura'),
            'url' => admin_url("post.php?post={$custom_footer_id}&action=elementor"),
            'target' => '_blank',
            'class' => 'footer-select-on-change-affected'
        ],
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_custom_footer'],
]));

$this->customizer->add_setting('ahura_footer_style', ['default' => 1]);
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_footer_style', [
    'section' => $this->current_section,
    'label' => __('Footer Style', 'ahura'),
    'choices' => [
        1 => __('Style 1', 'ahura'),
        2 => __('Style 2', 'ahura'),
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
]));

$this->customizer->add_setting('ahura_default_footer_notice', ['default' => true]);
$this->customizer->add_control(new simple_notice($this->customizer, 'ahura_default_footer_notice',array(
    'section' => $this->current_section,
    'description' => sprintf(__( 'You can edit the content of the footer from the %s.', 'ahura'), sprintf("<a href='%s' target='_blank'>%s</a>", admin_url('widgets.php'), __('widgets page', 'ahura'))),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
)));

$this->customizer->add_setting('footer_columns');
$this->customizer->add_control( new image_radio_box( $this->customizer, 'footer_columns',
    array(
        'label' => __( 'Footer Columns', 'ahura' ),
        'section' => $this->current_section,
        'choices' => array(
            '1c' => [
                'label' => __( '1 Column', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/footer/footer_columns_1c.png',
            ],
            '2c' => [
                'label' => __( '2 Column', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/footer/footer_columns_2c.png',
            ],
            '3c' => [
                'label' => __( '3 Column', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/footer/footer_columns_3c.png',
            ],
            '4c' => [
                'label' => __( '4 Column', 'ahura' ),
                'image_url' => get_template_directory_uri() . '/img/customization/footer/footer_columns_4c.png',
            ],
        ),
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
    )));

$this->customizer->add_setting('ahura_footer_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_footer_color', array(
        'label'      => __( 'Background Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_footer_color',
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
    ) )
);

$this->customizer->add_setting('ahura_footer_widget_font_color');
$this->customizer->add_control('ahura_footer_widget_font_color', [
    'label' => __('Footer Widget Title Color', 'ahura'),
    'type' => 'color',
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
]);

$this->customizer->add_setting('ahura_footer_text_color');
$this->customizer->add_control(
    new WP_Customize_Color_Control(
        $this->customizer, 'ahura_footer_text_color', array(
        'label'      => __( 'Text Color', 'ahura' ),
        'section'    => $this->current_section,
        'settings'   => 'ahura_footer_text_color',
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
    ) )
);

$this->customizer->add_setting('ahura_footer_bg');
$this->customizer->add_control( new WP_Customize_Image_Control( $this->customizer, 'ahura_footer_bg',
    array(
        'label' => __( 'Footer Background', 'ahura' ),
        'section' => $this->current_section,
        'settings' => 'ahura_footer_bg',
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_footer'],
    )));
$this->customizer->add_setting('ahura_footer_bg_size', ['default' => 'auto']);
$this->customizer->add_control(new ios_radio_box($this->customizer, 'ahura_footer_bg_size', [
    'section' => $this->current_section,
    'label' => __("Background Size", 'ahura'),
    'choices' => [
        'auto' => __("Auto", 'ahura'),
        'contain' => __('Contain', 'ahura'),
        'cover' => __('Cover', 'ahura')
    ],
    'active_callback' => ['\ahura\app\mw_options', 'check_has_footer_bg'] // check
]));

$this->customizer->add_setting('remove_footer_border_top');
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'remove_footer_border_top',
    array(
        'label' => __( 'Remove Footer Border Top', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => function(){
            return \ahura\app\mw_options::get_mod_is_not_active_custom_footer() && \ahura\app\mw_options::get_footer_style() == 1;
        },
    )));
