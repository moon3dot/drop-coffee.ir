const handlePostCarouselElement = function (){
    jQuery('.owl-post-carousel').owlCarousel({
        center: false,
        loop: false,
        items: 6,
        lazyLoad: true,
        margin: 25,
        navigation: true,
        navText: ["<i class='fa fa-3x fa-chevron-left'></i>", "<i class='fa fa-3x fa-chevron-right'></i>"],
        responsive: {
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            }
        }
    });
}
jQuery(document).ready(function ($) {
    handlePostCarouselElement();
});