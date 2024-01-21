<?php
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\customization\heading_box;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_notice;
use ahura\app\mw_options;
use ahura\app\woocommerce;

if (get_bloginfo('language') == 'fa-IR') {
    $this->customizer->add_setting('ahura_theme_font', ['default' => 'iransans']);
    $this->customizer->add_control('ahura_theme_font', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => __("Theme Font", 'ahura'),
        'choices' => mw_options::get_ahura_fonts(false)
    ]);
} else {
    $this->customizer->add_setting('use_fa_fonts', ['default' => false]);
    $this->customizer->add_control(new ios_checkbox($this->customizer, 'use_fa_fonts',array(
        'section' => $this->current_section,
        'label' => __( 'Use FA Fonts', 'ahura' ),
    )));

    $this->customizer->add_setting('ahura_use_fa_fonts_notice');
    $this->customizer->add_control( new simple_notice($this->customizer, 'ahura_use_fa_fonts_notice',[
            'description' => __('After enabled the use of FA fonts, you must reload the page.', 'ahura'),
            'section' => $this->current_section,
            'active_callback' => ['\ahura\app\mw_options','get_mod_not_use_fa_fonts_status'],
        ]
    ));

    $this->customizer->add_setting('ahura_en_theme_font', ['default' => 'default_font']);
    $this->customizer->add_control('ahura_en_theme_font', [
        'section' => $this->current_section,
        'type' => 'select',
        'label' => "Theme Font",
        'choices' => mw_options::get_ahura_fonts(false)
    ]);
}

$this->customizer->add_setting('ahura_theme_font_weight', ['default' => 'normal']);
$this->customizer->add_control('ahura_theme_font_weight', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __("Font Weight", 'ahura'),
    'choices' => mw_options::get_font_weights()
]);

$this->customizer->add_setting('ahura_logo_text_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_logo_text_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Logo Text Font Size', 'ahura'),
    'active_callback' => function(){
        return !\ahura\app\mw_options::get_mod_logo_option();
    }
]));

$this->customizer->add_setting('ahura_heading_menu_typography');
$this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_menu_typography', [
    'label' => __('Main Menu', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_menu_font_family');
$this->customizer->add_control('ahura_menu_font_family', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __('Menu Font Family', 'ahura'),
    'choices' => mw_options::get_ahura_fonts(),
]);

$this->customizer->add_setting('ahura_menu_font_weight', ['default' => 'normal']);
$this->customizer->add_control('ahura_menu_font_weight', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __("Menu Font Weight", 'ahura'),
    'choices' => mw_options::get_font_weights()
]);

$this->customizer->add_setting('ahura_menu_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_menu_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Menu Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_heading_footer_typography');
$this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_footer_typography', [
    'label' => __('Footer', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_footer_widget_font_family');
$this->customizer->add_control('ahura_footer_widget_font_family', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __('Footer Widget Title Font Family', 'ahura'),
    'choices' => mw_options::get_ahura_fonts(),
]);

$this->customizer->add_setting('ahura_footer_widget_font_weight', ['default' => 'normal']);
$this->customizer->add_control('ahura_footer_widget_font_weight', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __("Footer Widget Title Font Weight", 'ahura'),
    'choices' => mw_options::get_font_weights()
]);

$this->customizer->add_setting('ahura_footer_widget_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_footer_widget_font_size', [
    'label' => __('Footer Widget Font Size', 'ahura'),
    'section' => $this->current_section,
    'type' => 'number',
    'input_attrs' => array(
        'min' => 1,
    ),
]));

$this->customizer->add_setting('ahura_heading_mega_menu_typography');
$this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_mega_menu_typography', [
    'label' => __('Mega Menu', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_mega_menu_font_family');
$this->customizer->add_control('ahura_mega_menu_font_family', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __('Mega Menu Font Family', 'ahura'),
    'choices' => mw_options::get_ahura_fonts(),
]);

