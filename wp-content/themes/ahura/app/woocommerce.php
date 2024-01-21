<?php
namespace ahura\app;

use ahura\app\mw_assets;
class woocommerce
{
    static function is_active()
    {
        return class_exists('WooCommerce');
    }
    static function is_woocommerce()
    {
        return self::is_active() && is_woocommerce();
    }

    static function is_product()
    {
        return self::is_active() && is_product();
    }

    static function is_shop()
    {
        return self::is_active() && is_shop();
    }
    static function is_woocommerce_page()
    {
        return self::is_active() && (is_woocommerce() || is_cart() || is_checkout() || is_account_page());
    }
    static function before_shop_loop_item()
    {
        $product_style = mw_options::get_product_item_style();
        if(empty($product_style) || $product_style == 1){
            $terms = wp_get_post_terms(get_the_ID(), 'product_cat', ['fields' => 'names', 'number' => 5]);
            $term_data = '<span class="mw_term_data">';
            foreach ($terms as $term_name) {
                $term_data .= '<span class="mw_term_item">'.$term_name.'</span>';
            }
            $term_data .= '</span>';
            echo '<span class="mw_overly"></span>';
            echo $term_data;
        }
    }
    static function show_product_stock_status()
    {
        global $product;
        echo get_theme_mod('ahura_shop_show_product_stock_status') ? wc_get_stock_html( $product ) : '';
    }
    static function loop_shop_columns()
    {
        return 3;
    }

    /**
     * Handle: mw_woocommerce
     *
     * @return void
     */
    public static function enqueue_woocommerce_js(){
        $version = \ahura\app\mw_tools::get_theme_version();
        $woocommerce_js = get_template_directory_uri() . '/js/woocommerce.js';
        wp_enqueue_script('mw_woocommerce', $woocommerce_js, ['jquery'], $version, true);
    }

