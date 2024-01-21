jQuery(document).ready(function ($) {
    var body = $('body');

    body.on('click', '.product-tab-2 .pt-item-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            gridWrap = $(`.product-tab-2-wrap-${btn.data('wid')}`),
            tabContentWrap = $(btn.data('tab')),
            tabItems = gridWrap.find('.pt-tab-items ul'),
            tabs = gridWrap.find('.pt-tab-content-wrap');

        if (btn.parent().hasClass('active') || !tabContentWrap.length) {
            return false;
        }

        tabItems.find('.active').removeClass('active');
        btn.parent().addClass('active');
        tabs.removeClass('active').hide();
        tabContentWrap.addClass('active').show();
    });
});