<?php
namespace ahura\app;
class mw_partials
{
    static function load_header()
    {
        $header_slug = 'main';
        get_template_part('partials/header', $header_slug);
    }

    public static function display_header_action_button()
    {
        if(mw_options::show_header_cta_btn()):
            $show_after_login_btn = mw_options::get_mod_show_header_after_login_cta_btn();
            $after_login_url = mw_options::get_mod_header_after_login_cta_btn_url();
            $after_login_text = mw_options::get_mod_header_after_login_cta_btn_text();
            $has_after_login = $show_after_login_btn ? is_user_logged_in() : false;
            ?>
            <?php if ($has_after_login): ?>
                <a href="<?php echo $after_login_url; ?>" class="h-btn after-login-btn" id="action_link">
                    <?php echo $after_login_text; ?>
                </a>
            <?php else: ?>
                <a href="<?php echo \ahura\app\mw_options::get_mod_header_cta_btn_url();?>" class="h-btn" id="action_link">
                    <?php echo \ahura\app\mw_options::get_mod_header_cta_btn_text();?>
                </a>
            <?php endif; ?>
        <?php
        endif;
    }

    public static function handle_change_archive_template_page($default_template){
        if (mw_options::get_mod_is_active_custom_archive()){
            if (is_archive() && (is_category() || is_tag() || is_author())){
                $default_template = get_template_directory() . '/template-parts/archive/custom-archive.php';
            }
        }

        return $default_template;
    }
}