<?php
// Block direct access to the main plugin file.
defined('ABSPATH') or die('No script kiddies please!');

use ahura\app\mw_options;

$ah_theme_font = (is_rtl()) ? mw_options::get_theme_option('ahura_theme_font') : mw_options::get_theme_option('ahura_en_theme_font');
$default_font_family = (!empty($ah_theme_font) && !in_array($ah_theme_font, ['default_font', 'default'])) ? $ah_theme_font : (is_rtl() ? 'IRANSans' : 'inherit');

echo \ahura\app\Ahura_Custom_Fonts::getFontsCSS();
?>
<?php if( get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
html, body, div, span, em, form, select, input, button, header, footer, textarea
body span, body applet, body object, body iframe,
body h1, body h2, body h3, body h4, body h5, body h6, body p, body blockquote, body pre,
body a, body abbr, body acronym, body address, body big, body cite, body code,
body del, body dfn, body em, body img, body ins, body kbd, body q, body s, body samp,
body small, body strike, body strong, body sub, body sup, body tt, body var,
body b, body u, body center,
body dl, body dt, body dd, body ol, body ul, body li,
body fieldset, body label, body legend,
body table, body caption, body tbody, body tfoot, body thead, body tr, body th, body td,
body article, body aside, body canvas, body details, body embed, 
body figure, body figcaption, body footer, body header, body hgroup, 
body menu, body nav, body output, body ruby, body section, body summary,
body time, body mark, body audio, body video,
body div, body a, body p, body li, body ul, body input, body form, body select, body textarea {
  font-family: inherit;
}
<?php endif; ?>

<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, sub, sup, tt, var, u, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video
{
  font-family:<?php echo $default_font_family ?>;
}
html, body {
  font-weight:<?php echo get_theme_mod('ahura_theme_font_weight') ? get_theme_mod('ahura_theme_font_weight') : 'normal' ?>;
}
textarea, input, button, select
{
  font-family:<?php echo $default_font_family ?>;
  font-weight:<?php echo get_theme_mod('ahura_theme_font_weight') ? get_theme_mod('ahura_theme_font_weight') : 'normal' ?>;
}
.elementor-widget-wrap .elementor-widget-container:not(:has(> i[class*="elementor-"]:not([class*="eicon"]):not([class*="fa"])))
{
	font-family:<?php echo $default_font_family ?>;
}
<?php endif; ?>
<?php if(get_theme_mod('use_fa_fonts')): ?>
body, body div, body a, body p, body li, body ul, body input, body form {
    font-family: inherit;
}
<?php endif; ?>
<?php
if ($theme_color = \ahura\app\mw_options::get_mod_theme_color()):
  $secondary_color = \ahura\app\mw_options::get_mod_secondary_color();
  ?>
  .woocommerce span.onsale,.woocommerce-widget-layered-nav-list li span,
  .category-alt,
  .cats-list ul.menu>li>a::before,
  .header-mode-3 .panel_menu_wrapper .mini-cart-header .cart-icon::after,
  .header-mode-3 .panel_menu_wrapper .cta_button,
  .sidebar-widget .price_slider_wrapper .price_slider.ui-slider .ui-slider-range,
  #goto-top,
  .header-mode-2 .action-box #action_link:hover,
  .woocommerce ul.products li.product .button,
  .footer-center-border-top::before,
  input[type="submit"], button,.woocommerce .button.alt,
  .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button,
    .woocommerce #payment #place_order, .woocommerce-page #payment #place_order,
    #add_payment_method .wc-proceed-to-checkout a.checkout-button,
    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
    .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button,
    .woocommerce #respond input#submit.disabled,
    .woocommerce #respond input#submit:disabled,
    .woocommerce #respond input#submit:disabled[disabled],
    .woocommerce a.button.disabled,
    .woocommerce a.button:disabled,
    .woocommerce a.button:disabled[disabled],
    .woocommerce button.button.disabled,
    .woocommerce button.button:disabled,
    .woocommerce button.button:disabled[disabled],
    .woocommerce input.button.disabled,
    .woocommerce input.button:disabled,
    .woocommerce input.button:disabled[disabled],
    body.woocommerce .post-box ul.products li.mw_product_item.product a.button.add_to_cart_button,
    #ex1 button,
    .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button.alt,
    .woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button.alt.disabled {
    background-color:<?php echo $theme_color;?>;
  }
  .woocommerce button.button:disabled, .woocommerce button.button:disabled[disabled] {
    color: <?php echo $secondary_color;?>;
  }
  .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover {
    background-color: <?php echo $theme_color; ?>dd;
    color: <?php echo $secondary_color;?>;
  }
  .woocommerce-message {
    border-top-color:<?php echo $theme_color;?>;
  }
  .woocommerce-message::before {
    color:<?php echo $theme_color;?>;
  }
  .wc_payment_method input[type="radio"]::before {
    background-color:<?php echo $theme_color;?>;
  }
  .woocommerce nav.woocommerce-pagination ul li span.current
  {
      background-color: <?php echo $theme_color;?>;
      box-shadow: 0 0 10px 0px <?php echo $theme_color;?>;
  }
  body.woocommerce span.onsale,
  body.woocommerce ul.products li.product .button, 
  div.header-mode-3 .panel_menu_wrapper .cta_button, 
  input[type="submit"], 
  .woocommerce #respond input#submit, 
  .woocommerce a.button, .woocommerce button.button, 
  .woocommerce input.button, .woocommerce .button.alt, 
  .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
  .woocommerce #payment #place_order, 
  .woocommerce-page #payment #place_order,
  body.woocommerce .post-box ul.products li.mw_product_item.product a.button.add_to_cart_button
  {
    color: <?php echo $secondary_color;?>;
  }
    body.woocommerce span.onsale{
    box-shadow:0 0 10px <?php echo $theme_color;?>90;
  }
  div.header-mode-3 .panel_menu_wrapper .cta_button
  {
    box-shadow: 0 0 15px <?php echo $theme_color;?>;
  }
  div.header-mode-1 .search-form #ajax_search_loading span,
  div.header-mode-2 .action-box #action_link,
  div.header-mode-3 .search-form #ajax_search_loading span,
  .footer-legend-inner h5,
  .website-footer .footer-widget span.footer-widget-title,
  .list-posts-widget li:hover p{
    color:<?php echo $theme_color;?>;
  }
  .cats-list .menu li:hover > a,.topmenu li ul li a:hover,.topmenu li ul li:hover > a,.topmenu li ul li:hover::after{
    color:<?php echo $theme_color;?>;
  }
  #topbar,
  .cats-list ul.menu.show_menu,
  .website-footer{
    border-top-color:<?php echo $theme_color;?>;
  }
  .footer-legend a{
    background:<?php echo $theme_color;?>;
  }
  .post-title h1 a:hover{
    color:<?php echo $theme_color;?>;
  }
  .related-posts-title {
    color:<?php echo $theme_color;?>;
    border-bottom-color:<?php echo $theme_color;?>;
  }
  input:focus,textarea:focus{
    border-color:<?php echo $theme_color;?>;
  }
  .comment-reply-link{
    color:<?php echo $theme_color;?>;
    border-color:<?php echo $theme_color;?>;
  }
  .authorabout span a{
    background:<?php echo $theme_color;?>;
  }
  .main-menu li:hover:after{
    color:<?php echo $theme_color;?>;
  }
  .navigation li a,
  .navigation li a:hover,
  .navigation li.active a,
  .navigation li.disabled {
    border-color:<?php echo $theme_color;?>;
    color:<?php echo $theme_color;?>;
  }
  .navigation li a:hover,
  .navigation li.active a {
    color:#fff;
    background-color:<?php echo $theme_color;?>;
  }
  .post-index h2.cat-name{
    color:<?php echo $theme_color;?>;
    border-bottom-color:<?php echo $theme_color;?>;
  }
  .woocommerce div.product form.cart button,
  .woocommerce div.product form.cart button:hover {
    background-color:<?php echo $theme_color;?>;
    color: <?php echo $secondary_color;?>
  }
  .search .searchbtn:hover{
    color:<?php echo $theme_color; ?>;
  }
  <?php if (get_theme_mod('ahura_shop_show_boxshadow', true)):?>
  .mw_product_item.product-style-1:hover {
    box-shadow: 0 0 25px 0px <?php echo $theme_color?>;
  }
  <?php endif; ?>
  <?php if (get_theme_mod('ahura_shop_show_boxcover', false)):?>
    .mw_product_item.product-style-1:hover {
      box-shadow: initial !important;
    }
    .mw_product_item.product-style-1:hover {
        border: 1px solid #f7f7f7 !important;
        z-index: initial !important;
    }

    .mw_product_item.product-style-1:hover .mw_add_to_cart,
    .mw_product_item.product-style-1:hover .mw_term_data {
        opacity: 0;
    }

    .mw_product_item.product-style-1:hover .mw_overly {
        display: none;
    }

    .mw_product_item.product-style-1:hover .woocommerce-loop-product__title,
    .mw_product_item.product-style-1:hover span.price * {
        color: initial !important;
    }
  <?php endif; ?>
  <?php if (get_theme_mod('ahura_shop_show_addtocartbtn_onproduct', false)):?>
    .mw_product_item.product-style-1 .mw_add_to_cart,
    .mw_product_item.product-style-1 .mw_add_to_cart,
    body.woocommerce ul.products li.product.mw_product_item.product-style-1 .button.mw_add_to_cart {
        display: none;
    }
  <?php endif; ?>
  <?php if (get_theme_mod('ahura_shop_show_cat_onproduct', false)):?>
    .mw_product_item.product-style-1 .mw_term_data,
    .mw_product_item.product-style-1 .mw_term_data,
    body.woocommerce ul.products li.product.mw_product_item.product-style-1 .mw_term_data {
        display: none;
    }
  <?php endif; ?>
  .woocommerce .mw_product_item.product-style-1 .mw_overly
  {
    background: <?php echo $theme_color; ?>;
    opacity: .7;
  }
  .mw_product_item.product-style-1:hover .woocommerce-loop-product__title,
  .mw_product_item.product-style-1:hover span.price *
  {
    color: <?php echo $secondary_color;?>;
  }
    body.woocommerce .woocommerce-tabs.wc-tabs-wrapper .tabs.wc-tabs li.active
  {
      background-color: <?php echo $theme_color ?>;
      box-shadow: 0px 1px 10px 0px <?php echo $theme_color?>;
      color: <?php echo $secondary_color; ?>;
  }
    .ahura_contact_widget .ahura_contact_widget_item span{
    color:<?php echo $theme_color?>;
  }
  body.woocommerce .shop_table .button{
    color:<?php echo $secondary_color?>;
  }
    body.woocommerce .button.alt{
    color:<?php echo $secondary_color?>;
  }
    body.woocommerce .woocommerce-tabs.wc-tabs-wrapper .tabs.wc-tabs li.active{
    background-color: <?php echo $theme_color;?>;
    box-shadow: 0px 1px 10px 0px <?php echo $theme_color;?>;
  }
<?php endif;?>
<?php if (get_theme_mod('bgcolor')) : ?>
  html, body{
    background:<?php echo get_theme_mod('bgcolor');?>;
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_change_header_dimension', false) && get_theme_mod('ahura_header_width')) : ?>
    @media only screen and (min-width:1200px){
        .topbar-main, .header-template-2 .container {
            width: <?php echo get_theme_mod('ahura_header_width') ?>%;
            max-width: none;
        }
    }
<?php endif;?>
<?php if (\ahura\app\mw_options::get_mod_is_stickyheader()) : ?>
  @media only screen and (min-width:1100px){
    .scrolled-topbar .menu-icon{
      background-color: <?php $theme_color = \ahura\app\mw_options::get_mod_theme_color(); echo $theme_color ? $theme_color : '#fed700';?>;
      color: <?php echo \ahura\app\mw_options::get_mod_secondary_color(); ?>;
    }
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_legend_background')) : ?>
  .footer-legend{
    background:url('<?php echo get_theme_mod('ahura_legend_background'); ?>') no-repeat center center;
  }
<?php endif;?>
<?php $theme_columns = \ahura\app\mw_options::get_mod_theme_columns(); if ($theme_columns == '1c') : ?>
  body:not([class*="page-id-"]) .ahura-post-single:not(.woocommerce) .post-box{width:100%;}
  .ahura-1cc-column.ahura-post-single:not(.woocommerce) .post-entry{width: 100%;}
<?php endif;?>
<?php if ($theme_columns == '1cc') : ?>
    .ahura-1cc-column.ahura-post-single:not(.woocommerce) .post-entry{width: 100%;}
<?php endif;?>
<?php if ($theme_columns == '3c') : ?>
  .ahura-post-single:not(.woocommerce) .post-entry{width:65%;float:left;}
  .ahura-post-single:not(.woocommerce) .related-posts{width:65%;float:left;}
  .ahura-post-single:not(.woocommerce) .related-posts article span{margin-top:5%}
<?php endif;?>
<?php if ($theme_columns == '2cr') : ?>
  .ahura-post-single:not(.woocommerce) .sidebar{float:left}
<?php endif;?>
<?php $sohp_columns = \ahura\app\mw_options::get_mod_shop_columns(); if ($sohp_columns == '1c') : ?>
  .ahura-1c-column.woocommerce .post-box{width:100%;}
<?php endif;?>
<?php if ($sohp_columns == '3c') : ?>
  section.container.ahura-shop-single .post-box .post-entry{width:690px;float:left;}
<?php endif;?>
<?php if ($sohp_columns == '2cr') : ?>
  section.container.ahura-shop-single .sidebar{float:right}
  section.container.ahura-shop-single .post-box{float:left;}
  .ahura-2cr-column .post-box{float:left;}
<?php endif;?>
<?php if (get_theme_mod('ahura_footer_color')) : ?>
  .website-footer {
    background-color:<?php echo get_theme_mod('ahura_footer_color');?>
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_footer_bg')) : ?>
  .website-footer {
    background-image:url('<?php echo get_theme_mod('ahura_footer_bg');?>');
    background-size: <?php echo get_theme_mod('ahura_footer_bg_size', 'auto');?>;
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_footer_text_color')) : ?>
    .website-footer .footer-widget span.footer-widget-title,
    .footer-copyright,
    .footer-legend-inner h5,
    .footer-copyright2,.website-footer
    .footer-widget *,
    .footer-copyright-fullwidth,
    .footer-bottom,
    .website-footer .footer-widget .menu li a,
    .foot-widget-content {
    color:<?php echo get_theme_mod('ahura_footer_text_color');?>
  }
<?php endif;?>
<?php if (\ahura\app\mw_options::check_is_transparent_header()): ?>
  <?php if ($transparent_content_color = \ahura\app\mw_options::get_mod_transparent_header_content_color()): ?>
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .action-box #action_link,
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .action-box #action_search,
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .action-box #mcart-stotal,
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .top-menu ul.topmenu>li>a,
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .top-menu ul.topmenu>li::after,
    .ahura-main-header.ahura_transparent:not(.scrolled-topbar) .top-section .menu-wrapper ul.topmenu > li > a,
    .ahura-main-header.ahura_transparent:not(.scrolled-topbar) .top-section .menu-wrapper ul.topmenu > li::after,
    .ahura-main-header.ahura_transparent:not(.scrolled-topbar) .bottom-section .menu-wrapper ul.topmenu > li > a,
    .ahura-main-header.ahura_transparent:not(.scrolled-topbar) .bottom-section .menu-wrapper ul.topmenu > li::after
    {
      color: <?php echo $transparent_content_color; ?>;
    }
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .action-box #action_link:hover
    {
      background-color: <?php echo $transparent_content_color; ?>;
      color: <?php echo \ahura\app\mw_options::get_mod_bg_color();?>;
    }
  <?php endif; ?>
  <?php if (\ahura\app\mw_options::get_mod_ahorua_transparent_logo()): ?>
    .header-mode-2.ahura_transparent:not(.scrolled-topbar) .logo img:not(.ahura_transparent_logo),
    .header-mode-2.ahura_transparent.scrolled-topbar .logo img.ahura_transparent_logo
    {
      display: none;
    }
  <?php endif; ?>
<?php endif; ?>
.header-mode-1 .cats-list-title,
html body .header-mode-1 span.cats-list-title
{
  color: <?php echo \ahura\app\mw_options::get_mod_secondary_color(); ?>;
}
<?php if (\ahura\app\mw_options::get_mod_is_justify_paragraph()): ?>
  p{
    text-align:justify;
  }
<?php endif; ?>
<?php if (get_theme_mod('ahura_content_radius')) :?>
.woocommerce div.product{
  border-radius:<?php echo get_theme_mod('ahura_content_radius'); ?>px;
}
.post-entry-custom{
  border-radius: <?php echo get_theme_mod('ahura_content_radius');?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_content_shadow')) :?>
  .post-entry {
    box-shadow: 0 7px 36px rgba(0, 0, 0, <?php echo(intVal(get_theme_mod('ahura_content_shadow'))/100); ?>);
  }
<?php endif; ?>
<?php if (get_theme_mod('ahura_sidebar_widget_radius')) :?>
.sidebar-widget{
  border-radius:<?php echo get_theme_mod('ahura_sidebar_widget_radius'); ?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_cta_widget_radius')) :?>
#action_link,
.panel_menu_wrapper .cta_button,
.header-template-2 .header-buttons #action_link{
  border-radius: <?php echo get_theme_mod('ahura_cta_widget_radius') ;?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_gototop_widget_radius')) :?>
#goto-top{
  border-radius: <?php echo get_theme_mod('ahura_gototop_widget_radius') ;?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_product_regular_price_color')) :?>
.woocommerce ul.products li.product span.price, .product span.price,.sale span.price del *, .mwprprice p, .mwprprice p span, .owl-carousel .owl-item .mwprprice p, .woocommerce div.product p.price del, .woocommerce div.product span.price, .mw_shop_cat_item_price .price del, .mw_shop_cat_item_price .price span.amount, .woocommerce div.product .summary p.price, .woocommerce div.product .summary span.price, .product-page-digi-style .product-page-addtocart-box .woocommerce-Price-amount.amount bdi{
  color:<?php echo get_theme_mod('ahura_product_regular_price_color'); ?>;
}
<?php endif; ?>

<?php if (get_theme_mod('ahura_product_sale_price_color')) :?>
.sale span.price ins *, .mwprprice .price ins, .mw_shop_cat_item_price .price ins, .woocommerce div.product p.price ins {
  color:<?php echo get_theme_mod('ahura_product_sale_price_color'); ?>;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_onsale_date_color')) :?>
.product .sale_price_date {
  color:<?php echo get_theme_mod('ahura_onsale_date_color'); ?>;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_onsale_label_color')) :?>
body.woocommerce span.onsale, body.woocommerce ul.products li.product .onsale {
  color:<?php echo get_theme_mod('ahura_onsale_label_color'); ?>;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_onsale_label_backcolor')) :?>
body.woocommerce span.onsale, body.woocommerce ul.products li.product .onsale {
  background-color:<?php echo get_theme_mod('ahura_onsale_label_backcolor'); ?>;
  box-shadow: 0 0 10px <?php echo get_theme_mod('ahura_onsale_label_backcolor'); ?>;
}
<?php endif; ?>
<?php if (get_theme_mod('post_paragraph_size')) :?>
.post-custom p{
  font-size: <?php echo get_theme_mod('post_paragraph_size') ;?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_product_desktop_column')) :?>
@media (min-width: 576.99px) {
    .woocommerce .upsells .products,
    .woocommerce #tab-more_seller_product .products,
    .single-product .related:not(.related-slider) .products,
    .woocommerce #tab-more_seller_product.is-direct-products {
        grid-template-columns: repeat(<?php echo get_theme_mod('ahura_product_desktop_column') ?>,minmax(0,1fr));
  }
  .woocommerce ul.products:not(.elementor-grid), .woocommerce.woocommerce-page ul.products:not(.elementor-grid), .woocommerce ul.products[class*=columns-]:not(.elementor-grid) {
    grid-template-columns: repeat(<?php echo get_theme_mod('ahura_product_desktop_column') ?>,minmax(0,1fr));
  }
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_product_mobile_column')) :?>
@media screen and (min-width: 320px) and (max-width: 576px) {
    .woocommerce .upsells .products,
    .woocommerce #tab-more_seller_product .products,
    .single-product .related:not(.related-slider) .products,
    .woocommerce #tab-more_seller_product.is-direct-products {
        grid-template-columns: repeat(<?php echo get_theme_mod('ahura_product_mobile_column') ?>,minmax(0,1fr));
    }
    .woocommerce ul.products:not(.elementor-grid), .woocommerce.woocommerce-page ul.products:not(.elementor-grid), .woocommerce ul.products[class*=columns-]:not(.elementor-grid) {
      grid-template-columns: repeat(<?php echo get_theme_mod('ahura_product_mobile_column') ?>,minmax(0,1fr));
    }
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_shop_show_product_related')) :?>
.woocommerce .related ul.products,
.woocommerce.woocommerce-page .related ul.products,
.woocommerce .related ul.products[class*=columns-] {
    grid-template-columns: repeat(<?php echo get_theme_mod('ahura_related_product_column') ?>,minmax(0,1fr));
}

@media screen and (max-width: 767px) {
    .woocommerce .related ul.products,
    .woocommerce.woocommerce-page .related ul.products,
    .woocommerce .related ul.products[class*=columns-] {
    grid-template-columns: repeat(<?php echo get_theme_mod('ahura_related_product_column_mobile') ?>,minmax(0,1fr));
    }
}
<?php endif; ?>
<?php if (get_theme_mod('product_title_desktop_font_size')) :?>
    @media screen and (min-width: 768px) {
        .archive.woocommerce .mw_product_item .woocommerce-loop-product__title,
        .archive.woocommerce ul.products li.product .woocommerce-loop-product__title {
            font-size: <?php echo intval(get_theme_mod('product_title_desktop_font_size')); ?>px;
        }
    }
<?php endif; ?>
<?php if (get_theme_mod('product_title_mobileview_font_size')) :?>
@media screen and (min-width: 320px) and (max-width: 576px) {
    .archive.woocommerce .mw_product_item .woocommerce-loop-product__title,
    .archive.woocommerce ul.products li.product .woocommerce-loop-product__title {
    font-size: <?php echo intval(get_theme_mod('product_title_mobileview_font_size')); ?>px;
  }
}
<?php endif; ?>

<?php if (get_theme_mod('price_mobileview_multicol_font_size')) :?>
@media screen and (min-width: 320px) and (max-width: 576px) {
  .mw_product_item span.price * {
    font-size: <?php echo get_theme_mod('price_mobileview_multicol_font_size'); ?>px;
  }
}
<?php endif; ?>
<?php if (get_theme_mod('post_paragraph_a_size')) :?>
.post-custom p a, .post-custom table a{
  font-size: <?php echo get_theme_mod('post_paragraph_a_size') ;?>px;
}
<?php endif; ?>
<?php if (get_theme_mod('post_paragraph_a_color')) :?>
.post-custom p a, .post-custom table a, .post-custom p a *{
  color: <?php echo get_theme_mod('post_paragraph_a_color') ;?>;
}
<?php endif; ?>
<?php if (get_theme_mod('post_paragraph_color')) :?>
.post-custom p, .post-custom ul li, .post-entry ul.post-categories li a {
  color: <?php echo get_theme_mod('post_paragraph_color') ;?>;
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_border_sidebar_title_color')): ?>
.sidebar-widget-title::before,
.sidebar-widget .wp-block-heading::before{
  background-color: <?php echo get_theme_mod('ahura_border_sidebar_title_color'); ?>
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_background_selctor_color')) :?>
::selection{
  background-color: <?php echo get_theme_mod('ahura_background_selctor_color'); ?>
}
::-moz-selection{
  background-color: <?php echo get_theme_mod('ahura_background_selctor_color'); ?>
}
<?php endif; ?>
<?php if (get_theme_mod('ahura_background_selctor_text_color')) :?>
::selection{
  color: <?php echo get_theme_mod('ahura_background_selctor_text_color'); ?>
}
::-moz-selection{
  color: <?php echo get_theme_mod('ahura_background_selctor_text_color'); ?>
}
<?php endif; ?>

<?php if (get_theme_mod('ahura_cat_description_backgroundcolor')) :?>
.cat-description {
	background-color: <?php echo get_theme_mod('ahura_cat_description_backgroundcolor'); ?>
}
<?php endif; ?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_bloginfo('language') == 'en-US'):?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'default_font'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}
textarea, input, button, select
{
	font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'arial'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family: Arial;
}
textarea, input, button, select
{
	font-family: Arial;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'cambria'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family: cambria;
}
textarea, input, button, select
{
	font-family: cambria;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'candara'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family: candara;
}
textarea, input, button, select
{
	font-family: candara;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'consolas'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family: Consolas;
}
textarea, input, button, select
{
	font-family: Consolas;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_en_theme_font') == 'constantia'):?>
  html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video, .elementor-widget-wrap .elementor-widget-container [class*="elementor-"]
{
	font-family: Constantia;
}
textarea, input, button, select
{
	font-family: Constantia;
}
<?php endif;?>
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('ahura_menu_font_size')):?>

.topmenu li a,
ul.topmenu li a, 
.header-mode-2 .top-menu ul li a,
.header-template-2 .header-menu li a {
  font-size: <?php echo get_theme_mod('ahura_menu_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_menu_font_family')):
    $ff = get_theme_mod('ahura_menu_font_family');
    $default_menu_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
  .topmenu li a, .header-top-menu-wrap li a{
    font-family: <?php echo $default_menu_font ?>;
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_menu_font_weight')):?>
.topmenu li a{
font-weight: <?php echo get_theme_mod('ahura_menu_font_weight') ?? 'normal' ?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('ahura_menu_color')):?>
  @media only screen and (min-width: 1001px) {
    .topmenu li a,
    .header-template-2 .header-menu li a {
      color: <?php echo get_theme_mod('ahura_menu_color')?>;
    }
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_menu_hover_color')):?>
    @media only screen and (min-width: 1001px) {
        .header-template-2 .header-menu li a:hover {
            color: <?php echo get_theme_mod('ahura_menu_hover_color')?>;
        }
    }
<?php endif;?>
<?php if (get_theme_mod('ahura_popup_login_font_size')):?>
  .header-popup-login-icon{
  font-size: <?php echo get_theme_mod('ahura_popup_login_font_size');?>px;
  }
<?php endif;?>
<?php if (get_theme_mod('ahura_popup_login_color')):?>
.header-popup-login-icon,
.header-template-2 .header-buttons .h-user-login-btn{
  color: <?php echo get_theme_mod('ahura_popup_login_color')?>;
  border-color:<?php echo get_theme_mod('ahura_popup_login_color')?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_mega_menu_font_size')):?>
.cats-list-title,.mega_menu_mobile_title,.mg-cat-title,.header-mega-menu-btn span{
  font-size: <?php echo get_theme_mod('ahura_mega_menu_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
  <?php if (get_theme_mod('ahura_mega_menu_font_family')):
      $ff = get_theme_mod('ahura_mega_menu_font_family');
      $default_mmenu_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
      ?>
.cats-list-title,.mega_menu_mobile_title,.mg-cat-title, .cats-list ul.menu a, .header-megamenu li a{
    font-family: <?php echo $default_mmenu_font ?>;
}
  <?php endif;?>
    .cats-list-title,.mega_menu_mobile_title,.mg-cat-title{
    font-weight: <?php echo get_theme_mod('ahura_mega_menu_font_weight') ?? 'normal' ?>;
    }
  <?php endif;?>
  <?php if (get_theme_mod('change_footer_namad_and_copyright_direction')):?>
    .footer-end-100, .website-footer > div > .row{
      flex-direction: row-reverse;
    }
    .footer-copyright{
      text-align: left;
    }
    .website-footer .footer-copyright2-section {
      flex-direction: revert;
    }
    .website-footer .footer-end {
      flex-direction: row-reverse;
    }
  <?php endif;?>
  <?php if (get_theme_mod('comment_send_button_background')):?>
    #commentform input[type=submit]{
      background-color: <?php echo get_theme_mod('comment_send_button_background');?>;
    }
  <?php endif;?>
  <?php if (get_theme_mod('comment_send_button_color')):?>
    #commentform input[type=submit]{
      color: <?php echo get_theme_mod('comment_send_button_color');?>;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_1_size')):?>
    .post-custom h1 a{
      font-size: <?php echo get_theme_mod('ahura_heading_1_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_2_size')):?>
    .post-custom h2{
      font-size: <?php echo get_theme_mod('ahura_heading_2_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_3_size')):?>
    .post-custom h3{
      font-size: <?php echo get_theme_mod('ahura_heading_3_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_4_size')):?>
    .post-custom h4{
      font-size: <?php echo get_theme_mod('ahura_heading_4_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_5_size')):?>
    .post-custom h5{
      font-size: <?php echo get_theme_mod('ahura_heading_5_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_heading_5_size')):?>
    .post-custom h6{
      font-size: <?php echo get_theme_mod('ahura_heading_6_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_preloader_background')):?>
    .ahura-pre-loader{
      background-color: <?php echo get_theme_mod('ahura_preloader_background');?>;
    }
  <?php endif;?>
<?php if (get_theme_mod('ahura_preloader_text_color')):?>
    .ahura-pre-loader .ah-preloader-text{
    color: <?php echo get_theme_mod('ahura_preloader_text_color');?>;
    }
<?php endif;?>
  <?php if (get_theme_mod('ahura_header_background')):?>
  #topbar,#topbar .bottom-section,
  .header-template-2 {
    background-color: <?php echo get_theme_mod('ahura_header_background');?>;
  }
    .header-template-2 .header-main-section {
        border-color: <?php echo get_theme_mod('ahura_header_background');?>;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_remove_header_shadow')):?>
  #topbar{
    box-shadow: none;
  }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_footer_widget_font_size')):?>
    footer.website-footer .footer-widget .footer-widget-title{
      font-size:<?php echo get_theme_mod('ahura_footer_widget_font_size');?>px;
    }
  <?php endif;?>
  <?php if (get_theme_mod('ahura_footer_widget_font_color')):?>
    footer.website-footer .footer-widget .footer-widget-title,
    footer.website-footer .foot-widget-title,
    footer.website-footer .wp-block-heading{
      color:<?php echo get_theme_mod('ahura_footer_widget_font_color');?>;
    }
  <?php endif;?>
  <?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
  <?php if (get_theme_mod('ahura_footer_widget_font_family')):
      $ff = get_theme_mod('ahura_footer_widget_font_family');
      $default_fw_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
      ?>
    footer .footer-widget .footer-widget-title, footer .footer-widget p, footer .footer-widget div{
        font-family: <?php echo $default_fw_font ?>;
    }
  <?php endif;?>
    <?php if( get_theme_mod( 'ahura_footer_widget_font_weight' ) ): ?>
    footer .footer-widget .footer-widget-title, footer .footer-widget p, footer .footer-widget div{
    font-weight: <?php echo get_theme_mod('ahura_footer_widget_font_weight') ?? 'normal' ?>;
    }
    <?php endif;?>
  <?php endif;?>

  .ahura-main-header .top-section
  {
    background-color: <?php echo \ahura\app\mw_options::get_mod_header_top_box_background_color()?>;
  }
  .ahura-main-header .bottom-section
  {
    background-color: <?php echo \ahura\app\mw_options::get_mod_header_bottom_box_background_color()?>;
  }
  .ahura-main-header .top-section .menu-wrapper ul.topmenu > li > a,
  .ahura-main-header .top-section .menu-wrapper ul.topmenu > li::after,
  .ahura-main-header .bottom-section .menu-wrapper ul.topmenu > li > a,
  .ahura-main-header .bottom-section .menu-wrapper ul.topmenu > li::after
  {
    color: <?php echo \ahura\app\mw_options::get_mod_header_top_and_bottom_box_text_color()?>;
  }
  .ahura-main-header .bottom-section .cats-list ul.menu,
  .ahura-main-header .bottom-section .cats-list ul.menu ul,
  .header-template-2 .header-mega-menu-container > div,
  .header-template-2 .header-mega-menu-container .menu > li > ul
  {
    background-color: <?php echo \ahura\app\mw_options::get_mod_mega_menu_wrapper_background_color()?>;
  }
  .ahura-main-header .bottom-section .cats-list ul.menu a,
  .header-template-2 .header-mega-menu-container ul li a
  {
    color: <?php echo \ahura\app\mw_options::get_mod_mega_menu_wrapper_text_color();?>;
  }
  .ahura-main-header .bottom-section .cats-list ul.menu>li>a::after
  {
    border-color: <?php echo \ahura\app\mw_options::get_mod_mega_menu_item_border_color()?>;
  }
  <?php if (!\ahura\app\mw_options::get_mod_is_show_header_top_border()): ?>
    .topbar:not(.in_custom_header)
    {
      border: none;
    }
  <?php endif; ?>
  <?php if (\ahura\app\mw_options::get_mod_is_show_header_top_border() && $header_border_height = \ahura\app\mw_options::get_mod_header_top_border_height()): ?>
    .ahura-main-header
    {
      border-width: <?php echo $header_border_height;?>px;
    }
  <?php endif; ?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_post_font_family')):
    $ff = get_theme_mod('ahura_post_font_family');
    $default_pf_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.ahura-post-single p{
  font-family:<?php echo $default_pf_font ?>;
}
<?php endif;?>
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_en_post_font_family')):
    $ff = get_theme_mod('ahura_en_post_font_family');
    $default_pf_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
body:not(.rtl) .ahura-post-single p{
  font-family:<?php echo $default_pf_font ?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('ahura_post_content_font_weight')):
    $fw = get_theme_mod('ahura_post_content_font_weight');
    ?>
.ahura-post-single p{
  font-weight:<?php echo $fw ?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_post_title_font_size')):?>
.ahura-post-single header.post-title h1 {
  font-size: <?php echo get_theme_mod('ahura_post_title_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_post_title_font_family')):
    $ff = get_theme_mod('ahura_post_title_font_family');
    $default_pt_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.ahura-post-single header.post-title h1 {
  font-family: <?php echo $default_pt_font;?>;
}
<?php endif;?>
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_en_post_title_font_family')):
    $ff = get_theme_mod('ahura_en_post_title_font_family');
    $default_pt_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
body:not(.rtl) .ahura-post-single header.post-title h1 {
  font-family: <?php echo $default_pt_font;?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('ahura_post_title_font_weight')):
    $fw = get_theme_mod('ahura_post_title_font_weight');
    ?>
.ahura-post-single header.post-title h1,
body .ahura-post-single header.post-title h1{
  font-weight:<?php echo $fw ?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_post_title_color')):?>
.ahura-post-single header.post-title h1 {
  color: <?php echo get_theme_mod('ahura_post_title_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_post_background_color')):?>
.ahura-post-single article{
  background-color: <?php echo get_theme_mod('ahura_post_background_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_404_go_home_background_color')):?>
.go-home-404{
  background-color: <?php echo get_theme_mod('ahura_404_go_home_background_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_404_go_home_color')):?>
.go-home-404{
  color: <?php echo get_theme_mod('ahura_404_go_home_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_404_go_home_border_radius')):?>
.go-home-404{
  border-radius: <?php echo get_theme_mod('ahura_404_go_home_border_radius');?>px;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_404_go_home_shadow_color')):?>
.go-home-404{
  box-shadow:0 0 10px <?php echo get_theme_mod('ahura_404_go_home_shadow_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_mini_cart_count_background_color')):?>
.cart-icon-count::after,
.header-template-2 .cart-total{
  background-color: <?php echo get_theme_mod('ahura_mini_cart_count_background_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_mini_cart_count_color')):?>
.cart-icon-count::after,
.header-template-2 .cart-total{
  color: <?php echo get_theme_mod('ahura_mini_cart_count_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_mega_menu_title_background_color')):?>
html body span.cats-list-title, html body .header-mode-1 span.cats-list-title,
.header-template-2 .header-mega-menu-btn {
  background-color: <?php echo get_theme_mod('ahura_mega_menu_title_background_color')?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_mega_menu_title_color')):?>
.cats-list-title,
html body span.cats-list-title,
.mega_menu_mobile_title,
.mg-cat-title,
.header-template-2 .header-mega-menu-btn
{
  color: <?php echo get_theme_mod('ahura_mega_menu_title_color')?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_show_product_stock_status_background')):?>
body.woocommerce .mw_product_item .out-of-stock{
  background-color: <?php echo get_theme_mod('ahura_shop_show_product_stock_status_background');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_show_product_stock_status_color')):?>
    body.woocommerce .mw_product_item .out-of-stock{
  color: <?php echo get_theme_mod('ahura_shop_show_product_stock_status_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_show_product_stock_status_fontsize')):?>
    body.woocommerce .mw_product_item .out-of-stock{
  font-size: <?php echo get_theme_mod('ahura_shop_show_product_stock_status_fontsize');?>px;
}
<?php endif;?>

<?php if (get_theme_mod('ahura_shop_product_stock_count_background')):?>
    .woocommerce .mw_product_item .stock.in-stock {
        background-color: <?php echo get_theme_mod('ahura_shop_product_stock_count_background');?>;
    }
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_product_stock_count_color')):?>
    .woocommerce .mw_product_item .stock.in-stock{
        color: <?php echo get_theme_mod('ahura_shop_product_stock_count_color');?>;
    }
<?php endif;?>

<?php if (get_theme_mod('ahura_legend_ctatext_color')):?>
.footer-legend-inner a{
  color: <?php echo get_theme_mod('ahura_legend_ctatext_color');?>
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_alert_background')):?>
.woocommerce-store-notice, p.demo_store{
  background-color: <?php echo get_theme_mod('ahura_shop_alert_background');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_alert_color')):?>
.woocommerce-store-notice,p.demo_store,.woocommerce-store-notice__dismiss-link{
  color: <?php echo get_theme_mod('ahura_shop_alert_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_shop_alert_fontsize')):?>
.woocommerce-store-notice,p.demo_store,.woocommerce-store-notice__dismiss-link{
  font-size: <?php echo get_theme_mod('ahura_shop_alert_fontsize');?>px;
}
<?php endif;?>
<?php if (get_theme_mod('post_title_color')):?>
.post-index article h3{
  color: <?php echo get_theme_mod('post_title_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_title_font_size')):?>
.post-index article h3{
  font-size: <?php echo get_theme_mod('post_title_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('post_title_font_family')):
    $ff = get_theme_mod('post_title_font_family');
    $default_pt_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.post-index article h3{
  font-family: <?php echo $default_pt_font;?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('post_title_font_weight')):?>
.post-index article h3,
body .post-index article h3{
  font-weight: <?php echo get_theme_mod('post_title_font_weight');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_description_color')):?>
.post-index article .excerpt p{
  color: <?php echo get_theme_mod('post_description_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_description_font_size')):?>
.post-index article .excerpt p{
  font-size: <?php echo get_theme_mod('post_description_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('post_description_font_family')):
    $ff = get_theme_mod('post_description_font_family');
    $default_pd_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.post-index article .excerpt p{
  font-family: <?php echo $default_pd_font; ?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('post_description_font_weight')):?>
.post-index article .excerpt p{
  font-weight: <?php echo get_theme_mod('post_description_font_weight');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_author_color')):?>
.post-index article .meta .post-author{
  color: <?php echo get_theme_mod('post_author_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_author_font_size')):?>
.post-index article .meta .post-author{
  font-size: <?php echo get_theme_mod('post_author_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('post_author_font_family')):
    $ff = get_theme_mod('post_author_font_family');
    $default_pau_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.post-index article .meta .post-author{
  font-family: <?php echo $default_pau_font;?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('post_author_font_weight')):?>
.post-index article .meta .post-author{
  font-weight: <?php echo get_theme_mod('post_author_font_weight');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_time_color')):?>
.post-index article .meta .post-meta{
  color: <?php echo get_theme_mod('post_time_color');?>;
}
<?php endif;?>
<?php if (get_theme_mod('post_time_font_size')):?>
.post-index article .meta .post-meta{
  font-size: <?php echo get_theme_mod('post_time_font_size');?>px;
}
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('post_time_font_family')):
    $ff = get_theme_mod('post_time_font_family');
    $default_pti_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
.post-index article .meta .post-meta{
  font-family: <?php echo $default_pti_font ?>;
}
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('post_time_font_weight')):?>
.post-index article .meta .post-meta{
  font-weight: <?php echo get_theme_mod('post_time_font_weight');?>;
}
<?php endif;?>
<?php if (get_theme_mod('ahura_header_top_border_height')):?>
.topbar:not(.in_custom_header){
  border-top-width: <?php echo get_theme_mod('ahura_header_top_border_height');?>px;
}
<?php endif;?>

<?php if (!get_theme_mod('post-meta-author') && !get_theme_mod('post-meta-time')):?>
.postbox4 .excerpt.has_margin {
	margin-bottom: 0px;
}
<?php endif;?>

<?php if (get_theme_mod('cat_box_desc') === true):?>
  .postbox4 article h3 {
    padding-bottom: 0;
    border-bottom: 0px;
  }
<?php else: ?>
  .postbox4 article h3{
    padding-bottom:15px;
    border-bottom:1px solid #eee;
  }
<?php endif; ?>
<?php if (mw_options::get_mod_is_active_searhc_box() && $search_icon_color = get_theme_mod('ahura_search_icon_color')): ?>
  .ahura-main-header .action-box .search-btn-wrapper #action_search,
  .header-template-2 .header-search-form button
  {
    color: <?php echo $search_icon_color?>;
  }
<?php endif; ?>
<?php if (mw_options::get_mod_is_active_mini_cart() && $mini_cart_icon_color = get_theme_mod('ahura_mini_cart_icon_color')): ?>
  .ahura-main-header .action-box .mini-cart-header #mcart-stotal,
  .header-template-2 .header-buttons .h-shop-basket-btn
  {
    color: <?php echo $mini_cart_icon_color;?>;
  }
<?php endif; ?>
<?php if (mw_options::get_mod_is_active_mini_cart() && get_theme_mod('ahura_mini_cart_icon_bgcolor')): ?>
  .ahura-main-header .action-box .mini-cart-header #mcart-stotal
  {
    background-color: <?php echo get_theme_mod('ahura_mini_cart_icon_bgcolor');?>;
    display: inline-block;
    height: 35px;
    width: 35px;
    padding-top: 1px;
    text-align: center;
    border-radius: 5px;
    transform: translate(7px, -5px);
  }
    .header-template-2 .header-buttons .h-shop-basket-btn {
        background-color: <?php echo get_theme_mod('ahura_mini_cart_icon_bgcolor');?>;
    }
<?php endif; ?>
<?php if (get_theme_mod('ajax_search_background_opacity')): ?>
    .ahura-modal-search {
    background-color: rgba(0,0,0,<?php echo get_theme_mod('ajax_search_background_opacity') ? get_theme_mod('ajax_search_background_opacity')/100 : 80; ?>);
  }
<?php endif; ?>
<?php if (get_theme_mod('ajax_search_font_size')): ?>
    .ahura-modal-search form input, .ahura-modal-search form.search-form input, .header-template-2 .header-search-form input {
    font-size: <?php echo get_theme_mod('ajax_search_font_size') . 'px'; ?>;
  }
<?php endif; ?>
<?php if (get_theme_mod('ajax_seach_font_color')): ?>
    .ahura-modal-search #ajax_search_res a,
    .ahura-modal-search form .close,
    .ahura-modal-search form input,
    .ahura-modal-search form.search-form input,
    .search-form #ajax_search_res p,
    .header-template-2 .header-search-form input {
    color: <?php echo get_theme_mod('ajax_seach_font_color'); ?>;
  }
<?php endif; ?>
<?php if (get_theme_mod('ajax_search_result_font_size')): ?>
    .ahura-modal-search #ajax_search_res a,
    .search-form #ajax_search_res p {
    font-size: <?php echo get_theme_mod('ajax_search_result_font_size') . 'px'; ?>;
  }
<?php endif; ?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_single_post_author_font_family')):
    $ff = get_theme_mod('ahura_single_post_author_font_family');
    $default_spau_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-author-name {
    font-family: <?php echo $default_spau_font;?>;
    }
<?php endif;?>
    <?php if( !get_theme_mod( 'single_post_author_font_weight' ) ): ?>
        .ahura-post-single .post-meta .post-author-name {
        font-weight: <?php echo get_theme_mod('single_post_author_font_weight') ?>;
        }
    <?php endif;?>
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_en_single_post_author_font_family')):
    $ff = get_theme_mod('ahura_en_single_post_author_font_family');
    $default_en_spau_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-author-name {
    font-family: <?php echo $default_en_spau_font;?>;
    }
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('single_post_author_name_font_size')):?>
    .ahura-post-single .post-meta .post-author-name {
    font-size: <?php echo get_theme_mod('single_post_author_name_font_size');?>px;
    }
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_single_post_cats_font_family')):
    $ff = get_theme_mod('ahura_single_post_cats_font_family');
    $default_spc_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-cats,
    .ahura-post-single .post-meta .post-cats span,
    .ahura-post-single .post-meta .post-cats ul li,
    .ahura-post-single .post-meta .post-cats ul li a {
    font-family: <?php echo $default_spc_font;?>;
    }
<?php endif;?>
    <?php if (get_theme_mod('single_post_cats_font_weight')):?>
        .ahura-post-single .post-meta .post-cats,
        .ahura-post-single .post-meta .post-cats span,
        .ahura-post-single .post-meta .post-cats ul li,
        .ahura-post-single .post-meta .post-cats ul li a {
        font-weight: <?php echo get_theme_mod('single_post_cats_font_weight') ?>;
        }
    <?php endif;?>
<?php if (get_theme_mod('ahura_en_single_post_cats_font_family')):
    $ff = get_theme_mod('ahura_en_single_post_cats_font_family');
    $default_en_spc_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-cats,
    .ahura-post-single .post-meta .post-cats span,
    .ahura-post-single .post-meta .post-cats ul li,
    .ahura-post-single .post-meta .post-cats ul li a {
    font-family: <?php echo $default_en_spc_font;?>;
    }
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('single_post_cats_font_size')):?>
    .ahura-post-single .post-meta .post-cats,
    .ahura-post-single .post-meta .post-cats span,
    .ahura-post-single .post-meta .post-cats ul li,
    .ahura-post-single .post-meta .post-cats ul li a {
    font-size: <?php echo get_theme_mod('single_post_cats_font_size');?>px;
    }
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_single_post_date_font_family')):
    $ff = get_theme_mod('ahura_single_post_date_font_family');
    $default_spcd_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-date,
    .ahura-post-single .post-meta .post-modified-date {
    font-family: <?php echo $default_spcd_font;?>;
    }
<?php endif;?>
    <?php if (get_theme_mod('single_post_date_font_weight')):?>
        .ahura-post-single .post-meta .post-date,
        .ahura-post-single .post-meta .post-modified-date {
        font-weight: <?php echo get_theme_mod('single_post_date_font_weight') ?>;
        }
    <?php endif;?>
<?php if (get_theme_mod('ahura_en_single_post_date_font_family')):
    $ff = get_theme_mod('ahura_en_single_post_date_font_family');
    $default_en_spcd_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-date,
    .ahura-post-single .post-meta .post-modified-date {
    font-family: <?php echo $default_en_spcd_font;?>;
    }
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('single_post_date_font_size')):?>
    .ahura-post-single .post-meta .post-date,
    .ahura-post-single .post-meta .post-modified-date {
    font-size: <?php echo get_theme_mod('single_post_date_font_size');?>px;
    }
<?php endif;?>
<?php if( !get_theme_mod( 'ahura_disable_theme_font' ) ): ?>
<?php if (get_theme_mod('ahura_single_post_comment_count_font_family')):
    $ff = get_theme_mod('ahura_single_post_comment_count_font_family');
    $default_spcc_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-comment-count {
    font-family: <?php echo $default_spcc_font;?>;
    }
<?php endif;?>
    <?php if (get_theme_mod('single_post_comment_count_font_weight')):?>
        .ahura-post-single .post-meta .post-comment-count {
        font-weight: <?php echo get_theme_mod('single_post_comment_count_font_weight') ?>;
        }
    <?php endif;?>
<?php if (get_theme_mod('ahura_en_single_post_comment_count_font_family')):
    $ff = get_theme_mod('ahura_en_single_post_comment_count_font_family');
    $default_en_spcc_font = (!empty($ff) && $ff != 'default_font') ? $ff : $default_font_family;
    ?>
    .ahura-post-single .post-meta .post-comment-count {
    font-family: <?php echo $default_en_spcc_font;?>;
    }
<?php endif;?>
<?php endif;?>
<?php if (get_theme_mod('single_post_comment_count_font_size')):?>
    .ahura-post-single .post-meta .post-comment-count {
    font-size: <?php echo get_theme_mod('single_post_comment_count_font_size');?>px;
    }
<?php endif;?>
<?php if(get_theme_mod('move_buy_button')):?>
  .mw_product_item .mw_add_to_cart,
  body.woocommerce ul li.product.mw_product_item .button.mw_add_to_cart,
    .mw_product_item.product-style-1 .mw_add_to_cart,
    body.woocommerce ul li.product.mw_product_item.product-style-1 .button.mw_add_to_cart{
    position: relative;
    top: auto;
    right: auto;
    display: block;
    margin: 0 auto 20px auto;
  }
<?php endif;?>
<?php if(get_theme_mod('relatedposts_img_height')):?>
  .related-posts .postbox1posts article.grid-post {
    height: <?php echo get_theme_mod('relatedposts_img_height');?>px;
  }
<?php endif;?>

<?php if(get_theme_mod('relatedposts_img_darkness')):?>
  .related-posts .postbox1posts article.grid-post a {
    background-color: rgba(0,0,0,<?php echo get_theme_mod('relatedposts_img_darkness')/100;?>);
  }
<?php endif;?>

<?php
for($i=1; $i<=6; $i++):
  if (get_theme_mod("ahura_h{$i}_font_weight")): ?>
h<?php echo $i; ?>,
body h<?php echo $i; ?>,
h<?php echo $i; ?> *,
body h<?php echo $i; ?> *{
  font-weight:<?php echo get_theme_mod("ahura_h{$i}_font_weight") ?>;
}
<?php
  endif;
endfor;
?>

<?php
for($i=1; $i<=6; $i++):
  if (get_theme_mod("ahura_post_content_h{$i}_font_weight")): ?>
.ahura-post-single .post-entry h<?php echo $i; ?>,
body .ahura-post-single .post-entry h<?php echo $i; ?>,
.ahura-post-single .post-entry h<?php echo $i; ?> *,
body .ahura-post-single .post-entry h<?php echo $i; ?> *{
  font-weight:<?php echo get_theme_mod("ahura_post_content_h{$i}_font_weight") ?>;
}
<?php
  endif;
endfor;
?>
<?php if(get_theme_mod('ahura_post_quote')):?>
  .post-entry blockquote {
    flex-direction: <?php echo get_theme_mod('ahura_post_quote');?>
  }
<?php endif;?>

.woocommerce .woocommerce_product_date_modified {
  display: flex;
}

.woocommerce .woocommerce_product_date_modified span:first-child {
  color: <?php echo get_theme_mod('ahura_woo_modified_title_date_color'); ?>;
  padding-left: 5px;
}

.woocommerce .woocommerce_product_date_modified span:last-child {
  color: <?php echo get_theme_mod('ahura_woo_modified_date_color'); ?>
}

<?php if( get_theme_mod( 'ahura_show_user_loggedin_name' ) ): ?>
  .ahura_user_displayname {
    color: <?php echo get_theme_mod( 'ahura_user_loggedin_name_color' ); ?>;
    background-color: <?php echo get_theme_mod( 'ahura_user_loggedin_name_backcolor' ); ?>;
  }
    .header-template-2 .header-buttons .h-user-login-btn.with-name span {
    color: <?php echo get_theme_mod( 'ahura_user_loggedin_name_color' ); ?>;
    }
<?php endif;?>

<?php if( get_theme_mod( 'show_update_date' ) ): ?>
  .ahura-post-single .post-meta .post-modified-date {
    color: <?php echo get_theme_mod( 'post_update_date_text_color' ); ?>!important;
    background-color: <?php echo get_theme_mod( 'post_update_date_text_backcolor' ); ?>!important;
    padding: 2px 5px;
    border-radius: 5px;
  }
<?php endif;?>
<?php if( get_theme_mod( 'ahura_switch_sidebar_order_mobile' ) ): ?>
  @media only screen and (max-width: 1000px) {
    .site-container.ahura-post-single .wrapper {
      display: flex;
      flex-direction: column-reverse;
    }
  }
<?php endif;?>
<?php 
if(get_theme_mod('ahura_archive_post_thumbnail_width')):
  $width = get_theme_mod('ahura_archive_post_thumbnail_width');
 ?>
.archive .postbox4 article .fimage img{
  width: <?php echo ctype_digit($width) ? $width . 'px' : $width; ?>;
}
<?php endif;?>

<?php 
if(get_theme_mod('ahura_archive_post_thumbnail_height')):
  $height = get_theme_mod('ahura_archive_post_thumbnail_height');
 ?>
.archive .postbox4 article .fimage img{
  height: <?php echo ctype_digit($height) ? $height . 'px' : $height; ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_mobile_menu_button_color')): ?>
#topbar .topbar-main .menu-icon,
.header-template-2 .header-side-menu-btn {
  color: <?php echo get_theme_mod('ahura_mobile_menu_button_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_like_box_bg_color')): ?>
.post-box .ahura-post-like {
  background-color: <?php echo get_theme_mod('ahura_post_like_box_bg_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_like_box_title_color')): ?>
.post-box .ahura-post-like .post-like-title {
  color: <?php echo get_theme_mod('ahura_post_like_box_title_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_like_button_color')): ?>
.post-box .post-like-buttons .btn-post-like {
  background-color: <?php echo get_theme_mod('ahura_post_like_button_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_dislike_button_color')): ?>
.post-box .post-like-buttons .btn-post-dislike {
  background-color: <?php echo get_theme_mod('ahura_post_dislike_button_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_like_button_text_color')): ?>
.post-box .post-like-buttons .btn-post-like .btn-title {
  color: <?php echo get_theme_mod('ahura_post_like_button_text_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_post_dislike_button_text_color')): ?>
.post-box .post-like-buttons .btn-post-dislike .btn-title {
  color: <?php echo get_theme_mod('ahura_post_dislike_button_text_color'); ?>;
}
<?php endif;?>

<?php if( get_theme_mod( 'ahura_hidden_mobile_sidebar' ) ): ?>
  <?php if( get_theme_mod( 'ahura_hidden_post_mobile_sidebar' ) ): ?>
    <?php if( !\ahura\app\woocommerce::is_woocommerce_page() ): ?>
      @media screen and (max-width: 1000px) {
        .sidebar, .ahura-sidebar {
          display: none;
        }
      }
    <?php endif; ?>
  <?php endif;?>
  <?php if( get_theme_mod( 'ahura_hidden_shop_mobile_sidebar' ) ): ?>
    <?php if( \ahura\app\woocommerce::is_woocommerce_page() ): ?>
      @media screen and (max-width: 1000px) {
        .sidebar, .ahura-sidebar {
          display: none;
        }
      }
    <?php endif; ?>
  <?php endif;?>
<?php endif;?>

<?php if(get_theme_mod('ahura_related_portfolios_text_color')): ?>
.ahura-portfolio-single-wrap .ahura-single-portfolio .portfolio-related .related-content .related-title, 
.ahura-portfolio-single-wrap .ahura-single-portfolio .portfolio-related .related-cats span {
  color: <?php echo get_theme_mod('ahura_related_portfolios_text_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_related_portfolios_bg_color')): ?>
.ahura-portfolio-single-wrap .ahura-single-portfolio .portfolio-related:before {
  background-color: <?php echo get_theme_mod('ahura_related_portfolios_bg_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_portfolio_archive_cover_bg_color')): ?>
.ahura-portfolio-archive .portfolio-archive-items .portfolio-cover-hover:before {
  background-color: <?php echo get_theme_mod('ahura_portfolio_archive_cover_bg_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_portfolio_archive_cover_text_color')): ?>
.ahura-portfolio-archive .portfolio-archive-items .portfolio-cover-hover .portfolio-btn-text {
  color: <?php echo get_theme_mod('ahura_portfolio_archive_cover_text_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_portfolio_archive_cover_height')): ?>
.ahura-portfolio-archive-wrap .ahura-portfolio-archive .portfolio-archive-items .portfolio-cover img {
  height: <?php echo get_theme_mod('ahura_portfolio_archive_cover_height'); ?>px;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_portfolio_archive_title_color')): ?>
.ahura-portfolio-archive-wrap .ahura-portfolio-archive .page-title-wrap h1 {
  color: <?php echo get_theme_mod('ahura_portfolio_archive_title_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_portfolio_archive_portfolio_title_color')): ?>
.ahura-portfolio-archive-wrap .ahura-portfolio-archive .portfolio-archive-items .portfolio-title {
  color: <?php echo get_theme_mod('ahura_portfolio_archive_portfolio_title_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_mini_cart_checkout_btn_color')): ?>
.woocommerce-mini-cart__buttons a.button.checkout, body.woocommerce .woocommerce-mini-cart__buttons a.button.checkout {
    border-color: <?php echo get_theme_mod('ahura_mini_cart_checkout_btn_color'); ?>;
    background: <?php echo get_theme_mod('ahura_mini_cart_checkout_btn_color'); ?>;
    color: <?php echo get_theme_mod('ahura_mini_cart_checkout_btn_text_color'); ?>;
    box-shadow: 0 0 15px <?php echo get_theme_mod('ahura_mini_cart_checkout_btn_color'); ?>50;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_mini_cart_basket_btn_color')): ?>
.woocommerce-mini-cart__buttons a.button, body.woocommerce .woocommerce-mini-cart__buttons a.button {
    border: 2px solid <?php echo get_theme_mod('ahura_mini_cart_basket_btn_color'); ?>;
    color: <?php echo get_theme_mod('ahura_mini_cart_basket_btn_text_color'); ?>;
    box-shadow: 0 0 15px <?php echo get_theme_mod('ahura_mini_cart_basket_btn_color'); ?>50;
    background-color: <?php echo get_theme_mod('ahura_mini_cart_basket_btn_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_show_first_btn_sticky')): ?>
.ahura-sticky-button.ahura-first-sticky-button {
    background-color: <?php echo get_theme_mod('ahura_first_btn_sticky_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_show_sec_btn_sticky')): ?>
.ahura-sticky-button.ahura-second-sticky-button {
    background-color: <?php echo get_theme_mod('ahura_sec_btn_sticky_color'); ?>;
}
<?php endif;?>

<?php if(get_theme_mod('ahura_product_cover_hover_color')): ?>
    body.woocommerce .mw_product_item .mw_overly,
    .woocommerce .mw_product_item.product-style-1 .mw_overly {
        background-color: <?php echo get_theme_mod('ahura_product_cover_hover_color'); ?>;
    }
    .woocommerce .mw_product_item.product-style-1:hover {
        box-shadow: 0 0 25px 0px <?php echo get_theme_mod('ahura_product_cover_hover_color'); ?>;
    }
<?php endif;?>

<?php if(get_theme_mod('ahura_shop_page_description_color')): ?>
    body.woocommerce .page-description,
    body.woocommerce .page-description p {
        color: <?php echo get_theme_mod('ahura_shop_page_description_color'); ?>;
    }
<?php endif;?>

<?php if(get_theme_mod('ahura_logo_text_color')): ?>
    .logo .logo-text {
        color: <?php echo get_theme_mod('ahura_logo_text_color'); ?>;
    }
<?php endif;?>

<?php if(get_theme_mod('ahura_logo_text_font_size')): ?>
    .logo .logo-text {
    font-size: <?php echo get_theme_mod('ahura_logo_text_font_size'); ?>px;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_shop_page_product_title_color')): ?>
.woocommerce ul.products li.product .woocommerce-loop-category__title,
.woocommerce ul.products li.product .woocommerce-loop-product__title,
.woocommerce ul.products li.product h3 {
color: <?php echo get_theme_mod('ahura_shop_page_product_title_color'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('move_buy_button')): ?>
body.woocommerce .post-box ul.products li.product.mw_product_item:hover .woo-shop-product-after-loop-item a.button.mw_add_to_cart,
.product.mw_product_item:hover .mw_add_to_cart,
body.woocommerce ul li.product.mw_product_item:hover .button.mw_add_to_cart{
display: block;
opacity:1;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_shop_text_call_for_price_inquery_color')): ?>
.woocommerce .price_on_inquiry span {
color: <?php echo get_theme_mod('ahura_shop_text_call_for_price_inquery_color'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_header_cta_btn_text_color')): ?>
.header-template-2 .header-buttons > a.h-btn,
.header-template-1 .action-box #action_link,
div.header-mode-2 .action-box #action_link {
    color: <?php echo get_theme_mod('ahura_header_cta_btn_text_color'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_header_cta_btn_bg')): ?>
.header-template-2 .header-buttons > a.h-btn,
.header-template-1 .action-box #action_link,
div.header-mode-2 .action-box #action_link {
    background-color: <?php echo get_theme_mod('ahura_header_cta_btn_bg'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_header_after_login_cta_btn_text_color')): ?>
.header-template-2 .header-buttons > a.h-btn.after-login-btn,
.header-template-1 .action-box #action_link.after-login-btn {
    color: <?php echo get_theme_mod('ahura_header_after_login_cta_btn_text_color'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_header_after_login_cta_btn_bg')): ?>
.header-template-2 .header-buttons > a.h-btn.after-login-btn,
.header-template-1 .action-box #action_link.after-login-btn {
    background-color: <?php echo get_theme_mod('ahura_header_after_login_cta_btn_bg'); ?>;
}
<?php endif;?>
<?php if(get_theme_mod('ahura_alert_box_text_color')): ?>
    .header-template-2 .header-notice-text > p {
    color: <?php echo get_theme_mod('ahura_alert_box_text_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_alert_box_bg_color')): ?>
    .header-template-2 .header-notice-box {
    background-color: <?php echo get_theme_mod('ahura_alert_box_bg_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_alert_btn_text_color')): ?>
    .header-template-2 .header-notice-content a {
    color: <?php echo get_theme_mod('ahura_alert_btn_text_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_alert_btn_bg_color')): ?>
    .header-template-2 .header-notice-content a {
    background-color: <?php echo get_theme_mod('ahura_alert_btn_bg_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_shop_filters_toggle_button_color')): ?>
    .woocommerce .shop-page-sidebar-toggle {
    color: <?php echo get_theme_mod('ahura_shop_filters_toggle_button_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_shop_filters_toggle_button_bg_color')): ?>
    .woocommerce .shop-page-sidebar-toggle {
    background-color: <?php echo get_theme_mod('ahura_shop_filters_toggle_button_bg_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_product_buy_button_text_color')): ?>
    .woocommerce div.product form.cart button.single_add_to_cart_button {
    color: <?php echo get_theme_mod('ahura_product_buy_button_text_color'); ?>;
    }
<?php endif;?>
<?php if(get_theme_mod('ahura_product_buy_button_bg_color')): ?>
    .woocommerce div.product form.cart button.single_add_to_cart_button {
    background-color: <?php echo get_theme_mod('ahura_product_buy_button_bg_color'); ?>;
    }
<?php endif;?>

<?php if( get_theme_mod( 'woocommerce_checkout_order_comments' ) == 'hidden' ): ?>
  #customer_details > .col-2 {
    display: none;
  }
  #customer_details > .col-1 {
    width: 100%;
  }
<?php endif; ?>

<?php if( get_theme_mod( 'ahura_checkout_columns' ) && get_theme_mod( 'woocommerce_checkout_order_comments' ) == 'hidden' ): ?>
  @media only screen and (min-width: 768px) {
    .checkout.woocommerce-checkout {
      display: flex;
    }
    #order_review_heading, .woocommerce-billing-fields h3 {
      display: none;
    }
    #order_review {
      margin-top: 60px;
    }
  }
<?php endif; ?>

<?php if(function_exists('is_product') && is_product() && get_theme_mod( 'ahura_sticky_addtocart_status' ) ): ?>
  @media only screen and (min-width: 576px) {
    .ahura-sticky-basket-area {
      display: none;
    }
  }
  @media only screen and (max-width: 575.99px) {
    .ahura-sticky-basket-area {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        display: flex;
        flex-direction: column;
        padding: 10px 20px;
        z-index: 99999;
        box-shadow: 0 0 10px rgba(0,0,0,0.2);
        background-color: #ffffff;
      }
      .ahura-sticky-basket-body:not(.has_child):not(.is_on_sale) p.add_to_cart_inline {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .ahura-sticky-basket-body.is_on_sale {
        margin-top: 10px;
      }
      .ahura-sticky-basket-body.is_on_sale p.add_to_cart_inline {
        display: block
      }
      .ahura-sticky-basket-body.is_on_sale p.add_to_cart_inline a {
        width: 100%;
        margin-top: 10px;
      }
      .ahura-sticky-basket-body p.add_to_cart_inline .woocommerce-Price-amount.amount {
        font-size: 1.2rem;
        font-weight: bold;
      }
      .ahura-sticky-basket-body p.add_to_cart_inline a,
      .ahura-sticky-basket-area .ahura-sticky-basket-notfound a {
        width: 50%;
        height: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.2rem;
        border-radius: 10px;
      }
      .ahura-sticky-basket-area .ahura-sticky-basket-notfound {
        margin-top: 10px;
      }
      .ahura-sticky-basket-area .ahura-sticky-basket-notfound a {
        width: 100%;
        pointer-events: none;
        background-color: #aaa;
      }
      #goto-top {
        bottom: 200px;
      }
      .ahura-sticky-basket-body.has_child table.variations {
        border: none;
        padding: 0;
        margin-top: 10px;
      }
      .ahura-sticky-basket-body.has_child table.variations td,
      .ahura-sticky-basket-body.has_child table.variations th {
        padding: 0;
      }
      .ahura-sticky-basket-body.has_child table.variations th {
        padding-left: 10px;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap {
        margin-top: 10px;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap button[type='submit'] {
        height: 55px;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap .quantity {
        display: flex;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap .quantity .mw_qty_btn {
        border: 1px solid #333;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap .quantity input {
        font-size: 1rem;
      }
      .ahura-sticky-basket-body.has_child .single_variation_wrap .woocommerce-variation-add-to-cart {
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
    }
<?php endif; ?>

<?php if( get_theme_mod( 'ahura_megamenu_menu_height_status' ) ): ?>
  .ahura-main-header .bottom-section .cats-list ul.menu {
    max-height: <?php echo get_theme_mod( 'ahura_megamenu_menu_height' ); ?>px;
    overflow: hidden;
    overflow-y: auto;
  }
<?php endif; ?>

<?php if( get_theme_mod( 'ahura_shop_orderby_status' ) ): ?>
  form.woocommerce-ordering .orderby-list-area {
    display: flex;
    align-items: center;
  }
  form.woocommerce-ordering ul.orderby-dropdown-list {
    display: flex;
  }
  form.woocommerce-ordering ul li {
    margin: 0 5px;
    <?php if(get_theme_mod( 'ahura_shop_orderby_color' )): ?>
    color: <?php echo get_theme_mod( 'ahura_shop_orderby_color' ); ?>;
    <?php endif; ?>
    <?php if(get_theme_mod( 'ahura_shop_orderby_backcolor' )): ?>
    background-color: <?php echo get_theme_mod( 'ahura_shop_orderby_backcolor' ); ?>;
    <?php endif; ?>
    padding: 0 7px;
    border-radius: 5px;
  }
  form.woocommerce-ordering ul li:last-child {
    margin: 0;
  }
<?php endif; ?>

<?php if(get_theme_mod( 'ahura_show_productimg_rescart' )): ?>
@media only screen and (max-width: 575.99px) {
  .woocommerce table.cart .product-thumbnail,
  .woocommerce-page table.cart .product-thumbnail {
      display: block;
  }

  .woocommerce table.cart .product-thumbnail a,
  .woocommerce-page table.cart .product-thumbnail a {
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .woocommerce table.cart .product-thumbnail a img,
  .woocommerce-page table.cart .product-thumbnail a img {
      width: 100%
  }

  .woocommerce table.shop_table_responsive tr td::before,
  .woocommerce-page table.shop_table_responsive tr td::before {
      content: '';
  }
}
<?php endif; ?>
<?php if(get_theme_mod('ah_footer_information_box_bg_color')): ?>
    .footer-template-2 .foot-contact-box {
        background-color: <?php echo get_theme_mod('ah_footer_information_box_bg_color') ?>
    }
<?php endif; ?>
<?php if(get_theme_mod('ah_footer_information_box_text_color')): ?>
    .footer-template-2 .foot-contact-box {
        color: <?php echo get_theme_mod('ah_footer_information_box_text_color') ?>
    }
<?php endif; ?>
<?php if(get_theme_mod('topmenu_dropdown_list_topmargin', 35)): ?>
  .topmenu > li > ul.sub-menu {
    top: <?php echo get_theme_mod('topmenu_dropdown_list_topmargin', 35); ?>px;
  }
<?php endif; ?>