<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_select_box;
use ahura\app\customization\simple_notice;

$this->customizer->add_setting('ahura_shop_product_loop_style', ['default' => 1]);
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_shop_product_loop_style', [
    'section' => $this->current_section,
    'label' => __('Products Style', 'ahura'),
    'choices' => [
        'default' => __('Woocommerce Default', 'ahura'),
        1 => __('Style 1', 'ahura'),
        2 => __('Style 2', 'ahura'),
    ],
]));

$this->customizer->add_setting('ahura_shop_product_loop_style_notice',['default' => true]);
$this->customizer->add_control(new simple_notice($this->customizer, 'ahura_shop_product_loop_style_notice',array(
    'section' => $this->current_section,
    'description' => __( 'Suitable for using woocommerce default elements in elementor.', 'ahura' ),
    'active_callback' => function(){
        return \ahura\app\mw_options::get_product_item_style() == 'default';
    },
)));

$this->customizer->add_setting('ahura_shop_page_product_title_color', ['default' => '#000']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_shop_page_product_title_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_shop_page_product_title_color',
        'label' => __( 'Product Title Color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_shop_page_description_color', ['default' => '#000']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_shop_page_description_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_shop_page_description_color',
        'label' => __( 'Shop description color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_product_cover_hover_color', ['default' => '#00b0ff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_product_cover_hover_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_product_cover_hover_color',
        'label' => __( 'Product cover color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_product_regular_price_color',['default' => '#66BB6A']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_product_regular_price_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_product_regular_price_color',
        'label' => __( 'Product regular price color', 'ahura' ),
    ))
);


$this->customizer->add_setting('ahura_product_sale_price_color',['default' => '#66BB6A']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_product_sale_price_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_product_sale_price_color',
        'label' => __( 'Product sale price color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_onsale_date_color',['default' => '#dd3333']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_onsale_date_color',[
        'section' => $this->current_section,
        'setting' => 'ahura_onsale_date_color',
        'label' => __( 'Onsale date price color', 'ahura' ),
    ])
);

$this->customizer->add_setting('ahura_onsale_label_color',['default' => '#ffffff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_onsale_label_color',[
        'section' => $this->current_section,
        'setting' => 'ahura_onsale_label_color',
        'label' => __( 'Onsale label color', 'ahura' ),
    ])
);

$this->customizer->add_setting('ahura_onsale_label_backcolor',['default' => '#dd3333']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_onsale_label_backcolor',[
        'section' => $this->current_section,
        'setting' => 'ahura_onsale_label_backcolor',
        'label' => __( 'Onsale label back color', 'ahura' ),
    ])
);

$this->customizer->add_setting('ahura_shop_per_page',['default' => '9']);
$this->customizer->add_control(
    new simple_text($this->customizer,'ahura_shop_per_page',array(
        'section' => $this->current_section,
        'type' => 'number',
        'label' => __( 'Shop product per page', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_shop_product_title_words_number');
$this->customizer->add_control( new simple_text($this->customizer,'ahura_shop_product_title_words_number', [
    'label'   => __('Maximum number of title words', 'ahura' ),
    'type'    => 'number',
    'section' => $this->current_section,
]));

$this->customizer->add_setting( 'ahura_product_desktop_column', ['default' => '3'] );
$this->customizer->add_control( 'ahura_product_desktop_column', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Product shop desktop column', 'ahura' ),
    'choices' => [
        '2' => __( '2', 'ahura' ),
        '3' => __( '3', 'ahura' ),
        '4' => __( '4', 'ahura' ),
        '6' => __( '6', 'ahura' ),
    ],
] );

$this->customizer->add_setting( 'ahura_product_mobile_column', ['default' => '1'] );
$this->customizer->add_control( 'ahura_product_mobile_column', [
    'type' => 'select',
    'section' => $this->current_section,
    'label' => __( 'Product shop mobile column', 'ahura' ),
    'choices' => [
        '1' => __( '1', 'ahura' ),
        '2' => __( '2', 'ahura' ),
        '3' => __( '3', 'ahura' ),
    ],
] );

$this->customizer->add_setting('ahura_shop_show_product_quick_view',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_quick_view',array(
    'label' => __( 'Product quick view feature', 'ahura' ),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_shop_move_out_of_stock_products_to_end',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_move_out_of_stock_products_to_end',array(
    'label' => __( 'Move out of stock products to end', 'ahura' ),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_shop_show_peoduct_tags',['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_peoduct_tags',array(
    'label' => __( 'Show product tags', 'ahura' ),
    'section' => $this->current_section,
)));

$this->customizer->add_setting('ahura_active_woocommerce_element_mini_cart', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_active_woocommerce_element_mini_cart',[
    'label'   => __( 'Active woocommerce element mini cart', 'ahura' ),
    'description' => __('Changing the content of elementor mini card element to wooCommerce main format', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_shop_show_boxcover', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_boxcover',[
    'section' => $this->current_section,
    'label'   => __( 'Hide products box cover', 'ahura' ),
    'active_callback' => function(){
        return \ahura\app\mw_options::get_product_item_style() == 1;
    },
]));

$this->customizer->add_setting('ahura_shop_show_boxshadow', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_boxshadow',[
    'section' => $this->current_section,
    'label'   => __( 'Show product box shadow', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_isnot_active_show_boxcover_status'],
]));

$this->customizer->add_setting('ahura_shop_show_addtocartbtn_onproduct', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_addtocartbtn_onproduct',[
    'section' => $this->current_section,
    'label'   => __( 'Hide product box add to cart button', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_isnot_active_show_boxcover_status'],
]));

