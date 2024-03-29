<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

do_action('wc_before_add_to_cart_button', $product);

$status = \ahura\app\mw_options::get_mod_change_products_add_to_cart_button_text_status();
$text = \ahura\app\mw_options::get_mod_products_add_to_cart_button_text();

$btn_icon = ($status) ? '' : '<span class="fa fa-cart-plus"></span>';
$btn_title = ($status) ? sprintf('<span>%s</span>', $text) : '<span>'.__('Buy', 'ahura').'</span>';

$btn = is_rtl() ? $btn_icon . $btn_title : $btn_title . $btn_icon;
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<a href="%s" data-quantity="%s" class="mw_add_to_cart %s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        $btn
	),
$product, $args );
