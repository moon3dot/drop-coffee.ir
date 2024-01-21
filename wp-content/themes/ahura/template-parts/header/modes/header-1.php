<?php
$change_side_style = get_theme_mod('ahura_change_mobile_menu_style');
if (has_nav_menu('topmenu')) : ?>
    <div id="siteside" class="siteside <?php echo $change_side_style ? 'siteside-2' : 'siteside-1' ?>">
        <span class="fa fa-<?php echo $change_side_style ? 'times' : 'window-close' ?> siteside-close" id="menu-close"></span>
        <?php \ahura\app\mw_partials::display_header_action_button(); ?>
        <?php rd_topmenu(false); ?>
        <?php if ($change_side_style): ?>
            <div class="siteside-overlay"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div id="mgsiteside" class="mgsiteside">
    <div class="cats-list">
        <span class="mg-cat-title" style="background-color:<?php echo \ahura\app\mw_options::get_mod_theme_color(); ?>;color:<?php echo \ahura\app\mw_options::get_mod_secondary_color(); ?>; ">
            <?php echo \ahura\app\mw_options::get_mod_header_cats_menu_title(); ?>
        </span>
        <?php wp_nav_menu(array('theme_location' => 'mega_menu')); ?>
    </div>
</div>

<div id="ahura-header-main-wrap">
    <div id="topbar" class="topbar header-template-1 <?php echo $is_sticky_menu ? $menu_position_sticky . '-menu-in-sticky' : '' ?> <?php echo \ahura\app\mw_options::get_page_is_float_mode_header(get_the_ID()) ? 'float-mode' : ''; ?> <?php echo $is_menu_in_middle ? 'has_middle_menu' : ''; ?> ahura-main-header header-mode-2 <?php echo \ahura\app\mw_options::check_is_transparent_header() ? 'ahura_transparent' : '';?> clearfix">
        <?php if($menu_position == 'top' || $menu_position_sticky == 'top'): ?>
            <div class="top-section <?php echo $is_sticky_menu && $menu_position_sticky == 'top' ? 'show-in-sticky' : (($menu_position != $menu_position_sticky) ? 'hide-in-sticky' : ''); ?>">
                <div class="topbar-main menu-wrapper top-position <?php echo $menu_alignment?>">
                    <?php rd_topmenu()?>
                    <?php if($isset_sticky_menu && $menu_position_sticky == 'top'): ?>
                        <div class="header-menu-sticky" style="display:none">
                            <?php render_header_sticky_menu() ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="topbar-main middle-section">
            <div class="row">
                <?php
                $logo_alignment = \ahura\app\mw_options::get_mod_logo_alignment();
                ?>
                <div class="col-md-<?php echo $is_menu_in_middle ? '3' : '4';?> logo-wrapper header-logo <?php echo $logo_alignment;?>">
                    <?php if(has_nav_menu('topmenu')): ?>
                        <a href="#" class="menu-icon" id="mw_open_side_menu">
                            <i class="fa fa-bars"></i>
                        </a>
                    <?php endif; ?>
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
                <div class="col-md-<?php echo $is_menu_in_middle ? '6 menu-wrapper' : '4';?> <?php echo $middle_menu_class; ?>">
                    <?php if($is_menu_in_middle || $menu_position_sticky == 'middle'): ?>
                        <div id="top-menu" class="top-menu <?php echo $is_sticky_menu && $menu_position_sticky == 'middle' ? 'show-in-sticky' : (($menu_position != $menu_position_sticky) ? 'hide-in-sticky' : '') ?>">
                            <?php rd_topmenu(); ?>
                            <?php if($isset_sticky_menu && $menu_position_sticky == 'middle'): ?>
                                <div class="header-menu-sticky" style="display:none">
                                    <?php render_header_sticky_menu() ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-<?php echo $is_menu_in_middle ? '3' : '4';?> action-box <?php echo \ahura\app\mw_options::get_mod_action_btn_alignment();?>">
                    <?php if(get_theme_mod('ahura_remove_header_search_box') != true):?>
                        <div class="search-btn-wrapper">
                            <a href="#" id="action_search"><span class="fa fa-search"></span></a>
                        </div>
                    <?php endif;?>
                    <?php if(get_theme_mod('ahorua_header_popup_login',true)):?>
                        <div id="popup_login">
                            <?php \ahura\app\header\PopupLogin::render_popup_link();?>
                        </div>
                    <?php endif;?>
                    <?php if(get_theme_mod('ahorua_show_mini_cart')):?>
                        <?php \ahura\app\mini_cart::init_mini_cart(null, true);?>
                    <?php endif;?>
                    <?php
                    if(\ahura\app\mw_options::show_header_cta_btn()):
                        $show_after_login_btn = \ahura\app\mw_options::get_mod_show_header_after_login_cta_btn();
                        $after_login_url = \ahura\app\mw_options::get_mod_header_after_login_cta_btn_url();
                        $after_login_text = \ahura\app\mw_options::get_mod_header_after_login_cta_btn_text();
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
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="bottom-section">
            <div class="topbar-main">
                <div class="row align-items-center">
                    <?php
                    $is_show_mega_menu = get_theme_mod('ahura_show_mega_menu',true);
                    $mega_menu_alignment = \ahura\app\mw_options::mega_menu_alignment();
                    ?>
                    <?php if($is_show_mega_menu): ?>
                        <div class="col-md-3 <?php echo $mega_menu_alignment?> cats-list <?php echo (!is_front_page() OR !get_theme_mod( 'openmenuinfrontpage') ) ? 'isnotfront' : '' ?>">
                            <span class="cats-list-title"><?php echo \ahura\app\mw_options::get_mod_header_cats_menu_title(); ?></span>
                            <?php render_mega_menu(); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($menu_position == 'bottom' || $menu_position_sticky == 'bottom'): ?>
                        <div class="col-md-<?php echo $is_show_mega_menu ? '9' : '12'; ?> menu-wrapper bottom-position <?php echo $menu_alignment; ?> <?php echo $is_show_mega_menu ? 'with_mega_menu' : '';?> <?php echo $is_sticky_menu && $menu_position_sticky == 'bottom' ? 'show-in-sticky' : (($menu_position != $menu_position_sticky) ? 'hide-in-sticky' : '') ?>">
                            <?php get_template_part('template-parts/header/mode', 'switcher') ?>
                            <?php rd_topmenu()?>
                            <?php if($isset_sticky_menu && $menu_position_sticky == 'bottom'): ?>
                                <div class="header-menu-sticky" style="display:none">
                                    <?php render_header_sticky_menu() ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="col-md-<?php echo $is_show_mega_menu ? '9' : '12'; ?> <?php echo is_rtl() ? 'right' : "left";?>">
                            <?php get_template_part('template-parts/header/mode', 'switcher') ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>