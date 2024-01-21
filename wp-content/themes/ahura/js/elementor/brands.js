const handleBrandsElement = function (params) {
    if (typeof window.Swiper != undefined) {
        let options = {
            slidesPerView: params.mobilePerView,
            spaceBetween: 0,
            rtl: jQuery('body').hasClass('rtl'),
            breakpoints: {
                640: {
                    slidesPerView: params.mobilePerView,
                },
                768: {
                    slidesPerView: params.tabletPerView,
                },
                1024: {
                    slidesPerView: params.desktopPerView,
                },
            },
        };

        if (params.pagination) {
            options.pagination = {
                el: `.brands-list-${params.widgetID} .swiper-pagination`,
                clickable: true,
            };
        }

        let abr_swiper = new Swiper(`.ahura-brands-wrap .brands-list-swiper`, options);
    }
}