jQuery(document).ready(function($){
    let body = $('body');

    body.on('click', '.ahura-gallery-element .ahura-pagination .page-numbers', function (e) {
        e.preventDefault();
        let btn = $(this),
            pages = btn.parent(),
            contentWrap = $(`.ahura-gallery-element-${btn.parent().parent().data('wid')} .gallery-content-wrap`),
            settings = contentWrap.data('settings'),
            currentPageEl = pages.find('span.current'),
            currentPageNum = currentPageEl.length ? parseInt(currentPageEl.text()) : 1,
            targetPageNum = parseInt(btn.text());

        if(btn.hasClass('next')){
            if(currentPageEl.next()){
                if(parseInt(currentPageEl.next().text()) > 0){
                    btn = currentPageEl.next();
                    targetPageNum = parseInt(currentPageEl.next().text());
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        if(btn.hasClass('prev')){
            if(currentPageEl.prev()){
                if(parseInt(currentPageEl.prev().text()) > 0){
                    btn = currentPageEl.prev();
                    targetPageNum = parseInt(currentPageEl.prev().text());
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        if(targetPageNum){
            $.ajax({
                url: ahura_gallery_data.ajax_url,
                data: {
                    action: 'ahura_gallery_element',
                    page_num: targetPageNum,
                    settings: settings
                },
                type: 'POST',
                beforeSend: function(){
                    pages.addClass('loading');
                },
                success: function(res){
                    if(res.length){
                        pages.find('.current').removeClass('current');
                        btn.replaceWith('<span aria-current="page" class="page-numbers current">' + targetPageNum +'</span>');
                        contentWrap.html(res);
                    }
                    pages.removeClass('loading');
                },
                error: function(){
                    pages.removeClass('loading');
                }
            });
        }
    });

    /*if(typeof window.SimpleLightbox !== "undefined" && typeof window.SimpleLightbox !== undefined){
        var gallery_lightbox = new SimpleLightbox('.ahura-gallery-element a', {
            nav: true,
            loop: false,
        });
    }*/
});