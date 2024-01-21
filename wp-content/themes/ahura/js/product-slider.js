jQuery(document).ready(function ($) {
    if($('.product-gallery-slider').length){
        var product_single_thumbs_slider = new Swiper('.product-gallery-thumbs-slider', {
            loop: false,
            slidesPerView: 4,
            spaceBetween: 7,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        var product_single_slider = new Swiper('.product-gallery-slider', {
            loop: false,
            slidesPerView: 1,
            thumbs: {
                swiper: product_single_thumbs_slider,
            },
        });
    }
});