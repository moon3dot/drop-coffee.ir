<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $related_element_tag;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$loop_style = \ahura\app\mw_options::get_product_item_style();

$in_slider = \ahura\app\woocommerce::is_active() && is_product() ? \ahura\app\mw_options::get_mod_is_active_product_related_in_slider() : false;

$cls = ['mw_product_item'];

if($in_slider){
    $cls[] = 'swiper-slide';
}

$cls[] = 'product-style-' . (empty($loop_style) ? 1 : $loop_style);
?>
<li <?php wc_product_class( $cls, $product ); ?>>

    <?php
    do_action( 'woocommerce_before_shop_loop_item' );
    do_action( 'woocommerce_before_shop_loop_item_title' );
    do_action('woocommerce_shop_loop_item_title');

    do_action( 'woocommerce_after_shop_loop_item_title' );
    ?>

    <div class="woo-shop-product-after-loop-item"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
</li>
