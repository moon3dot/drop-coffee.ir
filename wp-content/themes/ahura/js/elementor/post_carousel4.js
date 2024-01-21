const handlePostCarousel4Element = function (params){
    jQuery('.owl-post-carousel-4').owlCarousel({
        center: true,
        loop: true,
        lazyLoad: true,
        items: params.sliderCount,
        autoplay: params.autoPlay,
        autoplaytimeout: 4000,
        margin: 30,
        navigation: true,
        navText: ["<i class='fa fa-3x fa-chevron-left'></i>", "<i class='fa fa-3x fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 1
            },
            600:{
                items: 2
            },
            1000: {
                items: params.sliderCount
            }
        }
    });
}