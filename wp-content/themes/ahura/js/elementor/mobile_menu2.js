jQuery(document).ready(function ($){
    let mobile_menu2_element = $(document).find('.mobile-menu2-element');
    if(mobile_menu2_element){
        let menu2_side_toggle_callback = function() {
            let mobile_menu2_side_container = $('.mmenu2-side-container');
            mobile_menu2_side_container.css('opacity', '');
            if(mobile_menu2_side_container.hasClass('mmenu2-side-show')){
                mobile_menu2_side_container.removeClass('mmenu2-side-show');
            } else {
                mobile_menu2_side_container.removeClass('mmenu2-side-show');
                mobile_menu2_side_container.addClass('mmenu2-side-show');
            }
        }

        $(document).on('click', '.mmenu2-side-button, .mmenu2-side-overlay, .mmenu2-close-btn', function(e){
            e.preventDefault();
            menu2_side_toggle_callback();
        });

        $(document).on('click', '.mmenu2-side-container li > span', function(e){
            e.preventDefault();
            if($(this).parent().hasClass('is-toggled')){
                $(this).parent().removeClass('is-toggled');
            } else {
                $(this).parent().addClass('is-toggled');
            }
        });
    }
});