jQuery(document).ready(function ($){
    if($(document).find('.menu2-element')){
        let menu2_element = document.querySelector('.menu2-element');

        if(menu2_element){
            let menu2_items = menu2_element.querySelectorAll('.menu2-wrapper li'),
                menu2_indicator = menu2_element.querySelector('.menu-items-indicator');

            menu2_items.forEach(function(li) {
                li.addEventListener('mouseover', function(event) {
                    menu2_indicator.style.width = li.offsetWidth  + 'px';
                    menu2_indicator.style.left = li.offsetLeft + 'px';
                });

                li.addEventListener('mouseout', function(event) {
                    menu2_indicator.style.width = '0';
                });
            });
        }

        /**
         *
         *
         * Mobile menu
         *
         *
         */

        let menu2_side_toggle_callback = function(element) {
            let menu2_side_container = element;
            menu2_side_container.css('opacity', '');
            if(menu2_side_container.hasClass('menu2-side-show')){
                menu2_side_container.removeClass('menu2-side-show');
            } else {
                menu2_side_container.removeClass('menu2-side-show');
                menu2_side_container.addClass('menu2-side-show');
            }
        }

        $(document).on('click', '.menu2-side-button', function(e){
            e.preventDefault();
            let btn = $(this),
                menu2_side_container = btn.parent().find('.menu2-side-container');
            menu2_side_toggle_callback(menu2_side_container);
        });

        $(document).on('click', '.menu2-side-overlay, .menu2-close-btn', function(e){
            e.preventDefault();
            let menu2_side_container = $('.menu2-side-container');
            menu2_side_toggle_callback(menu2_side_container);
        });

        $(document).on('click', '.menu2-side-container li > span', function(e){
            e.preventDefault();
            if($(this).parent().hasClass('is-toggled')){
                $(this).parent().removeClass('is-toggled');
            } else {
                $(this).parent().addClass('is-toggled');
            }
        });
    }
});