jQuery(document).ready(function ($) {
    $('body').on('click', '.shop-page-sidebar-toggle', function(){
        let btn = $(this),
            sidebar = $('.shop-page-sidebar');
        if(sidebar.length > 0){
            btn.toggleClass('show-sidebar');
            sidebar.toggleClass('is-sidebar-active').slideToggle();
        }
    });

    $('body').on('click', '.portfolio-slider-toggle', function(e){
        e.preventDefault();
        let btn = $(this),
            type = btn.data('type'),
            images = $('.portfolios-slider-images'),
            videos = $('.portfolios-slider-videos');
        if(type == 'videos'){
            images.slideUp();
            videos.slideDown();
        } else if(type == 'images'){
            videos.find('.swiper-slide-active video').get(0).pause();
            videos.slideUp();
            images.slideDown();
        }
    });

    //Sticky Sidebar    
    // /*handle the scroll header height*/
    var height,container_parent
    function Handle_Custom_Header_Sticky() {
        var continers = $('header .elementor-inner-section')
        continers.each(function () {
            var container = $(this).find('.elementor-widget-container')
            var hide_in_scroll = $(container.find('.hide_in_scroll'))
            if (hide_in_scroll.length == container.length) {
                var containerParent = $(container.parents('.elementor-inner-section'))
                height = containerParent.height()
                container_parent = containerParent
                if ($(window).scrollTop() > 0) {
                    containerParent.css({
                        'display': 'none',
                        'maxHeight': $(this).height(),
                        'transition': '0.3s'
                    })
                } else {
                    containerParent.css({
                        'display': 'block',
                        'maxHeight': 'none'
                    })
                }
                if(window.sticky_header == true){
                    if($(window).scrollTop() == 0){
                        $('aside .theiaStickySidebar').css({
                            'position':'static',
                            'width':'',
                            'transform': 'none'
                        })

                    }
                }
            }
        })
    }

    if (typeof $('.sticky_sidebar').theiaStickySidebar !== "undefined") {
        $('.sticky_sidebar').theiaStickySidebar({
            additionalMarginTop: window.sticky_header ? height + 40 : 40
        })
    }
    $(document).on('scroll', function () {
        if(window.sticky_header == true){
            Handle_Custom_Header_Sticky()
        }
    })
//Sticky Sidebar  
    if(typeof window.SimpleLightbox !== "undefined" && typeof window.SimpleLightbox !== undefined){
        var ahura_lightbox = new SimpleLightbox('.single:not(.single-product) .post-entry img, .woocommerce-Tabs-panel--description img', {
            sourceAttr: 'src',
            nav: false,
            loop: false,
        });
    }

    $('body').on('click', '.remove-fixed-message', function(e){
        e.preventDefault();
        ahuraDestroyFixedMessages(5);
    });

    $(document).on('click', '.ahura-tabs .tab-item', function(e){
        e.preventDefault();
        let btn = $(this),
            tabs = btn.parent(),
            tabTarget = btn.data('target'), 
            tabsContent = btn.parent().parent().children('.ahura-tabs-content');
        if(tabTarget){
            if(tabsContent.find(tabTarget).length > 0){
                tabs.find('.active').removeClass('active');
                tabsContent.find('.active').removeClass('.active').slideUp();

                btn.addClass('active');
                tabsContent.find(tabTarget).addClass('active').slideDown();
            }
        }
    });

    $(document).on('click', '.ahura-post-headings-navigation a', function (e) {
        e.preventDefault();
        let btn = $(this),
            id = btn.data('id'),
            num = btn.data('num'),
            tag = btn.data('tag'),
            name = btn.data('name'),
            element = $(`.post-entry ${tag}:contains('${name}')`), target;
        if(element.length){
            element.attr('id', id);
            setTimeout(function(){
                target = $('#' + id);
                $('html, body').animate({
                    scrollTop: target.offset().top - 60
                }, 2000);
            }, 100);
        }
    });

    $('body').on('click', '.ahura-element-render-head .ahura-copy-element', function(e){
        e.preventDefault();
        let btn = $(this),
            noCopyText = btn.data('nocopy-text'),
            copyText = btn.data('copy-text'),
            copiedText = btn.data('copied-text'),
            elementData = btn.data('values');

        btn.addClass('ah-loader');

        if(elementData){
            if(ahuraCopyTextToClipboard(JSON.stringify(elementData))){
                btn.text(copiedText);
            } else {
                btn.text(noCopyText);
            }
        } else {
            btn.text(noCopyText);
        }

        setTimeout(() => {
            btn.removeClass('ah-loader');
            btn.text(copyText);
        }, 3000);
    });

    let preloaderWrap = $(".ahura-pre-loader");
    if (preloaderWrap.length > 0){
        preloaderWrap.addClass("ah-hide-preloader");
    }
});