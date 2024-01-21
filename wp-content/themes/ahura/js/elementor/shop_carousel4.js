const handleShopCarousel4Element = function (params){
    let options = {
        slidesPerView: 2,
        spaceBetween: params.spaceBetween,
        freeMode: true,
        rtl: jQuery('body').hasClass('mw_rtl'),
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 6,
            },
        },
    };

    if(params.navigation){
        options.navigation = {
            nextEl: ".swiper-btn-next",
            prevEl: ".swiper-btn-prev",
        }
    }

    let sc4_swiper = new Swiper('.swiper-shop-carousel4', options);
}