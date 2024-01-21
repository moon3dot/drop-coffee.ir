jQuery(document).ready(function($){
    let templateName = 'product-quick-view-template', templateEl;

    const quickViewProductTemplate = () => ({
        build: function(){
            templateEl = $('#' + templateName);
            if(!templateEl.length){
                $('body').append(
                    $('<div/>', {id: templateName, class: 'woocommerce single-product'})
                );
            } else {
                templateEl.empty();
            }
        },
        show: function(content){
            setTimeout(function (){
                $('#' + templateName).addClass('show-quick-view').html(content);

                $('#' + templateName).find('.variations_form').wc_variation_form();

                try{
                    let quickProductThumbCarousel = new Swiper(".ah-quick-product-thumb-carousel", {
                        spaceBetween: 5,
                        slidesPerView: 5,
                        freeMode: true,
                        watchSlidesProgress: false,
                    });

                    let quickProductCarousel = new Swiper(".ah-quick-product-carousel", {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        thumbs: {
                            swiper: quickProductThumbCarousel,
                        },
                    });
                } catch (e) {}
            }, 200);
        },
        hide: function(){
            $('#' + templateName).removeClass('show-quick-view');
        },

        showLoader: function (){
            $('.ah-quick-product-loader').fadeIn();
        },

        hideLoader: function (){
            $('.ah-quick-product-loader').fadeOut();
        },
    });

    $(document).on('click', '.product-preview-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            productID = btn.data('id'),
            templateEl = $('body').find('#' + templateName);

        $.ajax({
            url: ahura_data.au,
            data: {
                action: 'ahura_quick_view_product_data',
                product_id: productID
            },
            type: 'POST',
            beforeSend: function (){
                quickViewProductTemplate().showLoader();
                quickViewProductTemplate().build();
            },
            complete: function (res){
                res = res.responseText;
                quickViewProductTemplate().hideLoader();
                if(res){
                    quickViewProductTemplate().show(res);
                }
            },
            error: function (){
                quickViewProductTemplate().hideLoader();
                quickViewProductTemplate().hide();
            }
        })
    });

    $(document).on('click', 'body', function (e) {
        let wrap = $('.ah-quick-product');
        if (!$(e.target).closest(wrap).length) {
            quickViewProductTemplate().hide();
        }
    });

    $(document).on('click', '.ah-close-quick-product', function (e) {
        e.preventDefault();
        quickViewProductTemplate().hide();
    });
});