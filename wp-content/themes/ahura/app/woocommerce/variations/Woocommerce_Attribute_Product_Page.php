<?php
namespace ahura\app\woocommerce\variations;

use ahura\app\woocommerce\variations\Woocommerce_Attribute_Data;

class Woocommerce_Attribute_Product_Page {
    protected static $_instance = null;
    public $woo_attr_data;
    
    public function __construct() {
        $this->hooks();
    }
    
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    protected function hooks() {
        add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'dropdown' ), 20, 2 );
        add_action( 'wc_ajax_woo_get_all_variations', array( $this, 'get_all_variations' ) );
        add_filter( 'woocommerce_get_script_data', array( $this, 'add_to_cart_variation_params' ), 10, 2 );
        add_filter( 'woocommerce_ajax_variation_threshold', array( $this, 'ajax_variation_threshold' ) );
        add_filter( 'woocommerce_variable_children_args', array( $this, 'variable_children_args' ), 10, 3 );
        add_filter( 'woocommerce_variation_is_active', array( $this, 'disable_out_of_stock_item' ), 10, 2 );
        add_filter( 'woocommerce_available_variation', array( $this, 'add_variation_data' ), 10, 3 );
        
        add_filter('nocache_headers', array($this, 'cache_ajax_response'));
    }
    
    public function cache_ajax_response( $headers ) {
        global $wp_query;
        $action   = $wp_query->get( 'wc-ajax' ) ? sanitize_text_field( $wp_query->get( 'wc-ajax' ) ) : false;
        $requests = array( 'woo_get_variations', 'woo_get_all_variations' );
        if ( $action && in_array( $action, $requests ) ) {            
            $expires = HOUR_IN_SECONDS;
            $cache_control = sprintf('public, max-age=%d', $expires);
            
            $headers[ 'Pragma' ] = 'public';
            $headers[ 'Expires' ] = $expires;
            $headers[ 'Cache-Control' ] = $cache_control;
            $headers[ 'X-Variation-Swatches-Ajax-Header-Modified' ] = true;
        }
        
        return $headers;
    }
    
    public function add_variation_data( $variation_data, $product, $variation ) {
        
        $variation_data[ 'variation_permalink' ] = $variation->get_permalink();
                
        $variation_data[ 'variation_stock_left' ] = $variation->managing_stock() ? sprintf(esc_html__('%s left', 'ahura'), $variation->get_stock_quantity() ) : '';
        
        return $variation_data;
    }
    
    public function disable_out_of_stock_item($default, $variation) {
        if (!$variation->is_in_stock()) {
            return false;
        }
        
        return $default;
    }
    
    public function variable_children_args($all_args, $product, $visible_only) {
        if ( ! $visible_only ) {
            $all_args[ 'post_status' ] = 'publish';
        }
        
        return $all_args;
    }
    
    public function ajax_variation_threshold( $limit ) {
        return $limit;
    }
    
    public function get_variation_threshold_max($product) {
        return absint(apply_filters('ahura_product_variation_global_ajax_variation_threshold_max', 100, $product));
    }
    
    public function add_to_cart_variation_params( $params, $handle ) {
        if ('wc-add-to-cart-variation' === $handle ) {
            if ( is_product() ) {
                $product = wc_get_product();
                
                $params['ahura_product_variation_ajax_variation_threshold_min' ] = apply_filters('woocommerce_ajax_variation_threshold', 30, $product);
                $params['ahura_product_variation_ajax_variation_threshold_max' ] = $this->get_variation_threshold_max( $product );
                $params['ahura_product_variation_total_children' ] = count( $product->get_children() );
            }
        }
        
        return $params;
    }
    
    public function get_all_variations() {
        ob_start();
        
        if ( empty( $_POST[ 'product_id' ] ) ) {
            wp_die();
        }
        
        $product = wc_get_product( absint( $_POST[ 'product_id' ] ) );
        
        if ( ! $product ) {
            wp_die();
        }
        
        $available_variations = $product->get_available_variations();
        wp_send_json( $available_variations );
    }
    
    public function is_archive( $data ) {        
        return isset( $data[ 'is_archive' ] ) && wc_string_to_bool( $data[ 'is_archive' ] );
    }
    
    public function wrapper_class( $args, $attribute, $product, $attribute_type ) {
        $classes = array();
        
        $classes[] = 'variable-items-wrapper';
        $classes[] = sprintf( '%s-variable-items-wrapper', $attribute_type );
        
        return $classes;
    }
    
    public function wrapper_html_attribute( $args, $attribute, $product, $attribute_type, $options ) {
        
        $raw_html_attributes = array();
        $css_classes         = $this->wrapper_class( $args, $attribute, $product, $attribute_type );
        
        $raw_html_attributes[ 'role' ]                  = 'radiogroup';
        $raw_html_attributes[ 'aria-label' ]            = wc_attribute_label( $attribute, $product );
        $raw_html_attributes[ 'class' ]                 = implode( ' ', array_unique( array_values( $css_classes ) ) );
        $raw_html_attributes[ 'data-attribute_name' ]   = wc_variation_attribute_name( $attribute );
        $raw_html_attributes[ 'data-attribute_values' ] = wc_esc_json( wp_json_encode( array_values( $options ) ) );
        
        return $raw_html_attributes;
    }
    
    public function wrapper_start( $args, $attribute, $product, $attribute_type, $options ) {
        $html_attributes = $this->wrapper_html_attribute( $args, $attribute, $product, $attribute_type, $options );
        
        return sprintf( '<ul %s>', wc_implode_html_attributes( $html_attributes ) );
    }
    
    public function wrapper_end() {
        return '</ul>';
    }
    
    public function item_start( $data, $attribute_type, $variation_data = array() ) {
        $is_selected = $data[ 'is_selected' ];
        $option_name = $data[ 'option_name' ];
        $option_slug = $data[ 'option_slug' ];
        $slug = $data[ 'slug' ];
        
        $css_class = implode( ' ', array_unique( array_values( apply_filters( 'ahura_product_variation_item_css_class', $this->get_item_css_classes( $data ), $data ) ) ) );
        
        $html_attributes = array(
            'aria-checked' => ( $is_selected ? 'true' : 'false' ),
            'tabindex'     => ( wp_is_mobile() ? '2' : '0' ),
        );
        
        $html_attributes = wp_parse_args( $this->get_item_tooltip_attribute( $data ), $html_attributes );
        
        $html_attributes = apply_filters( 'ahura_product_variation_item_custom_attributes', $html_attributes, $attribute_type, $data );
        
        return sprintf( '<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-title="%5$s" data-value="%6$s" role="radio" tabindex="0"><div class="variable-item-contents">', wc_implode_html_attributes( $html_attributes ), esc_attr( $attribute_type ), esc_attr( $option_slug ), esc_attr( $css_class ), esc_html( $option_name ), esc_attr( $slug ) );
    }
    
    public function get_item_css_classes( $data ) {
        $css_classes = array();
        
        $is_selected = wc_string_to_bool( $data[ 'is_selected' ] );
        
        if ( $is_selected ) {
            $css_classes[] = 'selected';
        }
        
        return $css_classes;
    }
    
    public function get_item_tooltip_attribute( $data ) {
        $html_attributes = array();
        
        $option_name = $data[ 'option_name' ];
                
        $tooltip = trim( apply_filters( 'ahura_product_variation_global_variable_item_tooltip_text', $option_name, $data ) );
        
        $html_attributes[ 'data-tooltip' ] = esc_attr( $tooltip );
        
        return $html_attributes;
    }
    
    public function item_end() {
        $html = '';
        $html .= '<div class="stock-left-info" data-stock-info=""></div>';
        $html .= '</div></li>';
        
        return $html;
    }
    
    public function get_available_variation_image( $variation, $product ) {
        if ( is_numeric( $variation ) ) {
            $variation = wc_get_product( $variation );
        }
        if ( ! $variation instanceof WC_Product_Variation ) {
            return false;
        }
        
        $available_variation = array(
            'attributes'           => $variation->get_variation_attributes(),
            'image_id'             => $variation->get_image_id(),
            'is_in_stock'          => $variation->is_in_stock(),
            'is_purchasable'       => $variation->is_purchasable(),
            'variation_id'         => $variation->get_id(),
            'variation_image_id'   => $variation->get_image_id( 'edit' ),
            'product_id'           => $product->get_id(),
            'availability_html'    => wc_get_stock_html( $variation ),
            'price_html'           => '<span class="price">' . $variation->get_price_html() . '</span>',
            'variation_is_active'  => $variation->variation_is_active(),
            'variation_is_visible' => $variation->variation_is_visible(),
        );
        
        return apply_filters( 'ahura_product_variation_get_available_variation_image', $available_variation, $variation, $product );
    }
    
    public function get_variation_by_attribute_name_value( $available_variations, $attribute_name, $attribute_value ) {
        return array_reduce( $available_variations, function ( $item, $variation ) use ( $attribute_name, $attribute_value ) {
            
            if ( $variation[ 'attributes' ][ $attribute_name ] === $attribute_value ) {
                $item = $variation;
            }
            
            return $item;
        }, array());
    }
    
    public function get_variation_data_by_attribute_name( $available_variations, $attribute_name ) {
        $assigned       = array();
        $attribute_name = wc_variation_attribute_name( $attribute_name );
        
        foreach ( $available_variations as $variation ) {
            $attrs = $variation[ 'attributes' ];
            $value = $attrs[ $attribute_name ];
            
            if ( ! isset( $assigned[ $attribute_name ][ $value ] ) && ! empty( $value ) ) {
                $assigned[ $attribute_name ][ $value ] = array(
                    'image_id'     => $variation[ 'variation_image_id' ],
                    'variation_id' => $variation[ 'variation_id' ],
                    'type'         => empty( $variation[ 'variation_image_id' ] ) ? 'button' : 'image',
                );
            }
        }
        
        return $assigned;
    }
    
    public function color_attribute( $data, $attribute_type, $variation_data = array() ) {
        if ( 'color_var' === $attribute_type ) {
            
            $term = $data[ 'item' ];
            
            $color = sanitize_hex_color( Woocommerce_Attribute_Data::get_product_attribute_color( $term, $data ) );
            if($color){
                return sprintf( '<span class="variable-item-span variable-item-span-color" style="background-color:%s;"></span>', esc_attr( $color ) );
            }

            return false;
        }
    }
    
    public function get_swatch_data( $args, $term_or_option ) {
        
        $options   = $args[ 'options' ];
        $product   = $args[ 'product' ];
        $attribute = $args[ 'attribute' ];
        $is_term = is_object( $term_or_option );
        
        if ( $is_term ) {
            $term        = $term_or_option;
            $slug        = $term->slug;
            $is_selected = ( sanitize_title( $args[ 'selected' ] ) === $term->slug );
            $option_name = apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product );
            
        } else {
            $option      = $slug = $term_or_option;
            $is_selected = ( sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ) ? ( $args[ 'selected' ] === sanitize_title( $option ) ) : ( $args[ 'selected' ] === $option );
            $option_name = apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product );
        }
        
        return array(
            'is_archive'      => isset( $args[ 'is_archive' ] ) ? $args[ 'is_archive' ] : false,
            'is_selected'     => $is_selected,
            'is_term'         => $is_term,
            'term_id'         => $is_term ? $term->term_id : $option,
            'slug'            => $slug,
            'option_slug'     => $slug,
            'item'            => $term_or_option,
            'options'         => $options,
            'option_name'     => $option_name,
            'attribute'       => $attribute,
            'attribute_key'   => sanitize_title( $attribute ),
            'attribute_name'  => wc_variation_attribute_name( $attribute ),
            'attribute_label' => wc_attribute_label( $attribute, $product ),
            'args'            => $args,
            'product'         => $product,
        );
    }
    
    public function dropdown( $html, $args ) {
        $args = wp_parse_args( apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ), array(
            'options'          => false,
            'attribute'        => false,
            'product'          => false,
            'selected'         => false,
            'name'             => '',
            'id'               => '',
            'class'            => '',
            'show_option_none' => esc_html__( 'Choose an option', 'ahura' ),
            'is_archive'       => false
        ) );
        
        if(apply_filters('default_ahura_product_variation_single_product_dropdown_html', false, $args, $html, $this)) {
            return $html;
        }
        
        if (empty( $args[ 'selected' ] ) && $args[ 'attribute' ] && $args[ 'product' ] instanceof WC_Product) {
            $selected_key = wc_variation_attribute_name( $args[ 'attribute' ] );
            $args[ 'selected' ] = isset( $_REQUEST[ $selected_key ] ) ? $_REQUEST[ $selected_key ] : $args[ 'product' ]->get_variation_default_attribute( $args[ 'attribute' ] );
        }
        
        $options = $args[ 'options' ];
        $product = $args[ 'product' ];
        $attribute = $args[ 'attribute' ];
        $name = $args[ 'name' ] ? $args[ 'name' ] : wc_variation_attribute_name( $attribute );
        $id = $args[ 'id' ] ? $args[ 'id' ] : sanitize_title( $attribute );
        $class = $args[ 'class' ];
        $show_option_none = (bool) $args[ 'show_option_none' ];
        $show_option_none_text = $args[ 'show_option_none' ] ? $args[ 'show_option_none' ] : esc_html__( 'Choose an option', 'ahura' );
        
        if (empty( $options ) && ! empty( $product ) && ! empty($attribute)) {
            $attributes = $product->get_variation_attributes();
            $options = $attributes[ $attribute ];
        }
        
        $get_attribute = Woocommerce_Attribute_Data::get_attribute_taxonomy_by_name( $attribute );
        $attribute_types = array_keys(Woocommerce_Attribute_Data::attribute_types());
        $attribute_type = ( $get_attribute ) ? $get_attribute->attribute_type : 'select';
        $swatches_data = array();
		$is_select = in_array($attribute_type, ['default', 'select']);
        
        if (!in_array($attribute_type, $attribute_types)) {
            return $html;
        }
        
        $select_inline_style = '';
        
        if ( $is_select ) {
            $attribute_type = 'button';
        }
        
        if ( !$is_select ) {
            $select_inline_style = 'style="display:none"';
            $class               .= ' woo-variation-raw-select';
        }
        
        $html = '<select ' . $select_inline_style . ' id="' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '" name="' . esc_attr( $name ) . '" data-attribute_name="' . esc_attr( wc_variation_attribute_name( $attribute ) ) . '" data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '">';
        $html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';
        
        
        if ( ! empty( $options ) ) {
            if ( $product && taxonomy_exists( $attribute ) ) {
                // Get terms if this is a taxonomy - ordered. We need the names too.
                $terms = wc_get_product_terms( $product->get_id(), $attribute, array(
                    'fields' => 'all',
                ) );
                
                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options, true ) ) {
                        
                        $swatches_data[] = $this->get_swatch_data( $args, $term );
                        
                        $html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args[ 'selected' ] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';
                    }
                }
            } else {
                foreach ( $options as $option ) {
                    // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
                    $selected = sanitize_title( $args[ 'selected' ] ) === $args[ 'selected' ] ? selected( $args[ 'selected' ], sanitize_title( $option ), false ) : selected( $args[ 'selected' ], $option, false );
                    
                    $swatches_data[] = $this->get_swatch_data( $args, $option );
                    
                    $html .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
                }
            }
        }
        
        $html .= '</select>';
        
        if ( $is_select ) {
            return $html;
        }
                
        $item        = '';
        $wrapper     = '';
        $wrapper_end = '';
        
        if ( ! empty( $options ) && ! empty( $swatches_data ) && $product ) {
            
            $wrapper = $this->wrapper_start( $args, $attribute, $product, $attribute_type, $options );
            
            foreach ( $swatches_data as $data ) {
                $item .= $this->item_start( $data, $attribute_type );
                $item .= $this->color_attribute( $data, $attribute_type );
                $item .= $this->item_end();
            }
            
            $wrapper_end = $this->wrapper_end();
            
        }
        
        $html .= $wrapper . $item . $wrapper_end;
        
        return apply_filters('ahura_product_variations_html', $html, $args, $swatches_data, $this );
    }
}
