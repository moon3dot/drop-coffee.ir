const handleShopCarousel5Element = function (params){
    let options = {
        loop: params?.loop,
        autoplay: params?.autoplay,
        autoplayTimeout: params?.autoplayTimeout,
        slidesPerView: 1,
        spaceBetween: 10,
        freeMode: true,
        rtl: jQuery('body').hasClass('rtl'),
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: params.cols,
            },
        },
    };

    if(params.navigation){
        options.navigation = {
            nextEl: ".swiper-btn-next",
            prevEl: ".swiper-btn-prev",
        };
    }

    let sc5_swiper = new Swiper(".shop-carousel5-swiper", options);
}