const handleShopCategoryElement = function (){
    let is_rtl = jQuery('body').hasClass('mw_rtl') ? true : false;
    jQuery('.shop-category-element .owl-shop-category').owlCarousel({
        center: false,
        loop: false,
        items: 6,
        lazyLoad: true,
        rtl: is_rtl,
        margin: 25,
        navigation:true,
        navText : ["<i class='fa fa-3x fa-chevron-left'></i>","<i class='fa fa-3x fa-chevron-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
            600:{
                items:2
            },
            860:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });
}

jQuery(document).ready(function ($) {
    handleShopCategoryElement();
});