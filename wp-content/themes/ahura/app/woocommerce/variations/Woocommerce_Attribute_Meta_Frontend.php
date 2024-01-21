<?php
namespace ahura\app\woocommerce\variations;

class Woocommerce_Attribute_Meta_Frontend {
    protected static $_instance = null;
    
    protected function __construct() {
        $this->get_product_page();
    }
    
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }

    public function get_product_page() {
        return \ahura\app\woocommerce\variations\Woocommerce_Attribute_Product_Page::instance();
    }

    public function is_color_attribute( $attribute ) {
        if ( ! is_object( $attribute ) ) {
            return false;
        }
        
        return $attribute->attribute_type == 'color_var';
    }
    
    public function is_button_attribute( $attribute ) {
        if ( ! is_object( $attribute ) ) {
            return false;
        }
        
        return $attribute->attribute_type == 'button';
    }
    
    public function get_product_children( $product ) {
        
        $variation_ids        = $product->get_children();
        $available_variations = array();
        
        if ( is_callable( '_prime_post_caches' ) ) {
            _prime_post_caches( $variation_ids );
        }
        
        foreach ( $variation_ids as $variation_id ) {
            
            $variation = wc_get_product( $variation_id );
            
            if ( ! $variation || ! $variation->exists() ) {
                continue;
            }
            
            if ( apply_filters( 'woocommerce_hide_invisible_variations', true, $product->get_id(), $variation ) && ! $variation->variation_is_visible() ) {
                continue;
            }
            
            $available_variations[] = $product->get_id();
        }
        
        return array_values( $available_variations );
        
    }
    
    public function get_product_variations( $product ) {
        
        
        $variation_ids        = $product->get_children();
        $available_variations = array();
        
        if ( is_callable( '_prime_post_caches' ) ) {
            _prime_post_caches( $variation_ids );
        }
        
        foreach ( $variation_ids as $variation_id ) {
            
            $variation = wc_get_product( $variation_id );
            
            if ( ! $variation || ! $variation->exists() ) {
                continue;
            }
            
            if ( apply_filters( 'woocommerce_hide_invisible_variations', true, $product->get_id(), $variation ) && ! $variation->variation_is_visible() ) {
                continue;
            }
            
            $available_variations[] = $variation;
            
        }
        
        return array_values( $available_variations );
    }
    
    public function get_product_attachment_props( $attachment_id = null, $product = false ) {
        $props      = array(
            'alt'    => '',
            'src'    => '',
            'srcset' => false,
        
        );
        $attachment = get_post($attachment_id);
        
        if ($attachment && 'attachment' === $attachment->post_type) {
            $props[ 'alt' ] = wp_strip_all_tags(get_the_title($product->get_id()));
                                
            $image_size = apply_filters('woocommerce_thumbnail_size', 'woocommerce_thumbnail');
            $src = wp_get_attachment_image_src( $attachment_id, $image_size );
            $props[ 'src' ] = $src[0];
            $props[ 'srcset' ] = false;
        }
        
        return $props;
    }
    
    public function get_variation_data() {
        ob_start();
        if ( empty( $_POST[ 'product_id' ] ) ) {
            wp_die();
        }
        
        $variation = wc_get_product( absint( $_POST[ 'product_id' ] ) );
        
        if ( ! $variation ) {
            wp_die();
        }
        
        $variation_data = array(
            'id'                => $variation->get_id(),
            'is_purchasable'    => $variation->is_purchasable(),
            'is_active'         => $variation->variation_is_active(),
            'in_stock'          => $variation->is_in_stock(),
            'max_qty'           => 0 < $variation->get_max_purchase_quantity() ? $variation->get_max_purchase_quantity() : '',
            'min_qty'           => $variation->get_min_purchase_quantity(),
            'price_html'        => $variation->get_price_html(),
            'availability_html' => wc_get_stock_html( $variation ),
            'image'             => $this->get_product_attachment_props( $variation->get_image_id(), $variation ),
        );
        
        wp_send_json($variation_data);
    }
}