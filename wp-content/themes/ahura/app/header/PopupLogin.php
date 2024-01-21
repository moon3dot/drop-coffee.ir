<?php
namespace ahura\app\header;

class PopupLogin
{
    public static function render_popup_link()
    {
        if (is_user_logged_in() == true) {
            $ahura_loggedin_name = "";
            if( get_theme_mod( 'ahura_show_user_loggedin_name' ) ) {
                global $current_user; wp_get_current_user();
                $ahura_loggedin_name = get_theme_mod( 'ahura_user_loggedin_text' ) ? '<span class="ahura_user_displayname">' . str_replace( 'd_name', $current_user->display_name, get_theme_mod( 'ahura_user_loggedin_text' ) ) . '</span>' : '<span class="ahura_user_displayname">' . __('Welcome! ', 'ahura') . $current_user->display_name . "</span>\n";
            }
            if (get_theme_mod('ahura_header_popup_login_show_log_out')) {
                echo '<a class="header-popup-login-icon" href="' . wp_logout_url() . '"><i class="fa fa-sign-out-alt"></i></a>';
                echo $ahura_loggedin_name;
            } else {
                if (get_theme_mod('ahorua_header_popup_login_link')) {
                    echo '<a class="header-popup-login-icon" href="' . get_theme_mod('ahorua_header_popup_login_link') . '"><i class="fa fa-user"></i></a>';
                    echo $ahura_loggedin_name;
                } else {
                    if (class_exists('MihanPanelApp')) {
                        echo '<a class="header-popup-login-icon" href="' . wp_login_url() . '"><i class="fa fa-user"></i></a>';
                        echo $ahura_loggedin_name;
                    } else {
                        if (class_exists('woocommerce')) {
                            echo '<a class="header-popup-login-icon" href="' . get_permalink(get_option('woocommerce_myaccount_page_id')) . '"><i class="fa fa-user"></i></a>';
                            echo $ahura_loggedin_name;
                        } else {
                            echo '<a class="header-popup-login-icon" href="' . admin_url() . '"><i class="fa fa-user"></i></a>';
                            echo $ahura_loggedin_name;
                        }
                    }
                }
            }
        } else {
            if (get_theme_mod('ahura_header_popup_login_link_to_url')) {
                echo '<a class="header-popup-login-icon" href="' . get_theme_mod('ahura_header_popup_login_link_to_url') . '"><i class="fa fa-user"></i></a>';
            } else {
                echo '<a class="header-popup-login-icon open-modal" href="#ah-login-modal" rel="modal:open"><i class="fa fa-user"></i></a>';
            }
        }
    }

    public static function render_popup_content($inElementor = false, $settings = [])
    {
        $other_login_form = \ahura\app\mw_options::get_mod_usage_other_login_forms();
        $other_login_form_shortcode = \ahura\app\mw_options::get_mod_other_login_form_shortcode();
        if($other_login_form && !empty($other_login_form_shortcode)){
            echo do_shortcode($other_login_form_shortcode);
        } else if(\ahura\app\mw_options::get_mod_show_custom_login_form()){
            self::get_custom_login_form();
        } else {
            if (class_exists('woocommerce')) {
                self::woo_login_form($inElementor, $settings);
            } else {
                self::get_wp_login_form();
            }
        }
    }

    public static function get_wp_login_form(){
        echo '<div class="header-popup-login-form">';
        wp_login_form();
        self::after_login_form();
        echo '</div>';
    }

    public static function get_custom_login_form(){
        echo '<div class="header-popup-login-form is-custom-login">';
        include(\ahura\app\files::get_template('header.login-form'));
        echo '</div>';
    }

    public static function get_ahura_woocommerce_login_form()
    {
        if (class_exists('Woocommerce')) {
            wc_get_template('ahura-form-login.php');
            return true;
        }
        return false;
    }

    public static function after_login_form(){
        if(\ahura\app\mw_options::get_mod_is_show_header_popup_register_button()){
            $link = \ahura\app\mw_options::get_mod_header_popup_register_button_link() ?? wp_registration_url();
            $text = \ahura\app\mw_options::get_mod_header_popup_register_button_text() ?? __('Register', 'ahura');
            $class = get_theme_mod('ahura_header_popup_login_register_text_dir') ?? (is_rtl() ? 'right' : 'left');
            echo "<a href='{$link}' class='text-{$class}'>{$text}</a>";
        }
    }

    public static function woo_login_form($inElementor = false, $settings = []){
        echo '<div class="header-popup-login-form">';
        self::get_ahura_woocommerce_login_form();
        if ($inElementor) {
            $link = isset($settings['link']) ? $settings['link'] : '';
            $text = isset($settings['text']) ? $settings['text'] : '';
            $class = isset($settings['class']) ? $settings['class'] : ''; ?>
            <a href="<?php echo $link ?>" class="text-<?php echo $class ?>"><?php echo $text ?></a>
        <?php } else {
            if (!get_theme_mod('use_custom_header')) {
                if (get_theme_mod('ahura_header_show_popup_login_register_text') == true) {
                    $link = get_theme_mod('ahura_header_popup_login_register_link') ?? '#';
                    $text = get_theme_mod('ahura_header_popup_login_register_text') ?? '';
                    $class = get_theme_mod('ahura_header_popup_login_register_text_dir'); ?>
                    <a href="<?php echo $link ?>" class="text-<?php echo $class ?>"><?php echo $text ?></a>
                    <?php
                }
                $link = isset($settings['link']) ? $settings['link'] : wp_registration_url();
                $text = isset($settings['text']) ? $settings['text'] : __('Register', 'ahura');
                $class = isset($settings['class']) ? $settings['class'] : (is_rtl() ? 'right' : 'left');
                ?>
                <a href="<?php echo $link ?>" class="text-<?php echo $class ?>"><?php echo $text ?></a>
            <?php } else {
                if (!get_theme_mod('use_custom_header')) {
                    self::after_login_form();
                }
            }
        }
        echo '</div>';
    }
}
