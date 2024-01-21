<?php
namespace ahura\app;

class WC_Quick_View {
    public static function init(){
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_title', 5);
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_rating', 10);
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_price', 15);
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_excerpt', 20);
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_add_to_cart', 25);
        add_action('ahura_product_quick_view_summary', 'woocommerce_template_single_meta', 30);

        add_action('wp_footer', [__CLASS__, 'enqueue_depend']);
    }

    public static function enqueue_depend(){
        wp_enqueue_script('wc-add-to-cart-variation');
    }

    public static function render_template($data = []){
        if (!empty($data)){
            extract($data);
        }

        $product_id = $product->get_id();

        $post_thumbnail_id = $product->get_image_id();
        $attachment_ids = $product->get_gallery_image_ids();


        include get_template_directory() . '/template-parts/loop/product-quick-view-template.php';
    }
}