jQuery(document).ready(function($){
    var body = $(document);

    body.on('click', '.fonticon-selector-selected', function(e){
        e.preventDefault();
        let btn = $(this),
            allBoxs = body.find('.fonticon-selector-items-wrap'),
            items = btn.parent().children('.fonticon-selector-items-wrap');
        if(items.is(':visible')){
            items.slideUp();
        } else {
            allBoxs.slideUp();
            items.slideDown();
        }
    });

    $(document).on('click', '.fonticon-selector-items-wrap .fonticon-selector-items div', function(e){
        e.preventDefault();
        let btn = $(this),
            icon = btn.data('icon'),
            wrap = btn.parent().parent().parent().parent(),
            selector = wrap.find('.fonticon-selector-selected'),
            list = btn.parent(),
            input = wrap.find('select');

        if(btn.hasClass('selected')){
            btn.removeClass('selected');
            selector.find('i').hide();
            selector.find('span').empty();
            input.val('').trigger('change');
        } else {
            list.find('.selected').removeClass('selected');
            btn.addClass('selected');
            selector.find('i').attr('class', icon);
            selector.find('span').text(icon);
            input.val(icon).trigger('change');
        }
    });

    $(document).on('keyup', '.fonticon-selector-items-wrap input.font-icon-search', function(e){
        e.preventDefault();
        let input = $(this),
            param = input.val(),
            items = input.parent().parent().find('.fonticon-selector-items div'), item, str;
        if(param.length >= 2){
            items.each(function(i){
                item = $(this).children('i');
                str = item.attr('class');
                if(str.search(param) >= 0){
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        } else {
            items.show();
        }
    });
});