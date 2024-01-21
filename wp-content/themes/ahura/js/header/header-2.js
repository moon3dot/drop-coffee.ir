jQuery(document).ready(function ($){
    const modeSliderTransformer = function (slider, index){
        let isRtl = $('body').hasClass('rtl');
        if(index === 5){
            slider.css('transform', (isRtl ? 'translateX(-200%)' : 'translateX(200%)'));
        } else if(index === 3){
            slider.css('transform', (isRtl ? 'translateX(-100%)' : 'translateX(100%)'));
        } else {
            slider.css('transform', 'translateX(0)');
        }
    }

    $('body').find('.theme-mode-switcher').each(function (i){
        $(this).find('input').each(function (k) {
            let beforeID = $(this).attr('id'),
                newID = beforeID + '-' + (Math.floor(Math.random() * 100) + 1);

            $(this).attr('id', newID);
            let label = $(this).parent().find(`label[for="${beforeID}"]`);
            label.attr('for', newID);
            let newLabel = $(this).parent().find(`label[for="${newID}"]`);
            if($('#' + newID).attr('checked')){
                modeSliderTransformer($(this).parent().find('.slider'), newLabel.index());
            }
        });
    });

    $(document).on('click', '.theme-mode-switcher label', function (e){
        let btn = $(this),
            slider = btn.parent().find('.slider'),
            nthChildIndex = btn.index();

        modeSliderTransformer(slider, nthChildIndex);
    });

    $(document).on('click', '.header-template-2 .header-menu-btn', function (e){
       e.preventDefault();
       let btn = $(this),
           menuWrap = btn.parent().find('.header-menu-side');

        if(window.innerWidth > 1024){
            return false;
        }

        menuWrap.toggleClass('show-side');
    });

    $(document).on('click', '.header-template-2 .close-menu, .header-template-2 .header-menu-overlay', function (e){
       e.preventDefault();
       let menuWrap = $('.header-template-2 .header-menu-side');

        menuWrap.removeClass('show-side');
    });

    $(document).on('click', '.header-template-2 .header-close-notice', function (e){
        e.preventDefault();
        let wrap = $('.header-template-2 .header-notice-box');
        wrap.slideUp(function (){
            $('#ahura-header-main-wrap').css('height', $('#topbar').outerHeight() + 'px');
        });
    });

    $(document).on('click', 'body', function (e) {
        let searchResultWrap = $('.header-template-2 .header-search-form .search-result');
        if (!$(e.target).closest(searchResultWrap.closest('form')).length) {
            searchResultWrap.parent().removeClass('has-result');
        }
    })

    $(document).on('focus', '.header-template-2 .header-search-form input[name="s"]', function (e) {
        let searchForm = $('.header-template-2 .header-search-form');
        if (this.value) {
            if (this.value.length < 2) {
                searchForm.removeClass('has-result');
                return false;
            }
            searchForm.addClass('has-result');
        }
    });

    $(document).on('submit', '.header-template-2 .header-search-form', function (e){
       e.preventDefault();
       let form = $(this),
            input = form.find('input[name="s"]');

       if(!input.val().length || input.val().length < 2){
           input.focus();
       } else {
           input.trigger('input');
       }
    });

    /**
     *
     *
     * Ajax
     *
     *
     */
    $(document).on('input', '.header-template-2 .header-search-form input[name="s"]', function (e) {
        let input = $(this),
            form = input.parent(),
            keyword = input.val(),
            loader = form.find('.spin-loader'),
            postType = form.find('.post-type').val() || 0,
            resultWrap = form.find('.search-result');

        if (keyword.length < 2) {
            loader.fadeOut();
            form.removeClass('has-result');
            return false;
        }

        $.ajax({
            url: ahura_data.au,
            type: 'POST',
            data: {
                action: 'mw_search_ajax',
                keyword: keyword,
                post_type: postType,
                show_thumb: true,
                show_price: true,
                template: 2
            },
            beforeSend: function (){
                resultWrap.empty();
                form.removeClass('has-result');
                loader.fadeIn();
            },
            complete: function (response) {
                loader.fadeOut();
                if (keyword.length < 2) {
                    form.removeClass('has-result');
                } else {
                    form.addClass('has-result');
                    resultWrap.html(response.responseText);
                }
            },
            error: function (){
                loader.fadeOut();
                form.removeClass('has-result');
            }
        });
    });
});