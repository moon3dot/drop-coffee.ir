jQuery(document).ready(function ($) {
    var body = $('body'),
        colors = ['red', 'violet', 'yellow', 'blue'];

    body.on('click', '.pgt-item-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.post-grid-tab-1-wrap-${btn.data('wid')}`),
            tabContentWrap = $(btn.data('tab')),
            loader = btn.find('.ahura-loader-ring'),
            tabItems = gridWrap.find('.pgt-tab-items ul'),
            tabsContent = gridWrap.find('.pgt-tabs-content'),
            tabs = gridWrap.find('.pgt-tab-content-wrap'),
            tabContent = tabContentWrap.find('.pgt-tab-content'), appended, color;

        if (btn.parent().hasClass('active')) {
            return false;
        }

        if (tabContent.find('.post-item').length > 0 || tabContent.find('.mw_element_error').length > 0) {
            tabItems.find('.active').removeClass('active');
            btn.parent().addClass('active');
            tabs.removeClass('active').hide();
            tabContentWrap.addClass('active').show();
        } else {
            $.ajax({
                url: ahura_data_pgt.ajax_url,
                data: {
                    action: 'ahura_post_grid_tab_ajax',
                    settings: btn.data('settings')
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    loader.fadeIn();
                },
                success: function (res) {
                    loader.fadeOut();
                    tabContent.empty();
                    if (res.status === 'success' && res.items !== undefined) {
                        $.each(res.items, function (key, item) {
                            appended = tabContent.append(
                                $('<div/>', {'class': 'col-12 col-sm-12 col-md-4 col-lg-3'}).append(
                                    $('<div/>', {'class': 'post-item post-item-' + key}).css({
                                        'background-image': `url(${item.thumb})`,
                                        'box-shadow': `0 0 15px var(--ahura-post-grid-1-${item.color})`
                                    }).append(
                                        $('<div/>', {'class': 'overly'}).css('background-color', `var(--ahura-post-grid-1-${item.color})`),
                                        $('<div/>', {'class': 'post-details'}).append(
                                            $('<div/>', {'class': 'post-top'}).append(
                                                $('<h2/>', {'class': 'post-title', text: item.title}),
                                            ),
                                            $('<div/>', {'class': 'post-foot'}).append(
                                                $('<a/>', {'href': item.post_link}).append(
                                                    $('<i/>', {'class': 'fas fa-eye'}),
                                                    $('<span/>', {text: ahura_data_pgt.translate.view_more}),
                                                )
                                            )
                                        )
                                    )
                                )
                            );
                            if (item.sm === 'yes') {
                                $('<div/>', {'class': 'post-metas'}).append(
                                    $('<div/>', {'class': 'date'}).append(
                                        $('<i/>', {'class': 'fas fa-calendar'}),
                                        $('<span/>', {text: item.date}),
                                    ),
                                ).insertBefore(tabContent.find('.post-item-' + key + ' .post-top .post-title'));
                            }
                        });
                    } else {
                        appended = tabContent.html(
                            $('<div/>', {'class': 'col-12'}).append(
                                $('<div/>', {'class': 'mw_element_error', text: res.msg})
                            )
                        )
                    }

                    tabItems.find('.active').removeClass('active');
                    btn.parent().addClass('active');
                    tabs.removeClass('active').hide();
                    tabContentWrap.addClass('active').show();
                },
                error: function () {
                    loader.fadeOut();
                    console.error('Posts not dound!');
                }
            });
        }
    });
});