const handleShopCarousel3Element = function (params){
    let carouselContainer = jQuery(`.shop-carousel3-${params.widgetID}`),
        carouselItems = jQuery(`.shop-carousel3-${params.widgetID} .carousel-items`),
        firstItem = jQuery(carouselItems.children()[0]),
        lastItem = jQuery(carouselItems.children()[carouselItems.children().length - 1]),
        carouselActive;

    if(carouselItems.find('.carousel-item').length > 1){
        let auto_carousel = function(){
            carouselActive = carouselItems.find('.carousel-item.active');
            carouselActive.next().trigger('click');
            if(carouselActive.index() == lastItem.index()){
                firstItem.trigger('click');
            }
        }
        let auto_carousel_var = setInterval(auto_carousel, params.duration);
        jQuery(`.shop-carousel3-${params.widgetID}`).hover(
            () => {clearInterval(auto_carousel_var)},
            () => {auto_carousel_var = setInterval(auto_carousel, params.duration)}
        );
    }
}

jQuery(document).ready(function($){
    let body = $('body');

    body.on('click', '.ahura-items-carousel .carousel-items .carousel-item', function(e){
        e.preventDefault();
        let btn = $(this), 
            contentID = btn.data('content'), 
            contentWrap = $('.carousel-content-' + contentID),
            contentWidth,
            contentCount,
            prevContentCount,
            contentWrapWidth, 
            position;
        if(contentWrap.length > 0){
            contentCount = contentWrap.parent().children('.carousel-content').length;
            contentWrapWidth = contentWrap.parent().width();
            contentWrap.parent().children('.carousel-content').removeClass('show');
            contentWrap.addClass('show');
            btn.parent().children('.carousel-item').removeClass('active');
            btn.addClass('active');
            prevContentCount = contentWrap.parent().children('.carousel-content').index(contentWrap.parent().children('.carousel-content.show'));
            position = prevContentCount * contentWrapWidth;
            contentWrap.parent().animate({
                left: $('body').hasClass('mw_ltr') ? -position : position
            }, 500, function () {
                contentWrap.parent().css('transform', '');
            });
        }
    });
});