    static function load_assets()
    {
        $version = \ahura\app\mw_tools::get_theme_version();

        if(self::is_active()){
            // woocommerce.css
            wp_enqueue_style('mw_woocommerce', get_template_directory_uri() . '/css/woocommerce.css', null, $version);

            if(!is_rtl()){
                wp_enqueue_style('mw_woocommerce_ltr', get_template_directory_uri() . '/css/woocommerce_ltr.css', null, $version);
            }

            mw_assets::enqueue_script('woocommerce_variations', mw_assets::get_js('woocommerce_variations'));

            self::enqueue_woocommerce_js();

            if(self::is_woocommerce_page() || is_shop())
            {
                if(is_cart() || is_checkout())
                {
                    $btn_style = '.woocommerce .button.alt{ background-color: var(--mw_primary_color); color: #222; }';
                    wp_add_inline_style('style', $btn_style);
                }
            }
        }
    }
    static function woocommerce_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key){
        $cart_image_id = $cart_item['data']->get_image_id();
        $image = wp_get_attachment_image($cart_image_id, 'thumbnail');
        return $image;
    }
    static function related_products_args($args)
    {
        $args['posts_per_page'] = 3;
        $args['columns'] = 3;
        return $args;
    }
    static function change_shop_item_count_per_page( $cols ) {
        // $cols contains the current number of products per page based on the value stored on Options –> Reading
        // Return the number of products you wanna show per page.
        $cols = get_theme_mod('ahura_shop_per_page', 9);
        return $cols;
    }
    static function change_sale_text($text){
        $text = get_theme_mod('woocommerce_sale_text') ? get_theme_mod('woocommerce_sale_text') : __('Sale!','woocommerce');
        $product_discount_percent = get_theme_mod('ahura_shop_show_product_onsale_percent') ? product_discount_percent().' ' : '';
        $text = '<span class="onsale">' . Number::numByLang($product_discount_percent . $text) . '</span>';
        return $text;
    }

    public static function add_to_cart_button_with_quantity($params = []){
        global $product;
        if(isset($params['product']) && is_object($params['product'])){
            $product = $params['product'];
        }
        if(is_object($product)){
            echo '<form action="' . esc_url($product->add_to_cart_url()) . '" class="d-flex align-center cart product-quantity-form crousel_addtobtn '. (isset($params['class']) ? $params['class'] : '') .'" method="post" enctype="multipart/form-data">';

            if(!isset($params['with_qty']) || isset($params['with_qty']) && $params['with_qty'] === true){
                echo woocommerce_quantity_input(['min_value' => 1, 'max_value' => (!$product->backorders_allowed() ? $product->get_stock_quantity() : '')]);
            }

            $btn_text = __('Add to Cart', 'ahura');
            if(isset($params['button_text'])){
                $btn_text = $params['button_text'];
            }

            $btn_icon = '';
            if(isset($params['has_button_icon']) && $params['has_button_icon'] === true){
                $btn_icon = '<i class="fa fa-shopping-cart"></i>';
                if(isset($params['button_icon'])){
                    $btn_icon = $params['button_icon'];
                }
            }

            echo '<button type="submit" class="button alt">'. $btn_icon . ' ' . $btn_text .'</button>';
            echo '</form>';
        }
    }

    public static function added_inquiry_text_for_without_products($price, $product){
        if('' === $product->get_price()) {
            $text = \ahura\app\mw_options::get_mod_text_call_for_price_inquery();
            $text = !empty($text) ? $text : esc_html__('Call for price inquiry', 'ahura');
            $btn_text = \ahura\app\mw_options::get_mod_call_for_price_inquery_button_text();
            $btn_url = \ahura\app\mw_options::get_mod_call_for_price_inquery_button_url();
            $output = "<div class='price_on_inquiry'><span>{$text}</span>";
            if(!empty($btn_url) && is_single()){
                $output .= "<a href='{$btn_url}' class='button'>{$btn_text}</a>";
            }
            $output .= "</div>";
            return $output;
        }
    
        return $price;
    }

    public static function change_single_product_add_to_cart_button_text(){
        $status = \ahura\app\mw_options::get_mod_change_add_to_cart_button_text_status();
        $text = \ahura\app\mw_options::get_mod_add_to_cart_button_text();
        if($status && !empty($text)){
            return $text;
        }
        return __('Add to Cart', 'ahura'); 
    }

    public static function before_shop_add_to_cart_button($product){
        $colors = get_the_terms($product->get_id(), 'pa_color');
        $is_pages = is_woocommerce() && !is_single();
        if (!empty($colors) && !is_wp_error($colors) && $is_pages && \ahura\app\mw_options::get_product_item_style() == 2){?>
            <div class="product-colors">
                <?php foreach ($colors as $color) {
                    $term_id = is_object($color) ? $color->term_id : (isset($color['term_id']) ? $color['term_id'] : null);
                    if (!$term_id) continue;
                    $data = get_term_meta($term_id);
                    $color_code = isset($data['_product_attribute_color'][0]) && !empty($data['_product_attribute_color'][0]) ? $data['_product_attribute_color'][0] : null;
                    if (!$color_code) continue;
                    ?>
                    <span class="product-color-item" title="<?php echo isset($color->name) ? $color->name : '' ?>" style="background-color:<?php echo $color_code ?>"></span>
                <?php } ?>
            </div>
        <?php }
    }

    public static function handle_add_quick_view_button_before_shop_add_to_cart($product)
    {
        ?>
        <a href="#" class="product-preview-btn" data-id="<?php echo $product->get_id() ?>" title="<?php _e('Quick View', 'ahura') ?>">
            <?php echo apply_filters('ahura_product_quick_view_button_text', '<i class="fas fa-eye"></i>') ?>
        </a>
    <?php
    }

    public static function handle_move_out_of_stock_products_to_end($posts_clauses)
    {
        if (woocommerce::is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
            global $wpdb;
            $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
            $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
            $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
        }
        return $posts_clauses;
    }
}
