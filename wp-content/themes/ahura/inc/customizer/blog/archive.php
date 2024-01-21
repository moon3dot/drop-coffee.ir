<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_select_box;
use \ahura\app\mw_options;

$pages = array();
$pages_list = null;
if (\ahura\app\mw_options::is_ahura_builder_accessible()){
    $sectionBuilder = new \ahura\app\elementor\Ahura_Elementor_Builder();
    $pages_list = $sectionBuilder->getPages('archive', get_theme_mod('custom_archive_page'));
}
if($pages_list){
    foreach($pages_list as $page_data) {
        $pages[$page_data->ID] = $page_data->post_title;
    }
} else {
    $pages[1] = esc_html__('Nothing found', 'ahura');
}
$this->customizer->add_setting('use_custom_archive');
$customArchiveArgs = [
    'label' => __('Use custom archive','ahura'),
    'section' => $this->current_section,
];
if(!\ahura\app\mw_options::is_ahura_builder_accessible())
{
    $customArchiveArgs['input_attrs']['disabled'] = true;
    $customArchiveArgs['description'] = esc_html__('Install Elementor plugin to use this option', 'ahura');
}
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_custom_archive', $customArchiveArgs));
$custom_page_id = get_theme_mod('custom_archive_page') ? get_theme_mod('custom_archive_page') : 0;
$this->customizer->add_setting('custom_archive_page');
$this->customizer->add_control(new simple_select_box($this->customizer, 'custom_archive_page', [
    'section' => $this->current_section,
    'label' => __('Custom archive', 'ahura'),
    'choices' => $pages,
    'input_attrs' => [
        'load-ajax' => true,
        'class' => 'ahura-section-select-on-change ahura-section-select-ajax-load-options',
        'data-affected' => '.archive-select-on-change-affected',
        'data-affected-attr' => 'href',
        'data-affected-pattern' => 'post=(.*)&',
        'data-type' => 'header'
    ],
    'links' => [
        [
            'title' => esc_html__('All pages', 'ahura'),
            'url' => admin_url('edit.php?post_type=section_builder'),
            'target' => '_blank',
        ],
        [
            'title' => esc_html__('Edit archive', 'ahura'),
            'url' => admin_url("post.php?post={$custom_page_id}&action=elementor&section_type=archive"),
            'target' => '_blank',
            'class' => 'archive-select-on-change-affected'
        ],
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_custom_archive'],
]));

$this->customizer->add_setting('post-meta-time', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'post-meta-time', array(
    'label' => __( 'Show Time in Archive', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->get_setting( 'post-meta-time' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'post-meta-time', array(
    'selector' => '.post-meta li:nth-child(1)',
    'render_callback' => '__return_false',
) );
$this->customizer->add_setting('post-meta-author', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'post-meta-author', array(
    'label' => __( 'Show Author', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->get_setting( 'post-meta-author' )->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial( 'post-meta-author', array(
    'selector' => '.post-meta li:nth-child(2)',
    'render_callback' => '__return_false',
) );
$this->customizer->add_setting('cat_box_desc');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'cat_box_desc', array(
    'label' => __( 'Hide Category Page Post Box Description', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('blog_archive_hide_title_box');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'blog_archive_hide_title_box', array(
    'label' => __( 'Hide Category Title Box', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('blog_archive_hide_description');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'blog_archive_hide_description', array(
    'label' => __( 'Hide Category Description', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('archive_show_content_types', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'archive_show_content_types', array(
    'label' => __('Show Content Types', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('ahura_new_posts_label_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_new_posts_label_status', array(
    'label' => __('New posts label status', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('ahura_new_posts_label_days_ago', ['default' => 5]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_new_posts_label_days_ago', array(
    'label' => __('Last days ago for new post label', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_title_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_title_color', array(
    'label' => __( 'Post title color', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_title_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_title_font_size', array(
    'label' => __( 'Post title font size', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_title_font_family');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_title_font_family', array(
    'label' => __( 'Post title font family', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices'=> mw_options::get_ahura_fonts(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_title_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_title_font_weight', array(
    'label' => __( 'Post title font weight', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_description_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_description_color', array(
    'label' => __( 'Post description color', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_description_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_description_font_size', array(
    'label' => __( 'Post description font size', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_description_font_family');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_description_font_family', array(
    'label' => __( 'Post description font family', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices'=> mw_options::get_ahura_fonts(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_description_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_description_font_weight', array(
    'label' => __( 'Post title font wright', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_author_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_author_color', array(
    'label' => __( 'Post author color', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_author_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_author_font_size', array(
    'label' => __( 'Post author font size', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_author_font_family');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_author_font_family', array(
    'label' => __( 'Post author font family', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices'=> mw_options::get_ahura_fonts(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_author_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_author_font_weight', array(
    'label' => __( 'Post author font wright', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_time_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_time_color', array(
    'label' => __( 'Post time color', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_time_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_time_font_size', array(
    'label' => __( 'Post time font size', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_time_font_family');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_time_font_family', array(
    'label' => __( 'Post time font family', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices'=> mw_options::get_ahura_fonts(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting('post_time_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'post_time_font_weight', array(
    'label' => __( 'Post time font wright', 'ahura' ),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights(),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));
$this->customizer->add_setting( 'ahura_archive_column', ['default' => '3'] );
$this->customizer->add_control( 'ahura_archive_column', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Archive desktop column', 'ahura' ),
    'choices' => [
        '2' => __( '6', 'ahura' ),
        '3' => __( '4', 'ahura' ),
        '4' => __( '3', 'ahura' ),
        '6' => __( '2', 'ahura' ),
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
] );
$this->customizer->add_setting( 'ahura_archive_column_tablet', ['default' => '4'] );
$this->customizer->add_control( 'ahura_archive_column_tablet', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Archive tablet column', 'ahura' ),
    'choices' => [
        '3' => __( '4', 'ahura' ),
        '4' => __( '3', 'ahura' ),
        '6' => __( '2', 'ahura' ),
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
] );
$this->customizer->add_setting( 'ahura_archive_column_mobile', ['default' => '12'] );
$this->customizer->add_control( 'ahura_archive_column_mobile', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Archive mobile column', 'ahura' ),
    'choices' => [
        '3' => __( '4', 'ahura' ),
        '4' => __( '3', 'ahura' ),
        '6' => __( '2', 'ahura' ),
        '12' => __( '1', 'ahura' ),
    ],
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
] );

$this->customizer->add_setting('ahura_archive_pagination_prev_text', ['default' => __('Previous Page', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_archive_pagination_prev_text', array(
    'label' => __('Pagination Previous Text', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'text',
)));

$this->customizer->add_setting('ahura_archive_pagination_next_text', ['default' => __('Next Page', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_archive_pagination_next_text', array(
    'label' => __('Pagination Next Text', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'text'
)));

$this->customizer->add_setting('ahura_archive_post_thumbnail_width', ['default' => '100%']);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_archive_post_thumbnail_width', array(
    'label' => __('Posts thumbnail width', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'text',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));

$this->customizer->add_setting('ahura_archive_post_thumbnail_height', ['default' => 'auto']);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_archive_post_thumbnail_height', array(
    'label' => __('Posts thumbnail height', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'text',
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_not_active_custom_archive'],
)));