<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\image_radio_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_range;
use ahura\app\customization\simple_notice;
use \ahura\app\mw_options;

$this->customizer->add_setting(
    'show_single_post_thumbnail',
    array('default' => 'right')
);
$this->customizer->add_control(new image_radio_box($this->customizer, 'show_single_post_thumbnail', array(
    'label' => __('Post Thumbnail in Content', 'ahura'),
    'section' => $this->current_section,
    'choices' => array(
        'right' => [
            'label' => __('Right', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/post_thumbnail_alignment_right.png',
        ],
        'center' => [
            'label' => __('Center', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/post_thumbnail_alignment_center.png',
        ],
        'left' => [
            'label' => __('Left', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/post_thumbnail_alignment_left.png',
        ],
        'wide' => [
            'label' => __('Wide', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/post_thumbnail_alignment_wide.png',
        ],
        'none' => [
            'label' => __('Hide', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/post_thumbnail_alignment_hidden.png',
        ],
    ),
)));

$this->customizer->add_setting('absolute_thumbnail');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'absolute_thumbnail', array(
    'label' => __('Abosulte thumbnail', 'ahura'),
    'section' => $this->current_section,
    'active_callback'=> ['\ahura\app\mw_options','is_active_absolute_thumbnail'],
)));
$this->customizer->add_setting('show_single_post_title', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_single_post_title', array(
    'label' => __('Show Title', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('show_tags', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_tags', array(
    'label' => __('Show Tags', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('show_content_types', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_content_types', array(
    'label' => __('Show Content Types', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('post-meta-comments', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'post-meta-comments', array(
    'label' => __('Show Comments Count', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('show_categories', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_categories', array(
    'label' => __('Show categories', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->get_setting('show_tags')->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial('show_tags', array(
    'selector' => '.post-entry #tags',
    'render_callback' => '__return_false',
));
$this->customizer->add_setting('show_author', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_author', array(
    'label' => __('Show Post Author', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->get_setting('show_author')->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial('show_author', array(
    'selector' => '.post-entry .authorbox',
    'render_callback' => '__return_false',
));
$this->customizer->add_setting('show_post_sharing', ['default'  => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_post_sharing', array(
    'label' => __('Show Share Buttons', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('post_sharing_title', ['default'  => __('Share ...','ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'post_sharing_title', array(
    'label' => __('Share Box Title', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'text',
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
)));
$this->customizer->add_setting( 'show_post_sharing_facebook', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_facebook', [
    'label' => __( 'Show facebook button', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_twitter', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_twitter', [
    'label' => __( 'Show twitter button', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_linkedin', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_linkedin', [
    'label' => __( 'Show linkedin button', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_telegram', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_telegram', [
    'label' => __( 'Show telegram buttons', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_pinterest', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_pinterest', [
    'label' => __( 'Show pinterest buttons', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_whatsapp', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_whatsapp', [
    'label' => __( 'Show whatsapp buttons', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting( 'show_post_sharing_gmail', ['default'  => true] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'show_post_sharing_gmail', [
    'label' => __( 'Show gmail buttons', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_show_post_sharing']
] ) );
$this->customizer->add_setting('show_date');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_date', array(
    'label' => __('Show post date', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting( 'show_update_date' );
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_update_date', [
    'label'     => __( 'Show post update date', 'ahura' ),
    'section'   => $this->current_section,
] ) );
$this->customizer->add_setting( 'post_update_date_icon', [ 'default' => 'fas fa-history' ] );
$this->customizer->add_control( new simple_text( $this->customizer, 'post_update_date_icon', [
    'label'     => __( 'Post update date icon', 'ahura' ),
    'description' => __( 'Use font awesome 5 icon. Example: fas fa-history', 'ahura' ),
    'section'   => $this->current_section,
    'active_callback'   =>  [ '\ahura\app\mw_options', 'get_mod_is_active_post_show_update_date' ]
] ) );
$this->customizer->add_setting( 'post_update_date_text' );
$this->customizer->add_control( new simple_text( $this->customizer, 'post_update_date_text', [
    'label' => __( 'Update date text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options', 'get_mod_is_active_post_show_update_date' ],
] ) );
$this->customizer->add_setting( 'post_update_date_text_color', [ 'default' => '#333333' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer, 'post_update_date_text_color', [
    'label'     => __( 'Post update date text color', 'ahura' ),
    'section'   => $this->current_section,
    'settings'  => 'post_update_date_text_color',
    'active_callback'   =>  [ '\ahura\app\mw_options', 'get_mod_is_active_post_show_update_date' ]
] ) );
$this->customizer->add_setting( 'post_update_date_text_backcolor', [ 'default' => '#ffffff' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer, 'post_update_date_text_backcolor', [
    'label'     => __( 'Post update date text background color', 'ahura' ),
    'section'   => $this->current_section,
    'settings'  => 'post_update_date_text_backcolor',
    'active_callback'   =>  [ '\ahura\app\mw_options', 'get_mod_is_active_post_show_update_date' ]
] ) );

$des_wbc = \ahura\app\mw_options::is_ahura_builder_accessible() ? esc_html__('This feature is disabled in pages that are build with elementor.', 'ahura') : '';
$this->customizer->add_setting('ahura_show_widgets_between_post_content', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_widgets_between_post_content', array(
    'label' => __('Widgets between content', 'ahura'),
    'section' => $this->current_section,
    'description' => $des_wbc
)));

$this->customizer->add_setting('ahura_widgets_between_post_content_position', ['default' => 1]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_widgets_between_post_content_position', [
    'type' => 'number',
    'label' => __('Widgets between content position', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_show_widgets_between_post_content'],
]));

$this->customizer->add_setting('use_ahura_player');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'use_ahura_player', array(
    'label' => __( 'Use Ahura player', 'ahura' ),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('single_post_show_titles_helper_box', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'single_post_show_titles_helper_box', [
    'label'     => __( 'Show Titles Helper Box', 'ahura' ),
    'section'   => $this->current_section,
] ) );

$this->customizer->add_setting('show_relatedposts', ['default'  => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_relatedposts', array(
    'label' => __('Related Posts', 'ahura'),
    'section' => $this->current_section,
)));
$this->customizer->add_setting('show_relatedposts_ontags', ['default'  => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_relatedposts_ontags', array(
    'label' => __('Related Posts on tags', 'ahura'),
    'section' => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_relatedpost']
)));
$this->customizer->add_setting( 'relatedposts_img_height', [ 'default' => 100 ] );
$this->customizer->add_control(
    new simple_range( $this->customizer, 'relatedposts_img_height', [
        'label' => __( 'Related posts image height', 'ahura' ),
        'description' => __( 'Default 100px', 'ahura' ),
        'section' => $this->current_section,
        'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_relatedpost'],
        'input_attrs' => [
            'min' => 50,
            'max' => 500,
        ],
    ] )
);
$this->customizer->add_setting( 'relatedposts_img_darkness', [ 'default' => 0 ] );
$this->customizer->add_control(
    new simple_range( $this->customizer, 'relatedposts_img_darkness', [
        'label' => __( 'Related posts image darkness', 'ahura' ),
        'section' => $this->current_section,
        'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_relatedpost'],
        'input_attrs' => [
            'min' => 0,
            'max' => 100,
        ],
    ] )
);
$this->customizer->add_setting('show_breadcrumb');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_breadcrumb', [
    'label' => __('Show Breadcrumb', 'ahura'),
    'section' => $this->current_section
]));
$this->customizer->add_setting('breadcrumb');
$this->customizer->add_control(new image_radio_box($this->customizer, 'breadcrumb', [
    'label' => __('Breadcrumb Dispaly Mode', 'ahura'),
    'section' => $this->current_section,
    'choices' => array(
        'one' => [
            'label' => __('One', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/breadcrumb_mode_mode_1.png',
        ],
        'two' => [
            'label' => __('Two', 'ahura'),
            'image_url' => get_template_directory_uri() . '/img/customization/posts/breadcrumb_mode_mode_2.png',
        ],
    ),
    'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_breadcrumb']
]));
$this->customizer->add_setting('breadcrumb_seprator');
$this->customizer->add_control('breadcrumb_seprator', [
    'type' => 'text',
    'section' => $this->current_section,
    'label' => __('Breadcrumb seprator', 'ahura'),
    'active_callback'   =>  ['\ahura\app\mw_options','get_mod_is_active_breadcrumb']
]);
$this->customizer->get_setting('show_relatedposts')->transport   = 'postMessage';
$this->customizer->selective_refresh->add_partial('show_relatedposts', array(
    'selector' => '.related-posts',
    'render_callback' => '__return_false',
));
if (get_bloginfo('language') == 'fa-IR') {
    if (get_theme_mod('ahura_custom_font')) {
        $this->customizer->add_setting('ahura_post_font_family', [
            'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
        ]);
        $this->customizer->add_control('ahura_post_font_family', [
            'section' => $this->current_section,
            'type' => 'select',
            'label' => __("Post Paragraph Font Family", 'ahura'),
            'choices' => mw_options::get_ahura_fonts(),
        ]);
    } else {
        $this->customizer->add_setting('ahura_post_font_family', [
            'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
        ]);
        $this->customizer->add_control('ahura_post_font_family', [
            'section' => $this->current_section,
            'type' => 'select',
            'label' => __("Post Paragraph Font Family", 'ahura'),
            'choices' => mw_options::get_ahura_fonts(),
        ]);
    }
} else {
    $this->customizer->add_setting('ahura_en_post_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_post_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Theme Font",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('ahura_post_content_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_font_weight', array(
    'label' => __('Post content font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));
if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_post_title_font_family', [
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_post_title_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Post Title Font Family", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(),
    ]);
} else {
    $this->customizer->add_setting('ahura_en_post_title_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_post_title_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Theme Font",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('ahura_post_title_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_title_font_weight', array(
    'label' => __('Post title font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));
if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_single_post_author_font_family', [
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_single_post_author_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Post author font family", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(),
    ]);
} else {
    $this->customizer->add_setting('ahura_en_single_post_author_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_single_post_author_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Post author font family",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('single_post_author_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'single_post_author_font_weight', array(
    'label' => __('Post author font wright', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_single_post_cats_font_family', [
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_single_post_cats_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Post cats font family", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(),
    ]);
} else {
    $this->customizer->add_setting('ahura_en_single_post_cats_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_single_post_cats_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Post cats font family",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('single_post_cats_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'single_post_cats_font_weight', array(
    'label' => __('Post cats font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_single_post_comment_count_font_family', [
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_single_post_comment_count_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Post comment count font family", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(),
    ]);
} else {
    $this->customizer->add_setting('ahura_en_single_post_comment_count_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_single_post_comment_count_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Post comment count font family",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('single_post_comment_count_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'single_post_comment_count_font_weight', array(
    'label' => __('Post comment count font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_single_post_date_font_family', [
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_single_post_date_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Post date font family", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(),
    ]);
} else {
    $this->customizer->add_setting('ahura_en_single_post_date_font_family', [
        'default' => 'default_font',
        'sanitize_callback' => ['\ahura\app\mw_options', 'sanitize_select_field']
    ]);
    $this->customizer->add_control('ahura_en_single_post_date_font_family', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Post date font family",
        'choices' => mw_options::get_ahura_fonts()
    ]);
}
$this->customizer->add_setting('single_post_date_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'single_post_date_font_weight', array(
    'label' => __('Post date font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('single_post_author_name_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'single_post_author_name_font_size', array(
    'label' => __('Post author font size', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'number',
)));

$this->customizer->add_setting('single_post_cats_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'single_post_cats_font_size', array(
    'label' => __('Post cats font size', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'number',
)));

$this->customizer->add_setting('single_post_comment_count_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'single_post_comment_count_font_size', array(
    'label' => __('Post comment count font size', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'number',
)));

$this->customizer->add_setting('single_post_date_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'single_post_date_font_size', array(
    'label' => __('Post date font size', 'ahura'),
    'section' => $this->current_section,
    'type'    => 'number',
)));

$this->customizer->add_setting('post_paragraph_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_paragraph_size', array(
    'label' => __('Post paragraph font size', 'ahura'),
    'section' => $this->current_section,
    'description' => __('Default 16px', 'ahura'),
    'type'    => 'number',
)));

$this->customizer->add_setting('post_paragraph_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_paragraph_size', array(
    'label' => __('Post paragraph font size', 'ahura'),
    'section' => $this->current_section,
    'description' => __('Default 16px', 'ahura'),
    'type'    => 'number',
)));

$this->customizer->add_setting('post_paragraph_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_paragraph_size', array(
    'label' => __('Post paragraph font size', 'ahura'),
    'section' => $this->current_section,
    'description' => __('Default 16px', 'ahura'),
    'type'    => 'number',
)));

$this->customizer->add_setting('post_paragraph_a_size');
$this->customizer->add_control(new simple_text($this->customizer, 'post_paragraph_a_size', array(
    'label' => __('Post paragraph link font size', 'ahura'),
    'section' => $this->current_section,
    'description' => __('Default 16px', 'ahura'),
    'type'    => 'number',
)));
$this->customizer->add_setting('ahura_post_title_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_post_title_font_size', array(
    'label' => __('Post Title Fotn Size', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'number',
)));

$this->customizer->add_setting('ahura_post_content_h1_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h1_font_weight', array(
    'label' => __('H1 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_post_content_h2_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h2_font_weight', array(
    'label' => __('H2 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_post_content_h3_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h3_font_weight', array(
    'label' => __('H3 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_post_content_h4_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h4_font_weight', array(
    'label' => __('H4 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_post_content_h5_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h5_font_weight', array(
    'label' => __('H5 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_post_content_h6_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_post_content_h6_font_weight', array(
    'label' => __('H6 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('post_paragraph_color', ['default' => '#35495c']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_paragraph_color', array(
    'label' => __('Post paragraph color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'post_paragraph_color',
)));

$this->customizer->add_setting('post_paragraph_a_color', ['default' => '#35495c']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'post_paragraph_a_color', array(
    'label' => __('Post paragraph link color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'post_paragraph_a_color',
)));

$this->customizer->add_setting('ahura_post_title_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_title_color', array(
    'label' => __('Post Title Color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_title_color',
)));
$this->customizer->add_setting('ahura_post_background_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_background_color', array(
    'label' => __('Post Background Color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_background_color',
)));
$this->customizer->add_setting( 'ahura_post_quote', [ 'default' => 'column' ] );
$this->customizer->add_control( 'ahura_post_quote', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Quote citation position', 'ahura' ),
    'settings' => 'ahura_post_quote',
    'choices' => [
        'column-reverse' => __( 'top', 'ahura' ),
        'row-reverse' => __( 'right', 'ahura' ),
        'column' => __( 'bottom', 'ahura' ),
        'row' => __( 'left', 'ahura' ),
    ],
] );

$this->customizer->add_setting( 'ahura_switch_sidebar_order_mobile', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_switch_sidebar_order_mobile', [
    'label' => __( 'Switch sidebar and main content order in mobile view', 'ahura' ),
    'section' => $this->current_section,
] ) );

$this->customizer->add_setting('ahura_show_post_like_box', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_show_post_like_box', [
    'label' => __('Post like', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_post_like_save_data_for_user', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_post_like_save_data_for_user', [
    'label' => __('Save like data for logged in user', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_post_like_box'],
]));

$this->customizer->add_setting('get_mod_post_like_save_data_for_user_notice');
$this->customizer->add_control(new simple_notice($this->customizer, 'get_mod_post_like_save_data_for_user_notice',[
        'description' => __('Note: if the number of users of your website if high, it is recommended not to use this possibility, if it is used, the size of the usermeta database may increase significantly.', 'ahura'),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_post_like_save_data_for_user'],
    ]
));

$this->customizer->add_setting('ahura_post_like_box_title', ['default' => esc_html__('Was this post helpful to you?', 'ahura')]);
$this->customizer->add_control(new simple_text( $this->customizer, 'ahura_post_like_box_title', [
    'label'     => __('Post like box title', 'ahura'),
    'section'   => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
]));

$this->customizer->add_setting('ahura_post_like_button_title', ['default' => esc_html__('Yes', 'ahura')]);
$this->customizer->add_control(new simple_text( $this->customizer, 'ahura_post_like_button_title', [
    'label'     => __('Post like button title', 'ahura'),
    'section'   => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
]));

$this->customizer->add_setting('ahura_post_dislike_button_title', ['default' => esc_html__('No', 'ahura')]);
$this->customizer->add_control(new simple_text( $this->customizer, 'ahura_post_dislike_button_title', [
    'label'     => __('Post dislike button title', 'ahura'),
    'section'   => $this->current_section,
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
]));

$this->customizer->add_setting('ahura_post_like_box_bg_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_like_box_bg_color', array(
    'label' => __('Post like box background color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_like_box_bg_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting('ahura_post_like_box_title_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_like_box_title_color', array(
    'label' => __('Post like box title color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_like_box_title_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting('ahura_post_like_button_text_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_like_button_text_color', array(
    'label' => __('Post like button text color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_like_button_text_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting('ahura_post_like_button_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_like_button_color', array(
    'label' => __('Post like button color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_like_button_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting('ahura_post_dislike_button_text_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_dislike_button_text_color', array(
    'label' => __('Post dislike button text color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_dislike_button_text_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting('ahura_post_dislike_button_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'ahura_post_dislike_button_color', array(
    'label' => __('Post dislike button color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'ahura_post_dislike_button_color',
    'active_callback'   =>  ['\ahura\app\mw_options', 'get_mod_show_post_like_box']
)));

$this->customizer->add_setting( 'ahura_comment_form_controls', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_comment_form_controls', [
    'label' => __( 'Controls single post comment area fields', 'ahura' ),
    'section' => $this->current_section,
] ) );
$this->customizer->add_setting( 'ahura_email_fields_notice', [ 'default' => '' ] );
$this->customizer->add_control( new simple_notice( $this->customizer, 'ahura_email_fields_notice',[
        'description' => __( 'Please disable required email and name\'s field from admin area > options > discussion', 'ahura' ),
        'section' => $this->current_section,
        'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_email_form_controls'],
    ]
) );
$this->customizer->add_setting( 'ahura_comment_form_name_control', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_comment_form_name_control', [
    'label' => __( 'Disable name field in comment area', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_email_form_controls'],
] ) );
$this->customizer->add_setting( 'ahura_comment_form_email_control', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_comment_form_email_control', [
    'label' => __( 'Disable email field in comment area', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_email_form_controls'],
] ) );
$this->customizer->add_setting( 'ahura_comment_form_url_control', [ 'default'  => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_comment_form_url_control', [
    'label' => __( 'Disable url field in comment area', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_email_form_controls'],
] ) );

$this->customizer->add_setting('comment_send_button_background');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'comment_send_button_background', array(
    'label' => __('Commcnt Send Button Background', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'comment_send_button_background',
)));

$this->customizer->add_setting('comment_send_button_color');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer, 'comment_send_button_color', array(
    'label' => __('Comment Send Button Color', 'ahura'),
    'section' => $this->current_section,
    'settings' => 'comment_send_button_color',
)));