const handleProductBoxCarouselElement = function (){
    let pbc_swiper = new Swiper('.product-box-carousel-1 .box-products', {
        loop: true,
        mousewheel: true,
        navigation: {
            nextEl: '.pbc-button-next',
            prevEl: '.pbc-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 5,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 10,
            },
        },
    });
}
jQuery(document).ready(function ($) {
    handleProductBoxCarouselElement();

    $('body').on('mouseenter', '.product-box-carousel-1 .product', function () {
        let box = $(this);
        if (box.find('.pbc-after .features').length > 0) {
            box.find('.pbc-before').slideUp();
            box.find('.pbc-after').slideDown();
        } else {
            box.find('.pbc-after.b').slideDown();
        }
    });

    $('body').on('mouseleave', '.product-box-carousel-1 .product', function () {
        let box = $(this);
        box.find('.pbc-before').slideDown();
        box.find('.pbc-after').slideUp();
    });
});