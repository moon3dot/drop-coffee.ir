<?php
namespace ahura\app\woocommerce\variations;
    
class Woocommerce_Attribute_Data {
    public static function get_product_attribute_color( $term, $data = array() ) {
        
        $term_id = 0;
        if ( is_numeric( $term ) ) {
            $term_id = $term;
        }
        
        if ( is_object( $term ) ) {
            $term_id = $term->term_id;
        }
        
        return get_term_meta( $term_id, '_product_attribute_color', true );
    }

    public static function get_attribute_taxonomy_by_name( $attribute_name ) {
        if ( ! taxonomy_exists( $attribute_name ) ) {
            return false;
        }
        
        if ( 'pa_' === substr( $attribute_name, 0, 3 ) ) {
            $attribute_name = str_replace( 'pa_', '', wc_sanitize_taxonomy_name( $attribute_name ) );
        } else {
            return false;
        }
        
        global $wpdb;
        $attribute_taxonomy = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name='{$attribute_name}'" );
        
        return apply_filters('ahura_product_variation_get_wc_attribute_taxonomy', $attribute_taxonomy, $attribute_name );
    }

    public static function attribute_types() {
        return array(
            'default'  => esc_html__('Default', 'ahura'),
            'color_var'  => esc_html__('Color - Ahura', 'ahura'),
        );
    }
}