$this->customizer->add_setting('shop_products_change_add_to_cart_button_text_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'shop_products_change_add_to_cart_button_text_status',[
    'section' => $this->current_section,
    'label'   => __( 'Change add to cart button text', 'ahura' ),
]));

$this->customizer->add_setting('shop_products_add_to_cart_button_text', ['default' => esc_html__('Add to Cart', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer,'shop_products_add_to_cart_button_text',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Add to cart button text', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_change_products_add_to_cart_button_text_status'],
)));

$this->customizer->add_setting('ahura_shop_show_cat_onproduct', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_cat_onproduct',[
    'section' => $this->current_section,
    'label'   => __( 'Hide product box category', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_isnot_active_show_boxcover_status'],
]));

$this->customizer->add_setting('ahura_shop_show_product_onsale_percent',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_onsale_percent',array(
    'section' => $this->current_section,
    'label' => __( 'Show product onsale percent', 'ahura' ),
)));

$this->customizer->add_setting('woocommerce_sale_text');
$this->customizer->add_control(new simple_text($this->customizer, 'woocommerce_sale_text', [
    'label' => __('Special sales text', 'ahura'),
    'section' => $this->current_section,
]));

$this->customizer->add_setting('ahura_shop_show_product_stock_status',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_stock_status',array(
    'section' => $this->current_section,
    'label' => __( 'Show product stock status in shop', 'ahura' ),
)));
$this->customizer->add_setting('ahura_shop_show_product_stock_status_background',['default' => '#EE384E']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_show_product_stock_status_background',array(
    'section' => $this->current_section,
    'setting' => 'ahura_shop_show_product_stock_status_background',
    'label' => __( 'Product stock status background in shop', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_show_product_stock_status'],
)));
$this->customizer->add_setting('ahura_shop_show_product_stock_status_color',['default' => '#fff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_show_product_stock_status_color',array(
    'section' => $this->current_section,
    'setting' => 'ahura_shop_show_product_stock_status_color',
    'label' => __( 'Product stock status color in shop', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_show_product_stock_status'],
)));
$this->customizer->add_setting('ahura_shop_product_stock_count_background');
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_product_stock_count_background',array(
    'section' => $this->current_section,
    'setting' => 'ahura_shop_product_stock_count_background',
    'label' => __( 'Product stock count background', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_show_product_stock_status'],
)));
$this->customizer->add_setting('ahura_shop_product_stock_count_color',['default' => '#EE384E']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_product_stock_count_color',array(
    'section' => $this->current_section,
    'setting' => 'ahura_shop_product_stock_count_color',
    'label' => __( 'Product stock count color', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_show_product_stock_status'],
)));
$this->customizer->add_setting('ahura_shop_show_product_stock_status_fontsize',['default' => '12']);
$this->customizer->add_control(new simple_text($this->customizer,'ahura_shop_show_product_stock_status_fontsize',array(
    'section' => $this->current_section,
    'type' => 'number',
    'label' => __( 'Product stock status font size in shop', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_show_product_stock_status'],
    'description' =>  __('Default 12px','ahura'),
)));

$this->customizer->add_setting('ahura_shop_alert_background',['default'=>'#a46497']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_alert_background',array(
    'section' => 'woocommerce_store_notice',
    'label' => __( 'Background Color', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_shop_alert_settings'],
)));
$this->customizer->add_setting('ahura_shop_alert_color',['default'=>'#fff']);
$this->customizer->add_control(new WP_Customize_Color_Control($this->customizer,'ahura_shop_alert_color',array(
    'section' => 'woocommerce_store_notice',
    'label' => __( 'Color', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_shop_alert_settings'],
)));
$this->customizer->add_setting('ahura_shop_alert_fontsize',['default' => '16']);
$this->customizer->add_control(new simple_text($this->customizer,'ahura_shop_alert_fontsize',array(
    'section' => 'woocommerce_store_notice',
    'type' => 'number',
    'label' => __( 'Font size', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_shop_alert_settings'],
)));
$this->customizer->add_setting('show_woocommerce_breadcrumb');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_woocommerce_breadcrumb', [
    'label' => __('Show Breadcrumb', 'ahura'),
    'section' => $this->current_section
]));
$this->customizer->add_setting('show_product_cat_des_to_all_pages', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_product_cat_des_to_all_pages', [
    'label' => __('Show product category description to all pages', 'ahura'),
    'section' => $this->current_section
]));
$this->customizer->add_setting('move_product_catdescription');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'move_product_catdescription', [
    'label' => __('Move product category description to the end', 'ahura'),
    'section' => $this->current_section
]));
$this->customizer->add_setting('move_buy_button', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'move_buy_button', [
    'label' => __('Move buy button to the end', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => function(){
        return \ahura\app\mw_options::get_product_item_style() == 1;
    },
]));
$this->customizer->add_setting('shop_show_filters_button_toggle', ['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'shop_show_filters_button_toggle', [
    'label' => __('Show Filters Button Toggle in Sidebar', 'ahura'),
    'section' => $this->current_section,
    'description' => __('For toggle the sidebar in mobile','ahura'),
]));
$this->customizer->add_setting('filters_button_toggle_text', ['default' => esc_html__('Products filter', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer, 'filters_button_toggle_text', [
    'label' => __('Filters Button Toggle Text', 'ahura'),
    'section' => $this->current_section,
    'active_callback' => ['\ahura\app\mw_options','get_mod_shop_show_filters_button_toggle'],
]));

$this->customizer->add_setting('ahura_shop_filters_toggle_button_color', ['default' => '#181522']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_shop_filters_toggle_button_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_shop_filters_toggle_button_color',
        'label' => __( 'Filters button color', 'ahura' ),
        'active_callback' => ['\ahura\app\mw_options','get_mod_shop_show_filters_button_toggle'],
    ))
);

