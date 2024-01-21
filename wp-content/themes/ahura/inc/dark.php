<?php
// Block direct access to the main plugin file.
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$theme_color = \ahura\app\mw_options::get_mod_theme_color();
if ( get_theme_mod( 'theme_dark' ) ) :
?>
<style type="text/css" id="ahura-dark-mode-styles">
html:is(.ahura-dark-theme, .ahura-black-theme) body {
  background-color: var(--ahura-c-bg-primary);
  color:var(--ahura-c-text-primary);
}
body .logo img {
  display: block;
}
body .logo .ahura-dark-mode-logo,
html:is(.ahura-dark-theme, .ahura-black-theme) .logo img,
html:is(.ahura-dark-theme, .ahura-black-theme) .logo img:not(.ahura-dark-mode-logo) {
    display: none;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar .logo img.ahura-dark-mode-logo {
    display: block;
}
html:is(.ahura-dark-theme, .ahura-black-theme) body, 
html:is(.ahura-dark-theme, .ahura-black-theme) a, 
html:is(.ahura-dark-theme, .ahura-black-theme) p, 
html:is(.ahura-dark-theme, .ahura-black-theme) li, 
html:is(.ahura-dark-theme, .ahura-black-theme) ul, 
html:is(.ahura-dark-theme, .ahura-black-theme) input, 
html:is(.ahura-dark-theme, .ahura-black-theme) form, 
html:is(.ahura-dark-theme, .ahura-black-theme) span,
html:is(.ahura-dark-theme, .ahura-black-theme) .sharing,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2post2 h4,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2post1 h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-item p, 
html:is(.ahura-dark-theme, .ahura-black-theme) strong{
  color:var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) #topbar .fa {
	color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) #ajax_search_res p
{
  color: var(--ahura-c-text-secondary);
}
:root
{
  --main_soft_shadow: 0 10px 20px -10px #00000024;
  --auto_soft_shadow: 0 10px 20px -10px #000;
}
html:is(.ahura-dark-theme) html,
html:is(.ahura-dark-theme) body,
html:is(.ahura-dark-theme, .ahura-black-theme) .ah-quick-product .mw_term_data .mw_term_item {
  background:#333;
  color:#fff;
}
html:is(.ahura-dark-theme, .ahura-black-theme) body,
html:is(.ahura-dark-theme, .ahura-black-theme) a,
html:is(.ahura-dark-theme, .ahura-black-theme) p,
html:is(.ahura-dark-theme, .ahura-black-theme) li,
html:is(.ahura-dark-theme, .ahura-black-theme) ul,
html:is(.ahura-dark-theme, .ahura-black-theme) input,
html:is(.ahura-dark-theme, .ahura-black-theme) form,
html:is(.ahura-dark-theme, .ahura-black-theme) span,
html:is(.ahura-dark-theme, .ahura-black-theme) .sharing,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2post2 h4,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2post1 h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-item p,
html:is(.ahura-dark-theme, .ahura-black-theme) strong,
html:is(.ahura-dark-theme, .ahura-black-theme) #topbar .fa {
  color:#fff;
}
html:is(.ahura-dark-theme, .ahura-black-theme) ul.menu li ul li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-main-header .bottom-section .cats-list ul.menu a
{
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topmenu li:hover > a,
html:is(.ahura-dark-theme, .ahura-black-theme) form label,
html:is(.ahura-dark-theme, .ahura-black-theme) form label span,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-popup-login-form form.woocommerce-form .form-row label,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-popup-login-form form.woocommerce-form .form-row label span
{
  color: var(--ahura-c-text-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .cats-list .menu
{
  background-color: var(--ahura-c-bg-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommercediv.product,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-main-header .bottom-section .cats-list ul.menu, 
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-main-header .bottom-section .cats-list ul.menu ul,
html:is(.ahura-dark-theme, .ahura-black-theme) .modal,
html:is(.ahura-dark-theme, .ahura-black-theme) form.woocommerce-ordering ul li,
html:is(.ahura-dark-theme, .ahura-black-theme) .product-page-digikala-container .ahura_woocommerce_content_wrapper,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce:not([class*="elementor-page"]) .product-page-digikala-container div.product,
html:is(.ahura-dark-theme, .ahura-black-theme) .product-page-digi-style .product-page-box,
html:is(.ahura-dark-theme, .ahura-black-theme) div.product.product-page-digi-style div.woocommerce-tabs .wc-tabs.tabs
{
  background-color: var(--ahura-c-bg-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .quantity:not(.hidden),
body.woocommerce:not(.single) div.product,
body.woocommerce:not([class*="elementor-page"], .single) div.product
{
  background-color: var(--ahura-c-bg-secondary);
  border-color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce button.button,
html:is(.ahura-dark-theme, .ahura-black-theme) form.woocommerce-ordering ul li
{
  color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce button.button:hover {
  background-color: var(--ahura-c-bg-primary);
}
.woocommerce #mcart-widget .quantity:not(.hidden),
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce:not([class*="elementor-template"]) .comment-form-rating .stars > span {
    background-color: transparent;
}
.woocommerce button.button,
html:is(.ahura-dark-theme, .ahura-black-theme) .product.outofstock .mw_add_to_cart span
{
  color: #1d1d1d;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-cart table.cart td.actions .coupon .input-text,
html:is(.ahura-dark-theme, .ahura-black-theme) .ah-quick-product .ah-gallery-images img
{
  border-color: var(--ahura-c-border-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-error, html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-info, html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-message
{
  background-color: var(--ahura-c-bg-secondary);
  color: var(--ahura-c-text-secondary);
  border-top-color: <?php echo $theme_color;?>;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-message::before
{
  color: <?php echo $theme_color;?>;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerceul.products
{
  background-color: transparent;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce ul.products li.product, html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-page ul.products li.product
{
  background-color: var(--ahura-c-bg-secondary);
  border-color: var(--ahura-c-border-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar-main .mini-cart-header-content
{
  background-color: var(--ahura-c-bg-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .list-post,
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar:not(.ahura_transparent),
html:is(.ahura-dark-theme, .ahura-black-theme) #topbar:not(.ahura_transparent),
html:is(.ahura-dark-theme, .ahura-black-theme) #topbar:not(.ahura_transparent) .bottom-section,
html:is(.ahura-dark-theme, .ahura-black-theme) .main-menu ul,
html:is(.ahura-dark-theme, .ahura-black-theme) .main-menu li ul li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox2,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox4 article,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-item,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox6,
html:is(.ahura-dark-theme, .ahura-black-theme) .post-entry,
html:is(.ahura-dark-theme, .ahura-black-theme) .sidebar-widget,
html:is(.ahura-dark-theme, .ahura-black-theme) input, 
html:is(.ahura-dark-theme, .ahura-black-theme) textarea,
html:is(.ahura-dark-theme, .ahura-black-theme) select,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-ordering .orderby,
html:is(.ahura-dark-theme, .ahura-black-theme) .website-footer,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce div.product{
  background:var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) textarea, 
html:is(.ahura-dark-theme, .ahura-black-theme) select,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-ordering .orderby,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce table.shop_attributes td, 
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce table.shop_attributes th,
html:is(.ahura-dark-theme, .ahura-black-theme) .website-footer .footer-widget *,
html:is(.ahura-dark-theme, .ahura-black-theme) .website-footer .footer-widget-title {
	color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .main-menu ul,html:is(.ahura-dark-theme, .ahura-black-theme) .post-entry{
  border-bottom-color:var(--ahura-c-border-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topmenu li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox6post2 h4,
html:is(.ahura-dark-theme, .ahura-black-theme) .post-meta li,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox6post1 h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-item h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .post-entry .post-title h1,
html:is(.ahura-dark-theme, .ahura-black-theme) .post-title h1 a,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox4 article h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox4 article p{
  color:var(--ahura-c-text-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .main-menu li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-item h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .post-title h1 a,
html:is(.ahura-dark-theme, .ahura-black-theme) .sidebar-widget-title,
html:is(.ahura-dark-theme, .ahura-black-theme) .comments-area h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .postbox4 article h3{
  border-bottom-color:var(--ahura-c-border-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .commentlist .review, html:is(.ahura-dark-theme, .ahura-black-theme) .commentlist .comment, html:is(.ahura-dark-theme, .ahura-black-theme) input, html:is(.ahura-dark-theme, .ahura-black-theme) textarea{
  border-color:var(--ahura-c-border-primary);
  background-color: transparent;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .search input[type="text"]{
  background:var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topmenu li ul,html:is(.ahura-dark-theme, .ahura-black-theme) .topmenu li.current_page_item a{
  background:var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topmenu li ul li,html:is(.ahura-dark-theme, .ahura-black-theme) .list-posts-widget li{
  border-bottom:var(--ahura-c-border-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .services_elem span,
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .services_elem_2 span,
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .services_elem_3 a
{
  color: inherit;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .post-carousel-3,
html:is(.ahura-dark-theme, .ahura-black-theme) .productcategorybox .owl-carousel,
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .banner-box1
{
  background-color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-next i,
html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-prev i
{
	background: rgba(0,0,0,0.5);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .search_elem
{
  background-color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .banner-box1 .content_section .title,
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .post-carousel-3 .info_box .title,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-mode-3 .panel_menu_wrapper .mini-cart-header .mini-cart-header-content .woocommerce-mini-cart__buttons.buttons a:not(.checkout),
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar ul.menu li ul li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-mode-2 .action-box #action_link,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-main-header .bottom-section .cats-list ul.menu a,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-main-header .bottom-section .menu-wrapper ul.topmenu > li > a
{
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar .cats-list .menu li ul
{
  background-color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .header-mode-2 .action-box #action_link:hover,
html:is(.ahura-dark-theme, .ahura-black-theme) .ah-product-brand-list a,
html:is(.ahura-dark-theme, .ahura-black-theme) #ah-quick-product-content .ah-quick-product-head,
html:is(.ahura-dark-theme, .ahura-black-theme) #ah-quick-product-content .ah-quick-product-head h2,
html:is(.ahura-dark-theme, .ahura-black-theme) #ah-quick-product-content .ah-close-quick-product
{
  background-color: var(--ahura-c-bg-secondary);
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .topbar .cats-list ul.menu>li>a::after,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce div.product,
html:is(.ahura-dark-theme, .ahura-black-theme) #ah-quick-product-content .ah-quick-product-head
{
  border-color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .banner-box1 .content_section .btn_cta:hover
{
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .search_elem input{
  color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .post-entry .wp-block-quote p
{
  color: var(--ahura-c-text-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .woocommerce-tabs.wc-tabs-wrapper .tabs.wc-tabs li {
  box-shadow: var(--auto_soft_shadow);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .product-related-slider .swiper-button-next, 
html:is(.ahura-dark-theme, .ahura-black-theme) .product-related-slider .swiper-button-prev {
    background-color: var(--ahura-c-bg-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .product-related-slider .swiper-button-next:after, 
html:is(.ahura-dark-theme, .ahura-black-theme) .product-related-slider .swiper-button-prev:after {
    color: var(--ahura-c-text-primary);
}
@media only screen and (min-width: 768px)
{
  html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .post-carousel-3 .slide_box .owl-carousel .owl-next
  {
    background-image: linear-gradient(to left,#222 0%,transparent 100%);
  }
  html:is(.ahura-dark-theme, .ahura-black-theme) .elementor .post-carousel-3 .slide_box .owl-carousel .owl-prev
  {
      background-image: linear-gradient(to right,#222 0%,transparent 100%);
  }
  html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-prev{
    background-image:linear-gradient(to right,#333 0%,transparent 100%);
  }
  html:is(.ahura-dark-theme, .ahura-black-theme) .owl-carousel .owl-next{
    background-image:linear-gradient(to left,#333 0%,transparent 100%);
  }
}
html:is(.ahura-dark-theme, .ahura-black-theme) .product_title,.page-title{
  color: var(--ahura-c-text-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-checkout-payment, 
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-checkout #payment{
  background-color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) #add_payment_method #payment div.payment_box, html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-cart #payment div.payment_box, html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-checkout #payment div.payment_box{
  background-color: transparent;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .quantity input[type="number"]{
	color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .quantity{
  justify-content: center;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .mw_qty_btn{
  display: flex;
  padding: 0 3px;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .mini-cart-header .mini-cart-header-content p.woocommerce-mini-cart__buttons a.wc-forward{
  color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .mini-cart-header .mini-cart-header-content .woocommerce-Price-amount bdi,html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .mini-cart-header .mini-cart-header-content .woocommerce-Price-amount span{
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-mini-cart__buttons a.button.checkout:hover{
  background-color: var(--ahura-c-bg-secondary);
  color: var(--ahura-c-text-secondary);
  box-shadow: none;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .single_add_to_cart_button{
  color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .woocommerce-Tabs-panel h2,html:is(.ahura-dark-theme, .ahura-black-theme) .comment-form-rating label[for="rating"],html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce-Tabs-panel--additional_information table,html:is(.ahura-dark-theme, .ahura-black-theme) .sidebar .sidebar-widget .product_list_widget li span.product-title{
  color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mgsiteside a,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-popup-login-form label,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-popup-login-form span {
  color:var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .select2-container--default .select2-results__option[aria-selected=true],
html:is(.ahura-dark-theme, .ahura-black-theme) .select2-container--default .select2-results__option {
    color: #333;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .single .authorabout .authortxt, 
html:is(.ahura-dark-theme, .ahura-black-theme) span.required, 
html:is(.ahura-dark-theme, .ahura-black-theme) .post-title h1,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-sticky-basket-area .ah-single-sticky-cart-variables-toggle-btn {
  color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .post-title h1 {
    border-bottom-color: var(--ahura-c-border-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .post-entry, 
html:is(.ahura-dark-theme, .ahura-black-theme) .sidebar-widget,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-sticky-basket-area table {
  border-color: var(--ahura-c-border-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-sticky-basket-area {
    border-top: 1px solid #484848;
}

html:is(.ahura-dark-theme, .ahura-black-theme) td.product-price *,html:is(.ahura-dark-theme, .ahura-black-theme) td.product-subtotal *,html:is(.ahura-dark-theme, .ahura-black-theme) .sidebar-widget *,html:is(.ahura-dark-theme, .ahura-black-theme) .cart_totals *,
html:is(.ahura-dark-theme, .ahura-black-theme) #goto-top *,
html:is(.ahura-dark-theme, .ahura-black-theme) .header-mode-4 .topbar-main ul li a,
html:is(.ahura-dark-theme, .ahura-black-theme) .siteside-close,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .price *,
html:is(.ahura-dark-theme, .ahura-black-theme) #reply-title, 
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .shop_table button, 
html:is(.ahura-dark-theme, .ahura-black-theme) #order_review td,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce:where(body:not(.woocommerce-uses-block-theme)) .woocommerce-breadcrumb,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce:where(body:not(.woocommerce-uses-block-theme)) .woocommerce-breadcrumb a,
html:is(.ahura-dark-theme, .ahura-black-theme) .product-page-digi-style .product-page-share-btns li i {
  color: var(--ahura-c-text-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .mgsiteside li ul.sub-menu li a{
  color: var(--ahura-c-text-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .summary.entry-summary .quantity:not(.hidden), html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .product-quantity .quantity:not(.hidden){
  background: transparent;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-like {
    background-color: var(--ahura-c-bg-secondary);
    border-color: var(--ahura-c-border-primary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-like .post-like-title,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .portfolio-details .post-title,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .post-metas {
    color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-like .post-like-buttons a .counter {
    background-color: var(--ahura-c-bg-secondary);
    color: var(--ahura-c-text-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-like .post-like-buttons a .btn-title {
    color: var(--ahura-c-bg-secondary);
}
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .portfolio-cats a {
    background-color: var(--ahura-c-bg-secondary);
    color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .wrap-title h3,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .portfolio-bottom-section .wrap-title h3 {
    background-color: var(--ahura-c-bg-secondary);
    color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .post-content-wrap {
    background-color: var(--ahura-c-bg-secondary);
    color: var(--ahura-c-text-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .portfolios-slider .swiper-button-next, 
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-single-portfolio .portfolios-slider .swiper-button-prev {
    background-color: var(--ahura-c-bg-secondary);
    border: none;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-portfolio-archive .portfolio-archive-items .portfolio-title {
    color: var(--ahura-c-text-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .product-gallery-thumbs-slider .swiper-button-next, 
html:is(.ahura-dark-theme, .ahura-black-theme) .product-gallery-thumbs-slider .swiper-button-prev {
    background-color: var(--ahura-c-bg-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .product-gallery-thumbs-slider .swiper-button-next:after, 
html:is(.ahura-dark-theme, .ahura-black-theme) .product-gallery-thumbs-slider .swiper-button-prev:after {
    color: var(--ahura-c-text-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .single-content-types .single-content-type span {
    background-color: #303030;
    color: #9f9f9f;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-headings-navigation {
    background-color: #303030;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-post-headings-navigation ul li a {
    color: #cdcdcd;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mihanpanelpanel .main-panel.mwtabb::before {
    background-color: transparent;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mpwrapper *:not(input, textarea, select, .btn) {
    color: var(--ahura-c-text-secondary) !important;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mpwrapper table thead th {
    background-color: transparent !important;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mpwrapper .mihanpanel-card-content * {
    color: #fff;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mihanpanel-page .mihanpanelpanel.mpwrapper {
    background: var(--ahura-c-bg-secondary) !important;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce .page-title:before {
    color: #fff;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .captcha-field-group .reload-captcha {
    background-color: #fff;
    border-radius: 7px;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .logo .logo-text {
    color: var(--ahura-c-text-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .file_field,
html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .new-ticket .form input[type=text],
html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .new-ticket .form input[type=email],
html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .new-ticket .form textarea,
html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .new-ticket .form select,
html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .mihanticket-list > .items > .item{
    background-color: var(--ahura-c-bg-primary);
    color:var(--ahura-c-text-primary);
    border-color: var(--ahura-c-bg-primary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .mihanticket-list > .items > .item .inner-data .content .main-content-value {
    background-color: var(--ahura-c-bg-secondary);
    color:var(--ahura-c-text-secondary);
    border-color: var(--ahura-c-bg-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) .mihanticket .mihanticket-list > .items > .item .inner-data .content .main-content-value::after,
html:is(.ahura-dark-theme, .ahura-black-theme) .ahura-sticky-basket-area {
    background: var(--ahura-c-bg-secondary);
}

html:is(.ahura-dark-theme, .ahura-black-theme) #bbpress-forums li *:not(img) {
    filter: brightness(.7);
}

html:is(.ahura-dark-theme, .ahura-black-theme) #commentform input[type=submit] {
    background-color: #333333;
}

html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce table.shop_table,
html:is(.ahura-dark-theme, .ahura-black-theme) .woocommerce table.shop_table td {
    border-color: #333333;
}
html:is(.ahura-dark-theme, .ahura-black-theme) .product-page-digikala-container .ahura_woocommerce_content_wrapper {
  padding: 40px;
}
</style>
<?php endif; ?>