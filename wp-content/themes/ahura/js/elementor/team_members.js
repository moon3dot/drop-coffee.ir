jQuery(document).ready(function($){
    let body = $('body');

    body.on('click', '.ahura-team-members-element .team-element-tabs .tab-item-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.ahura-team-members-element-${btn.data('wid')}`),
            tabContentWrap = $(btn.data('tab')),
            tabItems = gridWrap.find('.team-element-tabs ul'),
            tabs = gridWrap.find('.team-tab-content-wrap');

        if (btn.parent().hasClass('active')) {
            return false;
        }

        tabItems.find('.active').removeClass('active');
        btn.parent().addClass('active');
        tabs.removeClass('active').slideUp();
        tabContentWrap.addClass('active').slideDown();
    });

    body.on('click', '.ahura-team-members-element .team-sub-tabs li a', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.ahura-team-members-element-${btn.data('wid')} .elementor-repeater-item-${btn.data('item-id')}`),
            pageNum = btn.data('paged') !== undefined && parseInt(btn.data('paged'))? btn.data('paged') : 1,
            tabContentWrap = $(btn.data('tab')),
            tabItems = gridWrap.find('.team-sub-tabs ul'),
            tabContent = gridWrap.find('.team-tab-content'), appended;

        if (pageNum <= 0) {
            return false;
        }

        $.ajax({
            url: ahura_data_tmel.ajax_url,
            data: {
                action: 'ahura_team_members_tab_ajax',
                settings: btn.data('settings'),
                page_num: parseInt(pageNum)
            },
            type: 'POST',
            dataType: 'html',
            beforeSend: function () {
                tabItems.addClass('loading');
            },
            success: function (res) {
                tabItems.removeClass('loading');
                tabContent.empty();

                if (res.length) {
                    tabContent.html(res);
                    if(tabContent.find('.ahura-pagination').length){
                        tabContent.parent().children('.ahura-pagination').remove();
                        tabContent.parent().append(tabContent.find('.ahura-pagination'));
                        if(tabContent.parent().children('.ahura-pagination').length){
                            tabContent.parent().children('.ahura-pagination').attr('data-item-id', btn.data('item-id'));
                            tabContent.parent().children('.ahura-pagination').attr('data-wid', btn.data('wid'));
                        }
                    }
                    ahuraSetCookie(`team_subtab_element_${btn.data('wid')}`, `team-sub-tab-btn-${btn.data('wid')}-${btn.data('item-id')}`);
                }

                tabItems.find('.active').removeClass('active');
                btn.parent().addClass('active');
                tabContent.parent().children('.ahura-pagination').removeClass('loading');
            },
            error: function () {
                tabItems.removeClass('loading');
                console.error('team not dound!');
            }
        });
    });

    body.on('click', '.ahura-team-members-element .ahura-pagination .page-numbers', function (e) {
        e.preventDefault();
        let btn = $(this),
            pages = btn.parent(),
            gridWrap = $(`.ahura-team-members-element-${btn.parent().data('wid')} .elementor-repeater-item-${btn.parent().data('item-id')}`),
            currentPageEl = pages.find('span.current'),
            currentPageNum = currentPageEl.length ? parseInt(currentPageEl.text()) : 1,
            targetPageNum = parseInt(btn.text()),
            currentTab = gridWrap.find('.team-sub-tabs ul li.active a');

        if(btn.hasClass('current')){
            return false;
        }

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
        
        if(currentTab.length && targetPageNum){
            currentTab.attr('data-paged', targetPageNum);
            currentTab.data('paged', targetPageNum);
            pages.find('.current').removeClass('current');
            btn.replaceWith('<span aria-current="page" class="page-numbers current">' + targetPageNum +'</span>');
            currentTab.trigger('click');
            pages.addClass('loading');
        }
    });
});