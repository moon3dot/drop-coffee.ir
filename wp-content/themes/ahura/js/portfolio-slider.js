jQuery(document).ready(function ($) {
    if($('.portfolios-slider').length){
        var portfolio_slider = new Swiper('.portfolios-slider', {
            loop: false,
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: ".portfolios-slider .swiper-button-next",
                prevEl: ".portfolios-slider .swiper-button-prev",
            },
            autoplay: {
                delay: 8000,
                disableOnInteraction: true,
            },
        });
    }
});