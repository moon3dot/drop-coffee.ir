jQuery(document).ready(function ($) {
    $(document).on('click', '.ahura-tabs-element-wrap .ah-tab-title-wrap', function (e){
        e.preventDefault();
        let tab = $(this),
            wrap = tab.closest('.ahura-tabs-element-wrap'),
            tabsWrap = wrap.find('.ah-tab-items'),
            tabContents = wrap.find('.ah-tab-content'),
            targetTab = wrap.find('.ah-tab-contents #' + tab.data('tab'));

        if (!targetTab.length) return false;

        tabsWrap.find('.active').removeClass('active');
        tab.parent().addClass('active');

        tabContents.hide();
        targetTab.show();
    });
});