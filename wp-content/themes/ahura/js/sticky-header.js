window.canAutoHide = false;
window.lastScrollTop = 0;
window.sticky_header = true;
var body = jQuery('body'),
	headerWrap = jQuery('#ahura-header-main-wrap'),
	topbar = jQuery('.topbar'),
    hideOnScrollEl = topbar.find('.hide_in_scroll'),
	topbar_el = document.querySelector('.topbar'),
	topbarHeight = topbar.outerHeight(),
	stickyElToggle, scrollTo;

jQuery(document).ready(function($){
    headerWrap.css('height', `${topbarHeight}px`);
    topbar.addClass('sticky-topbar');

    let only_desktop = sticky_header_data.only_desktop == true ? window.innerWidth > 1267 : true;

    if(topbar_el && only_desktop){
        if(sticky_header_data.scrolling_top_show){
            // wheel event : Work in desktop
            $(document).on('wheel', function(e) {
                if(document.body.scrollTop > topbar.innerHeight() || document.documentElement.scrollTop > topbar.innerHeight()){
                    if (e.deltaY < 0){
                        topbar_el.classList.remove('header-sticky-hide');
                        topbar_el.classList.add('header-sticky-show');
                    } else if(e.deltaY > 0){
                        topbar_el.classList.remove('header-sticky-show');
                        topbar_el.classList.add('header-sticky-hide');
                    }
                } else {
                    topbar_el.classList.remove('header-sticky-show');
                    topbar_el.classList.remove('header-sticky-hide');
                }
            });
        }

        $(window).on('scroll', function() {
            let headStick = $('.topbar');

            if (!headStick.data('isAnimated') && (document.body.scrollTop > 70 || document.documentElement.scrollTop > 70)) {
                let adminbar = $('#wpadminbar'),
                    distance = headStick.position().top - (adminbar.length ? adminbar.outerHeight() : 0);

                if(window.innerWidth >= 1024 && distance > 0){
                    if(headStick.hasClass('is-box-mode')){
                        let transformX = 'translateX(50%)';
                        if(window.innerWidth <= 1024){
                            transformX = '';
                        }
                        headStick.css({transform: `translateY(-${distance}px) ` + transformX, 'transition': 'ease .3s'});
                    } else {
                        headStick.css('transform', `translateY(-${distance}px)`);
                    }
                } else if(window.innerWidth <= 1024) {
                    headStick.css('top', '0');
                }

                headStick.data('isAnimated', true);
            }
        });

        window.addEventListener('scroll', function(e) {
            window.canAutoHide = true;
            e.stopPropagation();

            stickyElToggle = $('.scrolled-topbar:not(.header-mode-2) .top-menu, .scrolled-topbar .cats-list .cats-list-title:not(.in_custom_header), .scrolled-topbar .cats-list ul.menu:not(.in_custom_header ul.menu)');
            if(document.body.scrollTop > topbar.innerHeight() || document.documentElement.scrollTop > topbar.innerHeight()){
                topbar.addClass('scrolled-topbar');

                topbar.find('.show-in-sticky').slideDown();
                topbar.find('.hide-in-sticky').slideUp();
                if(topbar.find('.header-menu-sticky').length > 0){
                    topbar.find('.topmenu-wrap').hide();
                    topbar.find('.header-menu-sticky').show();
                }
                stickyElToggle.slideUp();
                if(sticky_header_data.scrolling_top_show){
                    topbar.addClass('header-sticky-hide');
                }
                hideOnScrollEl.slideUp();
            } else {
                if(window.innerWidth <= 1024){
                    topbar.css('top', '');
                } else {
                    topbar.css('transform', '');
                }
                topbar.data('isAnimated', false);
                hideOnScrollEl.slideDown();
                stickyElToggle.slideDown();
                topbar.removeClass('scrolled-topbar');
                if(topbar.find('.header-menu-sticky').length > 0){
                    topbar.find('.topmenu-wrap').show();
                    topbar.find('.header-menu-sticky').hide();
                }
                topbar.find('.hide-in-sticky').slideDown();
                topbar.find('.show-in-sticky').slideUp();
                if(sticky_header_data.scrolling_top_show){
                    topbar.removeClass('header-sticky-hide header-sticky-show');
                }
            }
        });
    } else {
        topbar.removeClass('scrolled-topbar sticky-topbar');
    }
});

function ahuraHeaderAutoHide() {
	var scrollTop = jQuery(window).scrollTop(),
		mainEl = jQuery('.ahura-main-header, #topbar');

	// Header scrolling top show / Work in mobile
	if (mainEl.hasClass('scrolled-topbar')) {
		if (scrollTop > window.lastScrollTop + 20 && mainEl.hasClass('header-sticky-show')) {
			topbar_el.classList.remove('header-sticky-show');
			topbar_el.classList.add('header-sticky-hide');
		} else if (scrollTop < window.lastScrollTop - 40 && !mainEl.hasClass('header-sticky-show')) {
			topbar_el.classList.remove('header-sticky-hide');
			topbar_el.classList.add('header-sticky-show');
		}
	}

	window.lastScrollTop = scrollTop;
}

if(sticky_header_data.scrolling_top_show){
	setInterval(function () {
		if (window.canAutoHide) {
			ahuraHeaderAutoHide();
			window.canAutoHide = false;
		}
	}, 150);
}