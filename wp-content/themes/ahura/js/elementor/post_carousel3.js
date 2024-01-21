const handlePostCarouse3 = function(){
    jQuery(".post-carousel-3 .slide_box .owl-slider-wrap").owlCarousel({
        center: false,
        loop: true,
        items: 3,
        lazyLoad: true,
        margin: 20,
        navigation: false,
        navText: ["<i class='fa fa-3x fa-chevron-left'></i>", "<i class='fa fa-3x fa-chevron-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            400: {
                items: 2
            },
            600: {
                items: 3
            }
        }
    });
}

jQuery(document).ready(function ($) {
    handlePostCarouse3();
});