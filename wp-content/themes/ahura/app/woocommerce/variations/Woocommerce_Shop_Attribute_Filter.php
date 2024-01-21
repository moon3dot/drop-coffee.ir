<?php
namespace ahura\app\woocommerce\variations;

class Woocommerce_Shop_Attribute_Filter{
    protected static $_instance = null;
    
    public function __construct() {
        add_filter('woocommerce_layered_nav_term_html', [$this, 'layered_nav_term_html'], 10, 4);
    }
    
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    public function layered_nav_term_html($term_html, $term, $link, $count){
        $taxonomy = Woocommerce_Attribute_Data::get_attribute_taxonomy_by_name($term->taxonomy);
        
        if($taxonomy){
            if($taxonomy->attribute_type == 'color_var'){
                $color_code = sanitize_hex_color(Woocommerce_Attribute_Data::get_product_attribute_color($term));
                if($color_code){
                    $html = "<a href='{$link}' data-count='{$count}' title='{$term->name}' class='woo-attribute-filters-color-variation' style='background-color:{$color_code}'></a>";
                    $html .= "<em class='woo-attribute-name'>{$term->name}</em>";
                    $html .= "<span class='woo-attribute-count'>{$count}</span>";
                    return $html;
                }
            }
        }

        return $term_html;
    }
}