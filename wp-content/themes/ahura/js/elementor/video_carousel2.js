const handleVideoCarousel2Element = function (){
    if (typeof window.Swiper != undefined){
        let vpc2_swiper = new Swiper('.video-carousel2', {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: ".vpc2-swiper-pagination",
            },
        });
    }
}