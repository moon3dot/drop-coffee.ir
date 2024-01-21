<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$thumb_id = $product->get_image_id();

$attachment_ids = $product->get_gallery_image_ids();

$in_slider = \ahura\app\mw_options::get_mod_show_product_thumbnails_in_slider();

if ( $attachment_ids && $thumb_id ) {
    if($in_slider){ 
        array_unshift($attachment_ids, (int) $thumb_id);
        ?>
    <div class="swiper product-gallery-thumbs-slider">
        <div class="swiper-wrapper">
            <?php 
            foreach ( $attachment_ids as $attachment_id ):
                $src = wp_get_attachment_url($attachment_id);
                $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                if(empty($src)) continue;
            ?>
            <div class="swiper-slide">
                <img onload="this.width = this.naturalWidth; this.height = this.naturalHeight" src="<?php echo $src ?>" alt="<?php echo $alt ?>" draggable="false" width="100" height="100">
            </div>
            <?php endforeach; ?>
        </div>
        <?php if(\ahura\app\mw_options::get_mod_show_product_slider_buttons()): ?>
        <div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
        <?php endif;?>
    </div>
 <?php   
    } else {
        foreach ( $attachment_ids as $attachment_id ) {
            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', wc_get_gallery_image_html( $attachment_id ), $attachment_id );
        }
    }
}
