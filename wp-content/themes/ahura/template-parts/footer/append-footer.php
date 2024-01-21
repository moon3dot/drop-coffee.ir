<?php
if (\ahura\app\mw_options::show_sticky_buttons()):
    $first_btn = \ahura\app\mw_options::get_mod_show_first_sticky_button();
    $second_btn = \ahura\app\mw_options::get_mod_show_sec_sticky_button();
?>
    <?php if($first_btn): ?>
        <a href="<?php echo \ahura\app\mw_options::get_mod_first_sticky_button_url() ?>" target="_blank" class="ahura-sticky-button ahura-first-sticky-button">
            <i class="<?php echo \ahura\app\mw_options::get_mod_first_sticky_button_icon() ?>"></i>
        </a>
    <?php endif; ?>
    <?php if($second_btn): ?>
        <a href="<?php echo \ahura\app\mw_options::get_mod_sec_sticky_button_url() ?>" target="_blank" class="ahura-sticky-button ahura-second-sticky-button">
            <i class="<?php echo \ahura\app\mw_options::get_mod_sec_sticky_button_icon() ?>"></i>
        </a>
    <?php endif; ?>
<?php endif; ?>

<?php
if(\ahura\app\mw_options::get_show_goto_top_button()):
    $goto_top_mode = \ahura\app\mw_options::get_mod_goto_top_btn_position();
?>
    <div id="goto-top" class="<?php echo $goto_top_mode?>">
        <span class="fa fa-arrow-up"></span>
    </div>
<?php endif; ?>
<?php
if(\ahura\app\mw_options::get_mod_show_preloader()):
    $use_ready_preloader = \ahura\app\mw_options::get_mod_use_ready_preloader();
    $ready_loader_type = get_theme_mod('ahura_ready_preloader_type', 'cube');
    $image = get_theme_mod('ahura_preloader_picture');
    $text = get_theme_mod('ahura_preloader_text');
    $text = !empty($text) ? $text : __('Please wait...', 'ahura');
    ?>
    <div class="ahura-pre-loader <?php echo $use_ready_preloader ? 'use-ready-preloader' : '' ?>">
        <div class="ah-preloader-content">
            <?php if ($use_ready_preloader && !empty($ready_loader_type)): ?>
                <div class="ah-<?php echo $ready_loader_type ?>-loader ah-loader-animation-wrap">
                    <?php if ($ready_loader_type == 'heart-rate'): ?>
                        <svg width="64px" height="48px">
                            <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="back"></polyline>
                            <polyline points="0.157 23.954, 14 23.954, 21.843 48, 43 0, 50 24, 64 24" id="front"></polyline>
                        </svg>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <img src="<?php echo !empty($image) ? $image : \ahura\app\mw_assets::get_img('ahura-logo') ?>" alt="preloader">
            <?php endif; ?>
            <?php if (!empty($text)): ?>
                <div class="ah-preloader-text"><?php echo $text ?></div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php $only_search_product = get_theme_mod('ahura_search_in_product'); ?>
<div class="ahura-modal-search search-modal">
    <div class="search-modal-overlay close"></div>
    <form class="search-form" action="<?php echo home_url()?>" data-template="<?php echo $only_search_product ? 2 : 1 ?>">
        <span class="close"><i class="fa fa-times"></i></span>
        <?php $ajax_search_status = \ahura\app\mw_options::get_mod_is_ajax_search();?>
        <input <?php echo $ajax_search_status ? 'autocomplete="off"' : ''; ?> required type="text" name="s" placeholder="<?php echo get_theme_mod('ahura_search_box_placeholder') ? get_theme_mod('ahura_search_box_placeholder') : __('Type and Hit Enter...','ahura');?>"/>
        <?php
        if($only_search_product) {
            echo '<input type="hidden" name="post_type" value="product" />';
        }
        ?>
        <?php if($ajax_search_status): ?>
            <div class="ajax_search_loading" id="ajax_search_loading"><span class="fa fa-spinner fa-spin"></span></div>
            <div class="ajax_search_res" id="ajax_search_res"></div>
        <?php endif; ?>
    </form>
</div>

<?php if( \ahura\app\woocommerce::is_woocommerce() && \ahura\app\woocommerce::is_product() && get_theme_mod( 'ahura_sticky_addtocart_status' ) ): ?>
<?php global $product; ?>
<div class="ahura-sticky-basket-area">
    <div class="ahura-sticky-basket-title">
        <h2><?php echo $product->get_name(); ?></h2>
    </div>
    <?php if( $product->get_stock_status() == 'outofstock' ): ?>
        <div class="ahura-sticky-basket-notfound">
            <a href="#" class="mw_add_to_cart button" data-product_id="<?php echo $product->get_id(); ?>" data-product_sku="" aria-label="<?php echo $product->get_name(); ?>" aria-describedby="" rel="nofollow" disabled>
                <span><?php echo __('Out of Stock','ahura'); ?></span>
            </a>
        </div>
    <?php else: ?>
        <?php if( $product->has_child() ): ?>
            <a href="#" class="ah-single-sticky-cart-variables-toggle-btn">
                <span><?php echo __('Select Options', 'ahura') ?></span>
                <i class="fas fa-angle-down"></i>
            </a>
            <div class="ahura-sticky-basket-body has_child">
                <?php echo do_shortcode( '[ahura-addtocart-variations]' ); ?>
            </div>
        <?php else: ?>
            <div class="ahura-sticky-basket-body <?php echo $product->get_sale_price() ? 'is_on_sale' : 'mt-4'; ?>">
                <?php echo do_shortcode( '[add_to_cart style="border:none;padding:0" id="'.$product->get_id().'"]' ); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php
if(\ahura\app\mw_options::get_mod_is_show_header_popup_login()): ?>
    <div id="ah-login-modal" class="modal">
        <h2 class="header-popup-title"><?php echo __('Login To Account','ahura');?></h2>
        <?php \ahura\app\header\PopupLogin::render_popup_content();?>
    </div>
<?php endif; ?>
<?php if (\ahura\app\mw_options::get_mod_show_product_quick_view()): ?>
<div class="ah-quick-product-loader" style="display:none;">
    <img src="<?php echo \ahura\app\mw_assets::get_img('loader', 'gif') ?>" alt="loader">
</div>
<?php endif; ?>