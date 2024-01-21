const handleVideoCarouselElement = function (params){
	if (typeof window.Swiper != undefined) {
		let vid_swiper = new Swiper(`.video-carousel-${params.widgetID}`, {
			loop: params.loop,
			slidesPerView: params.mobilePerView,
			spaceBetween: 15,
			centeredSlides: true,
			navigation: {
				nextEl: `.video-carousel-${params.widgetID} .video-carousel-button-next`,
				prevEl: `.video-carousel-${params.widgetID} .video-carousel-button-prev`,
			},
			rtl: jQuery('body').hasClass('rtl'),
			breakpoints: {
				400: {
					slidesPerView: params.mobilePerView,
				},
				600: {
					slidesPerView: params.tabletPerView,
					spaceBetween: 15
				},
				1000: {
					slidesPerView: params.slidesPerView,
					spaceBetween: 20
				},
			}
		});
	}
}

jQuery(document).ready(function($){
    $('body').on("click", ".video-carousel .play", function (e) {
        e.preventDefault();
        let $this = $(this),
            wrap = $this.parent().parent(),
            vid_src = $this.data('src'),
            $modal = $(document).find('#videoModal-' + $this.data('wid'));
        if (vid_src !== undefined) {
			if(!$modal.find('video').length){
				setTimeout(function(){
					$modal.append('<video controls><source src="" type="video/mp4"></video>');
					$modal.find('.ahura_player').remove();
                }, 100);
			}
			setTimeout(function(){
				 $modal.find('source').attr('src', vid_src);
				if($modal.find('video').length){
					$modal.find('video')[0].load();
				}
				$modal.modal({fadeDuration: 100});
				if($modal.find('video').length){
					setTimeout(function(){
						$modal.find('video').get(0).play();
					}, 100);
				}
            }, 110);
        } else {
            if (wrap.find('.video-box').length > 0) {
                wrap.find('.bp').slideUp();
                wrap.find('.ap').slideDown();
                wrap.find('video').get(0).play();
            } else {
                wrap.find('.ap').slideUp();
                wrap.find('.bp').slideDown();
            }
        }
    });

    $('body').on("click", ".videoModal .close-modal", function (e) {
        e.preventDefault();
        let $this = $(this),
            wrap = $this.parent().parent(),
            $modal = $('.videoModal');
        if ($modal.find('video').length) {
            $modal.find('video').get(0).pause();
        }
    });

    $(document).on("click", function (e) {
        if ($(e.target).closest('.videoModal').length === 0) {
			if($('.videoModal video').length){
				$('.videoModal video').get(0).pause();
			}
        }
    });

	if(typeof vid_swiper !== "undefined"){
		vid_swiper.on('slideChange', function () {
			let $this = $('.video-carousel');
			$this.find('.ap').slideUp();
			$this.find('.bp').slideDown();
			$this.find('video').each(function () {
				$(this).get(0).pause();
			});
		});
	}
})