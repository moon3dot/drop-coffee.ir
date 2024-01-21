<?php
namespace ahura\app;
class mini_cart
{
    public static function load_mini_cart_content($use_theme_locate){
        if($use_theme_locate){
            include get_template_directory() . '/woocommerce/cart/mini-cart.php';
        } else {
            woocommerce_mini_cart();
        }
    }
    static function init_mini_cart($btn_icon='fa fa-shopping-bag', $use_theme_locate = false)
    {
        $mini_cart_linked = \ahura\app\mw_options::mini_cart_hide_content();
        if(!woocommerce::is_active()) {
            return false;
        }
        ?>
            <div class="mini-cart-header">
                <?php
                $btn_icon = empty($btn_icon) ? 'fa fa-shopping-bag' : (is_array($btn_icon) && isset($btn_icon['url']) ? $btn_icon['url'] : $btn_icon);
                echo self::get_mini_cart_btn($btn_icon);
                if(!$mini_cart_linked){
                    self::load_mini_cart_content($use_theme_locate);
                }
                ?>
            </div>
        <?php
        // load mini cart assets
        if(!$mini_cart_linked){
            \ahura\app\mw_assets::load_woocommerce_mini_cart();
        }
    }
    static function get_mini_cart_btn_html($mode)
    {
        $method = 'get_btn_mode_header_' . $mode;
        if(!method_exists(__CLASS__, $method)) {
            return false;
        }
        $items_count = self::get_items_count();
        return self::{$method}($items_count);
    }
    static function get_items_count()
    {
        $cart = WC()->cart;
        if(!$cart)
        {
            wc_load_cart();
            $cart = WC()->cart;
        }
        return $cart->get_cart_contents_count();
    }
    static function get_btn_mode_header_1($items_count)
    {
        return '<a id="mcart-stotal" cart-mode="1" href="#">'.__( 'Cart', 'ahura' ).' - '.$items_count.' '.__( 'Item', 'ahura' ).'</a>';
    }
    static function get_btn_mode_header_3($items_count)
    {
        $is_active_count = get_theme_mod('ahura_show_mini_cart_count') ? ' cart-icon-count' : '';
        return '<a href="'.wc_get_cart_url().'" cart-mode="3" cart-count="'.$items_count.'" id="mcart-stotal" class="cart-icon'.$is_active_count.'"><i class="fa fa-shopping-bag"></i></a>';
    }
    static function get_mini_cart_btn($btn_icon = 'fa fa-shopping-bag')
    {
        $items_count = self::get_items_count();
        $is_active_count = get_theme_mod('ahura_show_mini_cart_count') ? ' cart-icon-count' : '';
        if (filter_var($btn_icon, FILTER_VALIDATE_URL)){
            $btn = '<img src="'.$btn_icon.'" alt="cart">';
        } else {
            $btn = '<i class="'.$btn_icon.'"></i>';
        }
        return '<a href="'.wc_get_cart_url().'" cart-mode="3" cart-count="'.$items_count.'" id="mcart-stotal" class="cart-icon'.$is_active_count.'">'.$btn.'</a>';
    }
}