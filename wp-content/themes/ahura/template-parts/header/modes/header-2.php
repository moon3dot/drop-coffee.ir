<?php
global $current_user;

$section_control = new \ahura\app\Header_Section_Control();
$show_mega_menu = get_theme_mod('ahura_show_mega_menu');
$classes = [];

$classes[] = 'header-' . (is_rtl() ? 'rtl' : 'ltr');

if(\ahura\app\mw_options::check_is_transparent_header()){
    $classes[] = 'is-transparent';
}

if(\ahura\app\mw_options::is_active_header_box_mode()){
    $classes[] = 'is-box-mode';

    if(get_theme_mod('ahura_header_sticking_top')){
        $classes[] = 'sticking-top';
    }
}
?>

<?php $section_control->start_section('search'); ?>
<?php if (\ahura\app\mw_options::get_mod_is_active_searhc_box()): ?>
    <form action="/" method="post" class="header-search-form pos-relative" autocomplete="off">
        <input type="text" name="s" placeholder="<?php echo get_theme_mod('ahura_search_box_placeholder') ? get_theme_mod('ahura_search_box_placeholder') : __('Search...', 'ahura') ?>">
        <?php if (get_theme_mod('ahura_search_in_product')): ?>
            <input type="hidden" name="post_type" class="post-type" value="product">
        <?php endif; ?>
        <div class="spin-loader" style="display:none;">
            <svg viewBox="25 25 50 50">
                <circle r="20" cy="50" cx="50"></circle>
            </svg>
        </div>
        <button type="submit"><i class="fas fa-search"></i></button>
        <div class="search-result"></div>
    </form>
<?php endif; ?>
<?php $section_control->end_section(); ?>

<?php $section_control->start_section('buttons'); ?>
<div class="header-buttons">
    <div class="icon-buttons">
        <?php
        $custom_login_url = get_theme_mod('ahorua_header_popup_login_link');
        $custom_popup_login_url = get_theme_mod('ahura_header_popup_login_link_to_url');
        $with_name_cls = is_user_logged_in() && get_theme_mod('ahura_show_user_loggedin_name') ? 'with-name' : '';

        if (\ahura\app\mw_options::get_mod_is_show_header_popup_login()): ?>
            <div class="h-login-wrap d-inline-block pos-relative">
                <a href="<?php echo $custom_popup_login_url ? $custom_popup_login_url : ($custom_login_url && !is_user_logged_in() ? $custom_login_url : (is_user_logged_in() ? $login_url : '#ah-login-modal')) ?>" class="h-btn h-user-login-btn <?php echo $with_name_cls ?>" rel="<?php echo empty($custom_popup_login_url) && !is_user_logged_in() ? 'modal:open' : '' ?>">
                    <i class="fas fa-user"></i>
                    <?php if (!empty($with_name_cls)): ?>
                        <span><?php echo $current_user->display_name ?></span>
                    <?php endif;?>
                </a>
                <?php if (is_user_logged_in() && get_theme_mod('ahura_header_popup_login_show_log_out')): ?>
                    <a href="<?php echo wp_logout_url(); ?>" class="h-logout-btn"><i class="fas fa-sign-out-alt"></i></a>
                <?php endif;?>
            </div>
        <?php endif;?>
        <?php if (\ahura\app\mw_options::get_mod_is_active_mini_cart()): ?>
            <div class="h-basket-wrap d-inline-block pos-relative">
                <a href="<?php echo $cart_url ?>" class="h-btn h-shop-basket-btn">
                    <?php if($cart_total_items && \ahura\app\mw_options::get_mod_is_active_mini_cart_count()): ?>
                        <span class="cart-total no-hide"><?php echo $cart_total_items ?></span>
                    <?php endif; ?>
                    <i class="fas fa-shopping-basket"></i>
                </a>
                <?php if (!get_theme_mod('ahura_mini_cart_hide_content') && \ahura\app\woocommerce::is_active()): ?>
                    <div class="basket-content-wrap">
                        <?php \ahura\app\mini_cart::load_mini_cart_content(true); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif;?>
    </div>
    <?php \ahura\app\mw_partials::display_header_action_button(); ?>
</div>
<?php $section_control->end_section(); ?>

<?php $section_control->start_section('modes'); ?>
    <?php get_template_part('template-parts/header/mode', 'switcher') ?>
<?php $section_control->end_section(); ?>

<?php $section_control->start_section('mobile-side'); ?>
<div class="header-mobile-side">
    <div class="header-side-menu-btn header-menu-btn">
        <i class="fas fa-bars"></i>
    </div>
    <div class="header-menu-side">
        <div class="close-menu"><i class="fas fa-times"></i></div>
        <div class="header-menu-side-content">
            <div class="side-icons">
                <?php $section_control->get_section('buttons')->print_template(); ?>
                <?php $section_control->get_section('modes')->print_template(); ?>
                <?php $section_control->get_section('search')->print_template(); ?>
            </div>
            <?php render_mega_menu('topmenu') ?>
        </div>
        <div class="header-menu-overlay"></div>
    </div>
