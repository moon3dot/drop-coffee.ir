jQuery(document).ready(function($){
    let body = $('body');

    body.on('change', '.grid-posts-10 .posts-filter select', function(e){
        e.preventDefault();
        let select = $(this),
            wrap = select.parent().parent().parent(),
            contentWrap = wrap.find('.posts-list'),
            selectVal = select.val(),
            selectedTax = select.find('option:selected').data('tax');

        $.ajax({
            url: gp10.ajax_url,
            data: {
                action: 'ahura_element_grid_posts10',
                category: selectVal,
                taxonomy: selectedTax,
                page_num: select.data('before-val') == selectVal && parseInt(select.data('page-num')) > 1 ? parseInt(select.data('page-num')) : 1,
                settings: select.data('settings')
            },
            type: 'POST',
            beforeSend: function () {
                wrap.addClass('has-loader');
            },
            complete: function (res) {
                res = res.responseText;
                wrap.removeClass('has-loader');
                if (res.length){
                    select.data('before-val', selectVal);
                    contentWrap.empty();
                    contentWrap.html(res);
                    contentWrap.parent().children('.ahura-pagination').remove();
                    contentWrap.parent().append(contentWrap.find('.ahura-pagination'));
                }
            },
            error: function () {
                wrap.removeClass('has-loader');
            }
        });
    });

    body.on('click', '.grid-posts-10 .ahura-pagination .page-numbers', function (e) {
        e.preventDefault();
        let btn = $(this),
            pages = btn.parent(),
            gridWrap = $(`.grid-posts-10-${pages.parent().data('wid')}`),
            select = gridWrap.find('.posts-filter select'),
            currentPageEl = pages.find('span.current'),
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
            pages.find('.current').removeClass('current');
            btn.replaceWith('<span aria-current="page" class="page-numbers current">' + targetPageNum + '</span>');
            select.data('page-num', targetPageNum);
            select.trigger('change');

            ahuraScrollTo('.grid-posts-10-' + pages.parent().data('wid'));
        }
    });
});