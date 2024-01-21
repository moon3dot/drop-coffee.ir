jQuery(document).ready(function ($){
    let mm2_element = $(document).find('.mega-menu2-element');

    if(mm2_element){
        let mm2_items = document.querySelectorAll('.mm2-items li'),
            mm2_firstLi = document.querySelector('.mm2-items li'),
            mm2_wrapper = document.querySelector('.mm2-wrapper'),
            mm2_container = document.querySelector('.mm2-container'),
            mm2_overlay = document.querySelector('.mm2-overlay'),
            mm2_sub_items = document.querySelector('.mm2-sub-items');
        if(mm2_wrapper) {
            let mm2_button = mm2_wrapper.querySelector('.mm2-button')
        };

        if(mm2_items){
            mm2_items.forEach(function(li) {
                li.addEventListener('mouseover', function(event) {

                    mm2_items.forEach(function(otherLi) {
                        otherLi.classList.remove('active-menu-item');
                    });

                    let ul = Array.from(li.children).find(el => el.tagName.toLowerCase() === 'ul');

                    li.classList.add('active-menu-item');
                    mm2_sub_items.innerHTML = '';
                    mm2_sub_items.style.backgroundImage = '';

                    if (ul) {
                        let clonedUl = ul.cloneNode(true);
                        clonedUl.style.display = 'block';
                        mm2_sub_items.style.backgroundImage = clonedUl.style.backgroundImage != null ? clonedUl.style.backgroundImage : 'none';
                        mm2_sub_items.appendChild(clonedUl);
                    }
                });
            });
        }

        if (mm2_firstLi) {
            let event = new MouseEvent('mouseover', {
                view: window,
                bubbles: true,
                cancelable: true
            });
            mm2_firstLi.classList.add('active-menu-item');
            mm2_firstLi.dispatchEvent(event);
        }

        if(mm2_wrapper){
            mm2_wrapper.addEventListener('mouseover', function(e) {
                mm2_container.classList.add('mm2-show');
                mm2_container.style.display = '';

                let containerRect = mm2_container.getBoundingClientRect();

                mm2_overlay.style.top = containerRect.top + 'px';
                mm2_overlay.style.display = 'block';
            });
        }

        let mm2_mouseout_callback = function() {
            mm2_container.classList.remove('mm2-show');
            mm2_overlay.style.display = 'none';
        }

        if(mm2_wrapper){
            mm2_wrapper.addEventListener('mouseout', mm2_mouseout_callback);
        }

        if(mm2_overlay){
            mm2_overlay.addEventListener('mouseover', mm2_mouseout_callback);
        }

        /**
         *
         *
         * Mobile menu
         *
         *
         */

        let mm2_side_toggle_callback = function(element) {
            let mm2_side_container = element;
            mm2_side_container.css('opacity', '');
            if(mm2_side_container.hasClass('mm2-side-show')){
                mm2_side_container.removeClass('mm2-side-show');
            } else {
                mm2_side_container.removeClass('mm2-side-show');
                mm2_side_container.addClass('mm2-side-show');
            }
        }

        $(document).on('click', '.mm2-side-button', function(e){
            e.preventDefault();
            let btn = $(this),
                mm2_side_container = btn.parent().find('.mm2-side-container');
            mm2_side_toggle_callback(mm2_side_container);
        });

        $(document).on('click', '.mm2-side-overlay, .mm2-close-btn', function(e){
            e.preventDefault();
            let mm2_side_container = $('.mm2-side-container');
            mm2_side_toggle_callback(mm2_side_container);
        });

        $(document).on('click', '.mm2-side-container li > span', function(e){
            e.preventDefault();
            if($(this).parent().hasClass('is-toggled')){
                $(this).parent().removeClass('is-toggled');
            } else {
                $(this).parent().addClass('is-toggled');
            }
        });
    }
});