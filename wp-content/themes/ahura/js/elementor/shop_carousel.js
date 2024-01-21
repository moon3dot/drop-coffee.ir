const handleShopCarouselElement = function(params){
    let is_rtl = jQuery('body').hasClass('mw_rtl') ? true : false;
    jQuery('.shop-carousel-element .owl-shop-carousel').owlCarousel({
        loop: params?.loop,
        autoplay: params?.autoplay,
        autoplayTimeout: params?.autoplayTimeout,
        center: false,
        items: 6,
        lazyLoad: true,
        rtl: is_rtl,
        margin: 25,
        navigation: true,
        navText: ["<i class='fa fa-3x fa-chevron-left'></i>", "<i class='fa fa-3x fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
}
jQuery(document).ready(function ($) {
    handleShopCarouselElement();
});