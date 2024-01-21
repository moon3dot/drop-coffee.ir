const ahuraHandleRelatedProductsSlider = function (params){
    if(jQuery(document).find('.product-related-slider').length){
        jQuery('.product-related-slider .products').owlCarousel({
            loop:false,
            margin:10,
            responsiveClass:true,
            autoplay:true,
            autoplayTimeout:4000,
            rtl: document.body.classList.contains('rtl') ? true : false,
            navText: [
                '<i class="fas fa-angle-left"></i>',
                '<i class="fas fa-angle-right"></i>'
            ],
            responsive:{
                0:{
                    items: params.mobileItems,
                    nav: params.showNav
                },
                600:{
                    items: params.mobileItems,
                    nav: params.showNav
                },
                1000:{
                    items: params.desktopItems,
                    nav: params.showNav,
                    loop: false
                }
            }
        })
    }
}

jQuery(document).ready(function($){
    var mw_qty_mode = {};
    mw_qty_mode.increase = function(mw_qty_input)
    {
        let cu_value = mw_qty_input.val(),
            new_value = parseInt(cu_value) + 1;
        mw_qty_input.val(new_value);
    }
    mw_qty_mode.decrease = function(mw_qty_input)
    {
        let cu_value = mw_qty_input.val(),
            new_value = parseInt(cu_value) - 1;
        if(new_value <= 0)
        {
            return false;
        }
        mw_qty_input.val(new_value);
    }
    function mw_change_qty(mw_qty_input, mode)
    {
        let cu_value = parseInt(mw_qty_input.val()),
            new_value = '';
        switch(mode)
        {
            case 'increase':
                new_value = cu_value + 1;
                break;
            case 'decrease':
                new_value = (cu_value <= 1) ? 1 : cu_value - 1;
                break;
        }

        mw_qty_input.val(new_value);
        mw_qty_input.trigger('change');
    }
    $(document).on('click', '.mw_qty_btn', function (e) {
        e.preventDefault();
        let mw_this = $(this),
            mw_qty_input = mw_this.parent().find('input[type=number].qty'),
            mw_mode = mw_this.data('mw_qty_mode');
        mw_change_qty(mw_qty_input, mw_mode);
    });

    $(document).on('change', '.quantity .qty', function (e) {
        let $this = $(this),
            minVal = $this.attr('min'),
            maxVal = $this.attr('max'),
            incBtn = $this.parent().find('.mw_increasr'),
            decBtn = $this.parent().find('.mw_decrease'),
            isSingle = (parseInt(minVal) == 1 && parseInt(maxVal) == 1);
            inputVal = $this.val();
        if(inputVal <= 0 || isSingle){
            $this.val(1);
            if(isSingle){
                incBtn.addClass('disabled');
                decBtn.addClass('disabled');
                return false;
            } else {
                incBtn.removeClass('disabled');
                decBtn.removeClass('disabled');
            }
        } else {
            $this.val(parseInt($this.val()));
        }
        if(inputVal <= 1){
            decBtn.addClass('disabled');
        } else {
            decBtn.removeClass('disabled');
        }
        if(maxVal !== undefined && parseInt(maxVal) > 0){
            if(inputVal == parseInt(maxVal) || inputVal > parseInt(maxVal)){
                $this.val(parseInt(maxVal));
                incBtn.addClass('disabled');
            } else {
                incBtn.removeClass('disabled');
            }
        }
    });

    /**
     * 
     * 
     * Product single custom gallery zoom efect
     * 
     * 
     */
     function ahuraWooDataZoom() {
        $('.product-gallery-slider .woocommerce-product-gallery__image').on('mouseenter mouseleave',function () {
            $(this).attr('data-scale', '1.7');
            var img = $(this).find('img').attr('src');
            $(this).attr('data-image', img);
        });
    }

    function ahuraWooZoomFunction() {
        $('.product-gallery-slider .woocommerce-product-gallery__image')
            .on('mouseover', function () {
                $(this).children('.zoom-photo').css({ 'transform': 'scale(' + $(this).attr('data-scale') + ')' });
            })
            .on('mouseout', function () {
                $(this).children('.zoom-photo').css({ 'transform': 'scale(1)' });
            })
            .on('mousemove', function (e) {
                $(this).children('.zoom-photo').css({ 'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%' });
            })
            .each(function () {
                var photoLength = $(this).find('.zoom-photo').length;
                if (photoLength === 0) {
                    $(this)
                        .append('<div class="zoom-photo"></div>')
                        .children('.zoom-photo').css({ 'background-image': 'url(' + $(this).find('img').attr('src') + ')' });
                }
            });
    }

    function ahuraWooZoomEffect() {
        $(document).on('click', '.product-gallery-slider .woocommerce-product-gallery__image', function () {
            ahuraWooZoomFunction();
        });
        $(".product-gallery-slider .woocommerce-product-gallery__image").on({
            mouseenter: function () {
                ahuraWooZoomFunction();
            },
            mouseleave: function () {
                ahuraWooZoomFunction();
            }
        });
    }

    ahuraWooDataZoom();
    ahuraWooZoomEffect();

    let more_seller_products = $('#tab-more_seller_product > .product');
    if(more_seller_products.length){
        more_seller_products.parent().addClass('is-direct-products');
    }

    $(document).on('click', '.ah-single-sticky-cart-variables-toggle-btn', function (e){
        e.preventDefault();
        let btn = $(this),
            variationsWrap = btn.parent().find('.variations');
        variationsWrap.slideToggle();
    });

    let stickyAddToCartWrap = $('.ahura-sticky-basket-area');
    if (stickyAddToCartWrap.length){
        $(window).scroll(function() {
            if (window.innerWidth > 767){
                stickyAddToCartWrap.removeClass('show-cart-button');
                return false;
            }

            if ($(window).scrollTop() >= $('.ahura_woocommerce_content_wrapper .single_add_to_cart_button').offset().top) {
                stickyAddToCartWrap.addClass('show-cart-button');
            } else {
                stickyAddToCartWrap.removeClass('show-cart-button');
            }
        });
    }
});


document.querySelector('#more-attributes-toggle').addEventListener('click', () => {
    if(document.querySelector('#more-attributes-toggle').checked ) {
        document.querySelector('.shop_attributes label.less').style.display = 'block';
        document.querySelector('.shop_attributes label.more').style.display = 'none';
    } else {
        document.querySelector('.shop_attributes label.less').style.display = 'none';
        document.querySelector('.shop_attributes label.more').style.display = 'block';
    }
});