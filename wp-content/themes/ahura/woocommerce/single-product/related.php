<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$in_slider = \ahura\app\woocommerce::is_active() && is_product() ? \ahura\app\mw_options::get_mod_is_active_product_related_in_slider() : false;
$show_slider_btns = get_theme_mod('ahura_shop_show_related_product_slider_btns');
?>
<?php if(\ahura\app\mw_options::get_mod_is_active_product_related()) :?>
    <?php
    if ( $related_products ) : ?>
        <section class="related products<?php echo $in_slider ? ' related-slider' : '' ?><?php echo !$show_slider_btns ? ' related-slider-without-btn' : '' ?>">
            <?php
            $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );
            if ( $heading ) :?>
                <h2><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <?php 
			if($in_slider):
			?>
            <div dir="rtl" class="product-related-slider">
                <ul class="products owl-carousel owl-theme">
                    <?php else: ?>
                        <?php woocommerce_product_loop_start(); ?>
                    <?php endif; ?>
						<?php foreach ( $related_products as $related_product ) : ?>
							<?php
							$post_object = get_post( $related_product->get_id() );

							setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

							wc_get_template_part( 'content', 'product' );
							?>

						<?php endforeach; ?>
                    <?php if($in_slider): ?>
                </ul>
            </div>
            <script>
                jQuery(document).ready(function($){
                    ahuraHandleRelatedProductsSlider({
                        showNav: <?php echo $show_slider_btns ? 'true' : 'false' ?>,
                        mobileItems: <?php echo get_theme_mod('ahura_related_product_column_mobile') ? get_theme_mod('ahura_related_product_column_mobile') : 1 ?>,
                        desktopItems: <?php echo get_theme_mod('ahura_related_product_column') ? get_theme_mod('ahura_related_product_column') : 3 ?>
                    });
                });
            </script>
            <?php else: ?>
            <?php woocommerce_product_loop_end(); ?>
            <?php endif; ?>
        </section>
    <?php
    endif;
    wp_reset_postdata();
    ?>
<?php endif; ?>