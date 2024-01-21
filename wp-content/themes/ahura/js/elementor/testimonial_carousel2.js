const handleTestimonialCarousel2Element = function (params){
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

        if(params.showPagination){
            options.pagination = {
                el: `.testimonial-carousel-2-${params.widgetID} .tc-swiper-pagination`,
                clickable: true,
            }

            if(params.paginationType !== 'default'){
                options.pagination.type = params.paginationType;
            }
        }

        if(params.navigation){
            options.navigation = {
                nextEl: `.testimonial-carousel-2-${params.widgetID} .tc-swiper-button-next`,
                prevEl: `.testimonial-carousel-2-${params.widgetID} .tc-swiper-button-prev`,
            }
        }

        if(params.autoPlay){
            options.autoplay = {
                delay: params.transitionDuration,
                disableOnInteraction: false,
            }
        }

        let tc_swiper = new Swiper(`.testimonial-carousel-2-${params.widgetID}`, options);
    }
}