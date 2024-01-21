const handleImageSlider3Element = function (params){
    if (typeof window.Swiper != undefined) {
        let options = {
            loop: params.loop,
            slidesPerView: params.mobilePerView,
            spaceBetween: 20,
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
                delay: params.transitionDuration,
                disableOnInteraction: false,
            };
        }

        if(params.pagination){
            options.pagination = {
                el: `.image-slider-3-${params.widgetID} .swiper-pagination`,
                clickable: true,
            };
        }

        if(params.navigation){
            options.navigation = {
                nextEl: `.image-slider-3-${params.widgetID} .swiper-btn-next`,
                prevEl: `.image-slider-3-${params.widgetID} .swiper-btn-prev`,
            };
        }

        let img_swiper = new Swiper(`.image-slider-3-${params.widgetID} .swiper`, options);
    }
}