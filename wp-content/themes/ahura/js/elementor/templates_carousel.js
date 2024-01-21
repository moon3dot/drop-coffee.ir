const handleTemplatesCarouselElement = function (params){
    let options = {
        loop: params.loop,
        slidesPerView: params.mobilePerView,
        observeParents: true,
        spaceBetween: 60,
        breakpoints: {
            640: {
                slidesPerView: params.mobilePerView,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: params.tabletPerView,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: params.slidesPerView,
                spaceBetween: 20,
            },
        },
    };

    if(params.autoPlay){
        options.autoplay = {
            delay: params.playSpeed,
            disableOnInteraction: false,
        };
    }

    if(params.navigation){
        options.navigation = {
            nextEl: '.templates-carousel-button-next',
            prevEl: '.templates-carousel-button-prev',
        };
    }

    let cc_swiper = new Swiper('.swiper-templates-carousel', options);
}