function menuclick() {
    let x = document.querySelectorAll("#siteside");
    x.forEach(el => {
        if (el.classList.contains('sitesideopen')) {
            el.classList.remove('sitesideopen');
        } else {
            el.classList.add('sitesideopen');
        }
    })
}
function mgmenuclick() {
    var x = document.getElementById("mgsiteside");
    if (x.className === "mgsiteside") {
        x.className += " mgsitesideopen";
    } else {
        x.className = "mgsiteside";
    }
}

jQuery(document).ready(function ($) {
    function close_search_modal() {
        let search_modal = $('.ahura-modal-search');
        search_modal.find('input[name=s]').val('');
        search_modal.find('#ajax_search_res').html('');
        search_modal.removeClass('show');
        $('body').removeClass('none_overflow');
    }

    // show search modal on header-mode-2
    $(document).on('click', '.header-mode-2 #action_search, .ahura-show-search-modal, .ahura-popup-search-btn-wrap a', function (e) {
        e.stopPropagation();
        e.preventDefault();
        let btn = $(this);
        $('body').addClass('none_overflow');
        if(btn.parent().parent().find('.ahura-modal-search').length){
            btn.parent().parent().find('.ahura-modal-search').addClass('show');
        } else {
            $('.ahura-modal-search').addClass('show');
        }
        setTimeout(function(){
            $('.ahura-modal-search input[name=s]').focus();
        },100);
    });
    $(document).on('click', '.ahura-modal-search .close', function (e) {
        close_search_modal();
    });
    $('.main-menu li.menu-item-has-children')
        .css({ cursor: "pointer" })
        .on('click', function (e) {
            if ($(window).width() < 1100) {
                e.preventDefault();
            }
            $(this).find('ul').toggle();
        });

    $(`<span class="open-mobile-submenu"><i class="fa fa-angle-down"></i></span>`).insertAfter($('.siteside .topmenu li.menu-item-has-children>a'))

    let open_mm_sub_item = '.topmenu li.menu-item-has-children span.open-mobile-submenu';

    if(mm_data.open_sub_with_click){
        open_mm_sub_item = open_mm_sub_item + ', .siteside .topmenu li.menu-item-has-children > a, .header-menu-side li.menu-item-has-children > a';
    }

    $(open_mm_sub_item)
        .css({ cursor: "pointer" })
        .on('click', function (e) {
            if(mm_data.open_sub_with_click){
                e.preventDefault();
            }
            let mw_this = $(this);
            let mw_menu = mw_this.parent().children('ul');
            mw_menu.toggle();
        });
    $(document).on('click', '#mw_open_side_menu', function (e) {
        e.stopPropagation();
        e.preventDefault();
        if ($(window).width() > 1100 && !$(this).parent().hasClass('desktop-show')) {
            // open menu in desktop
            $(".cats-list ul.menu").toggleClass('show_menu');
        } else {
            menuclick();
        }
    });
    $(document).on('click', '#mw_open_side_mgmenu', function (e) {
        e.stopPropagation();
        e.preventDefault();
        if ($(window).width() > 1100) {
            // open menu in desktop
            $(".cats-list ul.menu").toggleClass('show_menu');
        } else {
            mgmenuclick();
        }
    });
    $(document).on('keydown', '.ahura-modal-search', function (e) {
        if (e.which == 27) {
            close_search_modal();
        }
    });
    $(document).on('click', 'body', function (e) {
        let mw_mgmenu = $("#mgsiteside");
        if (mw_mgmenu.hasClass("mgsitesideopen")) {
            if (!$(e.target).closest('#mgsiteside').length && mw_mgmenu.is(':visible')) {
                mw_mgmenu.removeClass('mgsitesideopen');
            }
        }
        if (mw_mgmenu.hasClass('show_menu')) {
            if (!$(e.target).closest(mw_mgmenu.parent()).length) {
                mw_mgmenu.removeClass('show_menu');
            }
        }
    });

    $(document).on('click', 'body', function (e) {
        let mega_menu = $(".cats-list ul.menu");
        if (mega_menu.hasClass('show_menu')) {
            if (!$(e.target).closest(mega_menu.parent()).length) {
                mega_menu.removeClass('show_menu');
            }
        }
    });

    $(document).on('click', '.cats-list-title', function (e) {
        let mw_menu = $('.cats-list > div ul.menu');
        if (mw_menu.hasClass('mw_open')) {
            mw_close_mega_section();
        } else {
            mw_open_mega_section();
        }
    });

    function mw_open_mega_section() {
        let mw_menu = $('.cats-list > div ul.menu');
        mw_menu.addClass('mw_open');
        mw_menu.slideDown();
    }
    function mw_close_mega_section()
    {
        let mw_menu = $('.cats-list > div ul.menu');
        mw_menu.removeClass('mw_open');
        mw_menu.slideUp();
    }
    $(window).on('scroll', function () {
        if ($(document).scrollTop() > 300) {
            $("#goto-top").css('display', 'flex');
        } else {
            $("#goto-top").css('display', 'none');
        }
    });
    $(document).on('click', '#goto-top, .gotop-btn', function (e) {
        e.preventDefault();
        $("html, body").animate({ scrollTop: 0 });
    })

    //add plus for open child mega menu in mobile
    let mega_menu_item_has_children = $('.menu li.menu-item-has-children');
    mega_menu_item_has_children.append('<span id="mega_menu_plus" class="fa fa-plus"></span>');
    menu_item_has_children_span = mega_menu_item_has_children.find('span#mega_menu_plus');
    menu_item_has_children_span.on('click',function(){
        $(this).parent().children('ul').toggleClass('mega_menu_show_ul');
    });
    var menu_size = window.matchMedia('(max-width: 1100px)');
    if(menu_size.matches){
        $('.menu li').removeClass('mega_menu_hover');
    }
    $(window).resize(function () { 
        if(menu_size.matches){
            $('.menu li').removeClass('mega_menu_hover');
        }else{
            $('.menu li').addClass('mega_menu_hover');
        }
    });
    $('a.open-modal').click(function(event) {
        $(this).modal({
          fadeDuration: 10,
          fadeDelay: 0.1
        });
        return false;
    });

    $(document).on('click', '.siteside-close, .siteside-overlay', function(e) {
        if($('.sitesideopen').length > 0){
            $('.siteside').removeClass('sitesideopen');
        }
    });

    let mega_menu_wrap = $('body').find('.cats-list'),
        mega_menu_wrap_content, mega_menu_items_wrap, mega_menu_items, item, wrap;

    if(mega_menu_wrap.length && mm_data.more_menu_items_status && mm_data.more_menu_active_items_count > 0){
        mega_menu_wrap.each(function(i){
            wrap = $(this);
            mega_menu_wrap_content = wrap.children('div');
            mega_menu_items_wrap = mega_menu_wrap_content.children('ul.menu');
            mega_menu_items = mega_menu_items_wrap.children('li');
            if(mega_menu_items.length && mega_menu_items.length > mm_data.more_menu_active_items_count){
                mega_menu_items.each(function(n){
                    if(n >= mm_data.more_menu_active_items_count){
                        item = $(this);
                        item.addClass('hidden-item').hide();
                    }
                });
                if(mega_menu_items_wrap.children('li.hidden-item')){
                    mega_menu_items_wrap.append(
                        $('<li/>', {'class': 'toggle-menu-hidden-items'}).append(
                            $('<a/>', {'href': '#', text: mm_data.more_menu_items_text}).append(
                                $('<i/>', {'class': 'fas fa-angle-down'})
                            )
                        )
                    );
                }
            }
        });

        $('body').on('click', 'li.toggle-menu-hidden-items a', function(e){
            e.preventDefault();
            let btn = $(this),
                wrap = btn.parent().parent(),
                targetItems = wrap.find('li.hidden-item');
            if(targetItems.length){
                btn.parent().toggleClass('hidden-items-is-showing');
                targetItems.slideToggle();
            }
        });
    }
});

// Close Menu
var menu_close = document.getElementById('menu-close');
var menu = document.getElementById('siteside');

//handle off screen menu
const isInViewport = element => {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}
const changeSubmenuStyle = submenu => submenu.classList.add("levelF");
const submenuEl = document.querySelectorAll('#top-menu ul ul')
submenuEl.forEach(submenu => !isInViewport(submenu) ? changeSubmenuStyle(submenu) : '');

document.querySelectorAll(".topmenu ul.sub-menu").forEach((megamenu) => {
    if(!megamenu.style.backgroundImage.includes("http")) {
        megamenu.style.minHeight = "initial";
        megamenu.style.padding = "4px 7px";
    }
})
