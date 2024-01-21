<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use ahura\app\mw_options;
use ahura\app\customization\ios_checkbox;
use ahura\app\customization\simple_text;
use ahura\app\customization\simple_select_box;
use ahura\app\customization\multiple_checkbox_control;

$this->customizer->add_setting('ahura_single_product_loop_style', ['default' => 'default']);
$this->customizer->add_control(new simple_select_box($this->customizer, 'ahura_single_product_loop_style', [
    'section' => $this->current_section,
    'label' => __('Single product Style', 'ahura'),
    'choices' => [
        'default' => __('Woocommerce Default', 'ahura'),
        'digikala' => __('Style 1', 'ahura'),
    ],
]));

$this->customizer->add_setting('show_single_product_breadcrumb');
$this->customizer->add_control(new ios_checkbox($this->customizer, 'show_single_product_breadcrumb', [
    'label' => __('Show single product breadcrumb', 'ahura'),
    'section' => $this->current_section
]));

$this->customizer->add_setting('ahura_sticky_addtocart_status',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_sticky_addtocart_status',array(
    'section' => $this->current_section,
    'label' => __( 'Show sticky add to cart on phone', 'ahura' ),
)));

$this->customizer->add_setting('shop_change_add_to_cart_button_text_status', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'shop_change_add_to_cart_button_text_status',[
    'section' => $this->current_section,
    'label'   => __( 'Change add to cart button text', 'ahura' ),
]));

$this->customizer->add_setting('shop_add_to_cart_button_text', ['default' => esc_html__('Add to Cart', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer,'shop_add_to_cart_button_text',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Add to cart button text', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_change_add_to_cart_button_text_status'],
)));

$this->customizer->add_setting('ahura_product_buy_button_text_color', ['default' => '#ffffff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_product_buy_button_text_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_product_buy_button_text_color',
        'label' => __( 'Add to cart button color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_product_buy_button_bg_color', ['default' => '#00b0ff']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_product_buy_button_bg_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_product_buy_button_bg_color',
        'label' => __( 'Add to cart button background color', 'ahura' ),
    ))
);

$this->customizer->add_setting('ahura_shop_show_product_thumbnails_in_slider',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_thumbnails_in_slider',array(
    'section' => $this->current_section,
    'label' => __( 'Show product gallery in slider', 'ahura' ),
)));

$this->customizer->add_setting('ahura_shop_show_product_slider_buttons',['default' => true]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_slider_buttons',array(
    'section' => $this->current_section,
    'label' => __('Show product gallery slider buttons', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_product_thumbnails_in_slider'],
)));

$this->customizer->add_setting('ahura_move_price_after_short_description', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_move_price_after_short_description',array(
    'section' => $this->current_section,
    'label' => __('Move price after short description', 'ahura'),
    'active_callback' => function(){
        return mw_options::get_single_product_style() != 'digikala';
    },
)));

$places_options = [
    'telegram' 	    => __( 'Telegram', 'ahura' ),
    'whatsapp' 	    => __( 'WhatsApp', 'ahura' ),
    'facebook'      => __( 'Facebook', 'ahura' ),
    'twitter' 	    => __( 'Twitter', 'ahura' ),
    'linkedin' 	    => __( 'Linkedin', 'ahura' ),
];
$this->customizer->add_setting( 'ahura_product_page_digikala_sharings', [ 'default'   => ['all' ] ] );
$this->customizer->add_control( new multiple_checkbox_control( $this->customizer, 'ahura_product_page_digikala_sharings', array(
    'label'    => __( 'Select sharing buttons', 'ahura' ),
    'section'  => $this->current_section,
    'choices'  => $places_options,
    'active_callback' => function(){
        return mw_options::get_single_product_style() == 'digikala';
    },
)));

$this->customizer->add_setting('ahura_product_page_digikala_attributes', ['default' => 3]);
$this->customizer->add_control(new simple_text($this->customizer, 'ahura_product_page_digikala_attributes', array(
    'label' => __('How many attributes need to show at first', 'ahura'),
    'section' => $this->current_section,
    'type'  =>  'number',
    'active_callback' => function(){
        return mw_options::get_single_product_style() == 'digikala';
    },
)));

$this->customizer->add_setting('ahura_shop_show_product_related',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_related',array(
    'section' => $this->current_section,
    'label' => __( 'Show product related', 'ahura' ),
)));

$this->customizer->add_setting('ahura_shop_show_product_related_in_slider',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_product_related_in_slider',array(
    'section' => $this->current_section,
    'label' => __( 'Show product related in slider', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_is_active_product_related' ],
)));

$this->customizer->add_setting('ahura_shop_show_related_product_slider_btns',['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_related_product_slider_btns',array(
    'section' => $this->current_section,
    'label' => __('Show related product slider buttons', 'ahura'),
    'active_callback' => ['\ahura\app\mw_options', 'get_mod_is_active_product_related_in_slider'],
)));

$this->customizer->add_setting( 'ahura_related_product_column', ['default' => '3'] );
$this->customizer->add_control( 'ahura_related_product_column', [
    'type'    => 'select',
    'section' => $this->current_section,
    'label'   => __( 'Related products column', 'ahura' ),
    'choices' => [
        '2' => __( '2', 'ahura' ),
        '3' => __( '3', 'ahura' ),
        '4' => __( '4', 'ahura' ),
    ],
    'active_callback' => [ '\ahura\app\mw_options','get_mod_is_active_product_related' ],
] );

