let selectors = document.querySelectorAll('.offer-carousel-1 .product-discount-timer-wrap');
if(selectors != null && selectors !== undefined){
    selectors.forEach((item) => {
        let datetime = item.dataset.time;
        if(datetime){
            ahuraDatetimeToCountdown(datetime, document.querySelector('.offer-carousel-1 .product-discount-timer-wrap-' + item.dataset.id));
        }
    });
}

const handleOfferCarouselElement = function (params){
    let lines = document.querySelectorAll(`.offer-carousel-${params.widgetID} .slider-duration-line`);
    let offer_carousel_swiper = new Swiper(`.offer-carousel-${params.widgetID} .offer-carousel-1`, {
        init: true,
        slidesPerView: 1,
        spaceBetween: 5,
        effect: "fade",
        mousewheel: false,
        allowTouchMove: false,
        followFinger: false,
        simulateTouch: false,
        preventInteractionOnTransition: true,
        keyboard: {
            enabled: false,
        },
        autoplay: {
            delay: params.autoPlayDelay,
        },
        watchSlidesProgress: true,
    });

    let initProgressBar = function (){
        jQuery('.offer-carousel-1 .slider-duration-line').animate({
            width: '100%'
        }, params.autoPlayDelay, 'linear');
    }

    initProgressBar();

    offer_carousel_swiper.on('slideChange', function(){
        jQuery('.offer-carousel-1 .slider-duration-line').css('width', '0');
        initProgressBar();
    });
}