$this->customizer->add_setting('ahura_mega_menu_font_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_mega_menu_font_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Mega Menu Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_mega_menu_font_weight', ['default' => 'normal']);
$this->customizer->add_control('ahura_mega_menu_font_weight', [
    'section' => $this->current_section,
    'type' => 'select',
    'label' => __("Mega Menu Font Weight", 'ahura'),
    'choices' => mw_options::get_font_weights()
]);

$this->customizer->add_setting('ahura_heading_h_tags_typography');
$this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_h_tags_typography', [
    'label' => __('H Tags', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_heading_1_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_1_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 1 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h1_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h1_font_weight', array(
    'label' => __('H1 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_heading_2_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_2_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 2 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h2_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h2_font_weight', array(
    'label' => __('H2 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_heading_3_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_3_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 3 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h3_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h3_font_weight', array(
    'label' => __('H3 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_heading_4_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_4_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 4 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h4_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h4_font_weight', array(
    'label' => __('H4 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_heading_5_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_5_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 5 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h5_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h5_font_weight', array(
    'label' => __('H5 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

$this->customizer->add_setting('ahura_heading_6_size');
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_heading_6_size', [
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __('Heading 6 Font Size', 'ahura'),
]));

$this->customizer->add_setting('ahura_h6_font_weight');
$this->customizer->add_control(new WP_Customize_Control($this->customizer, 'ahura_h6_font_weight', array(
    'label' => __('H6 font weight', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'select',
    'choices' => mw_options::get_font_weights()
)));

if(woocommerce::is_active()){
    $this->customizer->add_setting('ahura_heading_shop_typography');
    $this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_shop_typography', [
        'label' => __('Shop', 'ahura'),
        'section' => $this->current_section,
    ]));

    $this->customizer->add_setting('product_title_desktop_font_size');
    $this->customizer->add_control(new simple_text($this->customizer, 'product_title_desktop_font_size', [
        'section' => $this->current_section,
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'label' => __('Main shop product title desktop view Font Size', 'ahura'),
    ]));

    $this->customizer->add_setting('product_title_mobileview_font_size');
    $this->customizer->add_control(new simple_text($this->customizer, 'product_title_mobileview_font_size', [
        'section' => $this->current_section,
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'label' => __('Main shop product title mobile view Font Size', 'ahura'),
    ]));

    $this->customizer->add_setting('price_mobileview_multicol_font_size');
    $this->customizer->add_control(new simple_text($this->customizer, 'price_mobileview_multicol_font_size', [
        'section' => $this->current_section,
        'type' => 'number',
        'input_attrs' => array(
            'min' => 1,
        ),
        'label' => __('Main shop product price mobile view Font Size', 'ahura'),
    ]));
}

$this->customizer->add_setting('ahura_heading_typography_controls');
$this->customizer->add_control(new heading_box($this->customizer, 'ahura_heading_typography_controls', [
    'label' => __('Typography Controls', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_paragraph_alignment', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_paragraph_alignment', [
    'section' => $this->current_section,
    'label' => __('Justify paragraph', 'ahura'),
]));
$this->customizer->add_setting('ahura_light_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_light_font', [
    'section' => $this->current_section,
    'label' => __('Remove Light Font Weight', 'ahura'),
]));
$this->customizer->add_setting('ahura_ultralight_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_ultralight_font', [
    'section' => $this->current_section,
    'label' => __('Remove UltraLight Font Weight', 'ahura'),
]));
$this->customizer->add_setting('ahura_medium_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_medium_font', [
    'section' => $this->current_section,
    'label' => __('Remove Medium Font Weight', 'ahura'),
]));
$this->customizer->add_setting('ahura_bold_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_bold_font', [
    'section' => $this->current_section,
    'label' => __('Remove Bold Font Weight', 'ahura'),
]));
$this->customizer->add_setting('ahura_black_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_black_font', [
    'section' => $this->current_section,
    'label' => __('Remove Black Font Weight', 'ahura'),
]));

$this->customizer->add_setting('ahura_disable_theme_font');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_disable_theme_font', [
    'section' => $this->current_section,
    'label' => __('Disable all fonts', 'ahura'),
]));
