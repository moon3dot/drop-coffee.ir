jQuery(document).ready(function ($) {
    var body = $('body');

    body.on('click', '.product-tab-1 .pt-item-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.product-tab-1-wrap-${btn.data('wid')}`),
            tabContentWrap = $(btn.data('tab')),
            loader = btn.find('.ahura-loader-ring'),
            tabItems = gridWrap.find('.pt-tab-items ul'),
            tabsContent = gridWrap.find('.pt-tabs-content'),
            tabs = gridWrap.find('.pt-tab-content-wrap'),
            tabContent = tabContentWrap.find('.pt-tab-content'), appended, color;

        if (btn.parent().hasClass('active')) {
            return false;
        }

        if (tabContent.find('.product-item').length > 0 || tabContent.find('.mw_element_error').length > 0) {
            tabItems.find('.active').removeClass('active');
            btn.parent().addClass('active');
            tabs.removeClass('active').hide();
            tabContentWrap.addClass('active').show();
        } else {
            $.ajax({
                url: ahura_data.ajax_url,
                data: {
                    action: 'ahura_product_tab_ajax',
                    settings: btn.data('settings')
                },
                type: 'POST',
                dataType: 'html',
                beforeSend: function () {
                    loader.fadeIn();
                },
                success: function (res) {
                    loader.fadeOut();
                    tabContent.html(res);
                    tabItems.find('.active').removeClass('active');
                    btn.parent().addClass('active');
                    tabs.removeClass('active').hide();
                    tabContentWrap.addClass('active').show();
                },
                error: function () {
                    loader.fadeOut();
                    console.error('products not found!');
                }
            });
        }
    });

    body.on('click', '.product-tab-1 .tab-load-archive-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.product-tab-1-wrap-${btn.data('wid')}`),
            tabContentWrap = $(btn.data('tab')),
            loader = btn.find('.ahura-loader-ring'),
            tabsContent = gridWrap.find('.pt-tabs-content'),
            tabContent = tabContentWrap.find('.pt-tab-content'),
            currentPage = Number.parseInt(btn.data('page'));

        if (btn.data('settings') === undefined || btn.data('settings') == null || btn.data('settings') == '')
            return false;

        $.ajax({
            url: ahura_data.ajax_url,
            data: {
                action: 'ahura_load_product_tab_ajax',
                settings: btn.data('settings'),
                paged: currentPage,
            },
            type: 'POST',
            dataType: 'html',
            beforeSend: function () {
                loader.fadeIn();
            },
            success: function (res) {
                loader.fadeOut();
                if (res.length > 0) {
                    if (currentPage !== undefined || currentPage != null || currentPage != '') {
                        tabContent.append(res);
                        btn.attr('data-page', (currentPage + 1)).data('page', (currentPage + 1));
                    } else {
                        tabContent.html(res);
                    }
                } else {
                    btn.hide();
                }
            },
            error: function () {
                loader.fadeOut();
                console.error('products not found!');
            }
        });
    });
});