$this->customizer->add_setting('ahura_shop_filters_toggle_button_bg_color', ['default' => '#fed700']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_shop_filters_toggle_button_bg_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_shop_filters_toggle_button_bg_color',
        'label' => __( 'Filters button background color', 'ahura' ),
        'active_callback' => ['\ahura\app\mw_options','get_mod_shop_show_filters_button_toggle'],
    ))
);

$this->customizer->add_setting('ahura_shop_orderby_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_status',[
    'section' => $this->current_section,
    'label'   => __( 'Customize shop orderby fields', 'ahura' ),
]));

$this->customizer->add_setting( 'ahura_shop_orderby_color', [ 'default' => '#555555' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer,'ahura_shop_orderby_color',[
    'section'         => $this->current_section,
    'setting'         => 'ahura_shop_orderby_color',
    'label'           => __( 'Orderby items color', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
] ) );

$this->customizer->add_setting( 'ahura_shop_orderby_backcolor', [ 'default' => '#f5f5f5' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer,'ahura_shop_orderby_backcolor',[
    'section'         => $this->current_section,
    'setting'         => 'ahura_shop_orderby_backcolor',
    'label'           => __( 'Orderby items background color', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
] ) );

$this->customizer->add_setting('ahura_shop_orderby_default_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_default_status',[
    'section' => $this->current_section,
    'label'   => __( 'Disable default field', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
]));

$this->customizer->add_setting('ahura_shop_orderby_popularity_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_popularity_status',[
    'section' => $this->current_section,
    'label'   => __( 'Disable popularity field', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
]));

$this->customizer->add_setting('ahura_shop_orderby_rating_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_rating_status',[
    'section' => $this->current_section,
    'label'   => __( 'Disable rating field', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
]));

$this->customizer->add_setting('ahura_shop_orderby_price_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_price_status',[
    'section' => $this->current_section,
    'label'   => __( 'Disable price field', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
]));

$this->customizer->add_setting('ahura_shop_orderby_pricedesc_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_orderby_pricedesc_status',[
    'section' => $this->current_section,
    'label'   => __( 'Disable price-desc field', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_ahura_shop_orderby_status' ],
]));