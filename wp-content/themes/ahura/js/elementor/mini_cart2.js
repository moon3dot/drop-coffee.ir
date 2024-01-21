jQuery(document).ready(function ($){
    $(document).on('click', '.add_to_cart_button.ajax_add_to_cart', function (e){
        let selector = $(this),
            product_id = selector.data('product_id') || 0,
            cart_wrap = $('.mini-cart2-element'),
            counter = cart_wrap.find('.mc2-count'),
            cart_content = cart_wrap.find('.mc2-container'),
            count = 0;

        let add_interval = setInterval(() => {
            if(selector.hasClass('added')){
                $.ajax({
                    url: mc2_data.ajax_url,
                    data: {
                        action: 'ahura_update_mini_cart2_element',
                        product_id: product_id
                    },
                    type: 'POST',
                    complete: function(res){
                        if(res){
                            if(res.responseText !== '' || res.responseText !== null){
                                cart_content.html(res.responseText);
                                $('.mini-cart2-element .cart-item .cart-item-quantity').each(function() {
                                    let value = parseInt($(this).text(), 10);

                                    if(!isNaN(value) && value > 0) {
                                        count += value;
                                    }
                                });
                                if(count <= 0){
                                    counter.css('opacity', 0);
                                } else {
                                    counter.css('opacity', 1);
                                }
                                counter.text(count);
                            } else {
                                location.reload();
                            }
                        } else {
                            location.reload();
                        }
                    }
                });
                clearInterval(add_interval);
            }
        }, 850);
    });

    $(document).on('click', '.mini-cart2-element .cart-item-action-btn .remove', function (e){
        e.preventDefault();

        let selector = $(this),
            product_id = selector.data('product_id') || 0,
            item_key = selector.data('item_key') || 0,
            cart_wrap = $('.mini-cart2-element'),
            counter = cart_wrap.find('.mc2-count'),
            cart_content = cart_wrap.find('.mc2-container'),
            count = 0;

        $.ajax({
            url: mc2_data.ajax_url,
            data: {
                action: 'ahura_update_mini_cart2_element',
                'product_id': product_id,
                'item_key': item_key,
                'delete_product': true
            },
            type: 'POST',
            beforeSend: function (){
                selector.css({
                  'opacity': 0.5,
                  'filter': 'grayscale(1)',
                  'pointer-events': 'none'
                });
            },
            complete: function(res){
                selector.css({
                    'opacity': 1,
                    'filter': 'grayscale(0)',
                    'pointer-events': 'all'
                });
                if(res){
                    if(res.responseText !== '' || res.responseText !== null){
                        cart_content.html(res.responseText);
                        $('.mini-cart2-element .cart-item .cart-item-quantity').each(function() {
                            let value = parseInt($(this).text(), 10);

                            if(!isNaN(value) && value > 0) {
                                count += value;
                            }
                        });
                        if(count <= 0){
                            counter.css('opacity', 0);
                        } else {
                            counter.css('opacity', 1);
                        }
                        counter.text(count);
                    } else {
                        location.reload();
                    }
                } else {
                    location.reload();
                }
            },
            error: function (){
                selector.css({
                    'opacity': 1,
                    'filter': 'grayscale(0)',
                    'pointer-events': 'all'
                });
            }
        });
    });

    $(document).on('mouseover', '.mini-cart2-element', function (){
        let btn = $(this),
            box = btn.parent().find('.mc2-container');

        if(window.innerWidth <= 1024){
            return false;
        }

        box.fadeIn();
    });

    $(document).on('mouseleave', '.mini-cart2-element', function (){
        let btn = $(this),
            box = btn.parent().find('.mc2-container');

        box.fadeOut();
    });
});