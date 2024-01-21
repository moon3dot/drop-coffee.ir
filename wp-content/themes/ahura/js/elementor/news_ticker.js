const handleNewsTickerElement = function (params) {
    let options = {
        loop: true,
        slidesPerView: 1,
        observeParents: true,
        spaceBetween: 60,
        navigation: {
            nextEl: '.items-swiper-button-next',
            prevEl: '.items-swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 15,
            },
            768: {
                slidesPerView: 1,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 1,
                spaceBetween: 60,
            },
        },
    };
    if (params.autoPlayStatus === true) {
        options.autoplay = {
            delay: params.playDelay,
            disableOnInteraction: false,
        };
    }

    new Swiper('.swiper-news-ticker', options);
}