</div>
<?php $section_control->end_section(); ?>

<?php $section_control->start_section('topmenu'); ?>
<div class="header-top-menu-wrap">
    <div class="header-menu">
        <?php rd_topmenu(); ?>
    </div>
</div>
<?php $section_control->end_section(); ?>

<div id="ahura-header-main-wrap">
    <header id="topbar" class="topbar ahura-header-template header-template-2 <?php echo implode(' ', $classes) ?>">
        <?php if (\ahura\app\mw_options::is_active_notification_bar()): ?>
            <div class="header-top-section hide_in_scroll">
                <div class="header-notice-box">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="header-notice-content">
                                    <div class="header-notice-text">
                                        <div class="header-close-notice"><i class="fas fa-times"></i></div>
                                        <p><?php echo get_theme_mod('ahura_alert_box_text') ?></p>
                                    </div>
                                    <?php if (\ahura\app\mw_options::is_active_notification_bar_button()): ?>
                                        <a href="<?php echo get_theme_mod('ahura_alert_box_btn_link') ?>"><?php echo get_theme_mod('ahura_alert_box_btn_text') ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="header-main-section <?php echo get_theme_mod('ahura_header_logo_alignment_rl') === 'left' ? 'logo-left' : '' ?>">
            <div class="container">
                <div class="header-section-content">
                    <div class="row">
                        <div class="col-3 show-mobile">
                            <?php $section_control->get_section('mobile-side')->print_template(); ?>
                        </div>
                        <div class="col-8 col-md-2 wide-mobile">
                            <div class="header-logo">
                                <a href="<?php bloginfo('url'); ?>" class="logo<?php echo ($use_mobile_logo && $mobile_logo) ? ' has-mobile-logo' : '' ?><?php echo $has_trs_logo ? ' has-trs-logo' : '' ?>">
                                    <?php if (\ahura\app\mw_options::get_mod_logo_option()): ?>
                                        <?php if($has_trs_logo): ?>
                                            <img class="ahura_transparent_logo" src="<?php echo $trs_logo;?>" alt="<?php echo get_bloginfo('name'); ?>"/>
                                        <?php endif; ?>
                                        <?php if($has_dark_mode_logo): ?>
                                            <img class="ahura-dark-mode-logo" src="<?php echo $dark_mode_logo; ?>" alt="<?php echo get_bloginfo('name'); ?>">
                                        <?php endif; ?>
                                        <img src="<?php echo \ahura\app\mw_options::get_mod_theme_logo(); ?>" alt="<?php echo get_bloginfo('name'); ?>" style="<?php echo !$show_mode_switcher && !$has_dark_mode_logo ? 'display:block' : '' ?>" class="primary-logo">
                                        <?php if($use_mobile_logo && $mobile_logo): ?>
                                            <img src="<?php echo $mobile_logo; ?>" alt="<?php echo get_bloginfo('name'); ?>" style="max-width:360px" class="mobile-logo">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <h1 class="logo-text"><?php echo $logo_text ? $logo_text : get_bloginfo('name'); ?></h1>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-4 col-md-6 hide-mobile">
                            <div class="hide-in-sticky">
                                <?php $section_control->get_section('search')->print_template(); ?>
                            </div>
                            <div class="show-in-sticky">
                                <?php $section_control->get_section('topmenu')->print_template(); ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 hide-mobile">
                            <?php $section_control->get_section('buttons')->print_template(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom-section <?php echo $show_mega_menu ? 'has-mega-menu' : ''; ?> mega-menu-<?php echo \ahura\app\mw_options::mega_menu_alignment() ?> hide_in_scroll">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header-bottom-content">
                            <div class="header-menus">
                                <?php if ($show_mega_menu): ?>
                                <div class="header-megamenu <?php echo (is_front_page() && get_theme_mod('openmenuinfrontpage')) ? 'open-in-front' : '' ?>">
                                    <div class="header-menu-btn header-mega-menu-btn">
                                        <i class="fas fa-bars"></i>
                                        <span><?php echo \ahura\app\mw_options::get_mod_header_cats_menu_title(); ?></span>
                                    </div>
                                    <div class="header-menu-container header-mega-menu-container">
                                        <?php render_mega_menu() ?>
                                    </div>
                                    <div class="header-menu-side">
                                        <div class="close-menu"><i class="fas fa-times"></i></div>
                                        <div class="header-menu-side-content">
                                            <?php render_mega_menu() ?>
                                        </div>
                                        <div class="header-menu-overlay"></div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="hide-in-sticky">
                                    <?php $section_control->get_section('topmenu')->print_template(); ?>
                                </div>
                            </div>
                            <div class="hide-mobile">
                                <?php $section_control->get_section('modes')->print_template(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>