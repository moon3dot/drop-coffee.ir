const handleProductsCategory2Element = function (params){
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

        if (params.navigation) {
            options.navigation = {
                nextEl: `.ahura-products-category2-${params.widgetID} .apc-swiper-button-next`,
                prevEl: `.ahura-products-category2-${params.widgetID} .apc-swiper-button-prev`,
            }
        }

        if (params.autoPlay) {
            options.autoplay = {
                delay: params.transitionDuration,
                disableOnInteraction: false,
            }
        }

        let apc_swiper = new Swiper(`.ahura-products-category2-carousel-${params.widgetID}`, options);
    }
}