$this->customizer->add_setting( 'ahura_related_product_column_mobile', ['default' => 1] );
$this->customizer->add_control( 'ahura_related_product_column_mobile', [
    'type'    => 'select',
    'section' => $this->current_section,
    'label'   => __( 'Related products column in mobile', 'ahura' ),
    'choices' => [
        '1' => __( '1', 'ahura' ),
        '2' => __( '2', 'ahura' ),
        '3' => __( '3', 'ahura' ),
        '4' => __( '4', 'ahura' ),
    ],
    'active_callback' => [ '\ahura\app\mw_options','get_mod_is_active_product_related' ],
] );

$this->customizer->add_setting( 'ahura_max_related_products_num',[ 'default' => '3' ] );
$this->customizer->add_control( new simple_text( $this->customizer,'ahura_max_related_products_num', [
    'section' => $this->current_section,
    'type'    => 'number',
    'label'   => __( 'Maximum related products', 'ahura' ),
    'active_callback' => [ '\ahura\app\mw_options','get_mod_is_active_product_related' ],
] ) );

$this->customizer->add_setting('ahura_shop_show_call_for_price_inquery', ['default' => false]);
$this->customizer->add_control(new ios_checkbox($this->customizer, 'ahura_shop_show_call_for_price_inquery',array(
    'section' => $this->current_section,
    'label' => __('Show text call for price inquery', 'ahura'),
    'description' => __('Displayed text only for products without price', 'ahura'),
)));

$this->customizer->add_setting('ahura_shop_text_call_for_price_inquery', ['default' => esc_html__('Call for price inquiry', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer,'ahura_shop_text_call_for_price_inquery',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Text call for price inquery', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_call_for_price_inquery'],
)));

$this->customizer->add_setting('ahura_shop_btn_text_call_for_price_inquery', ['default' => esc_html__('Contact us', 'ahura')]);
$this->customizer->add_control(new simple_text($this->customizer,'ahura_shop_btn_text_call_for_price_inquery',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Call button text', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_call_for_price_inquery'],
)));

$this->customizer->add_setting('ahura_shop_btn_url_call_for_price_inquery', ['default' => 'tel:+989123456789']);
$this->customizer->add_control(new simple_text($this->customizer,'ahura_shop_btn_url_call_for_price_inquery',array(
    'section' => $this->current_section,
    'type' => 'url',
    'label' => __('Call button url', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_show_call_for_price_inquery'],
)));

$this->customizer->add_setting('ahura_shop_text_call_for_price_inquery_color', ['default' => '#5CE1B3']);
$this->customizer->add_control(
    new WP_Customize_Color_Control($this->customizer,'ahura_shop_text_call_for_price_inquery_color',array(
        'section' => $this->current_section,
        'setting' => 'ahura_shop_text_call_for_price_inquery_color',
        'label' => __( 'Inquery Text Color', 'ahura' ),
        'active_callback' => ['\ahura\app\mw_options','get_mod_show_call_for_price_inquery'],
    ))
);

$this->customizer->add_setting( 'ahura_woo_modified_date', [ 'default' => false ] );
$this->customizer->add_control( new ios_checkbox( $this->customizer, 'ahura_woo_modified_date', [
    'label' => __( 'Show Woocommerce product modified date', 'ahura' ),
    'section' => $this->current_section
]));

$this->customizer->add_setting( 'ahura_woo_modified_title_date_color',[ 'default' => '#181522' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer,'ahura_woo_modified_title_date_color', [
    'section' => $this->current_section,
    'setting' => 'ahura_woo_modified_title_date_color',
    'label'   => __( 'Product modified title date color', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_woo_modified_date'],
] ) );

$this->customizer->add_setting( 'ahura_woo_modified_date_color',[ 'default' => '#181522' ] );
$this->customizer->add_control( new WP_Customize_Color_Control( $this->customizer,'ahura_woo_modified_date_color', [
    'section' => $this->current_section,
    'setting' => 'ahura_woo_modified_date_color',
    'label'   => __( 'Product modified date color', 'ahura' ),
    'active_callback' => ['\ahura\app\mw_options','get_mod_is_active_woo_modified_date'],
] ) );

$this->customizer->add_setting( 'product_update_date_text',[ 'default' => esc_html__('Product updated in:', 'ahura')] );
$this->customizer->add_control( new simple_text( $this->customizer, 'product_update_date_text', [
    'label' => __( 'Product update date text', 'ahura' ),
    'section' => $this->current_section,
    'active_callback' => [ '\ahura\app\mw_options', 'get_mod_is_active_woo_modified_date' ],
] ) );

$this->customizer->add_setting('shop_upsells_box_title');
$this->customizer->add_control(new simple_text($this->customizer,'shop_upsells_box_title',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Up Sells Box Title', 'ahura' ),
)));

$this->customizer->add_setting('shop_cross_sells_box_title');
$this->customizer->add_control(new simple_text($this->customizer,'shop_cross_sells_box_title',array(
    'section' => $this->current_section,
    'type' => 'text',
    'label' => __('Cross Sells Box Title', 'ahura' ),
)));