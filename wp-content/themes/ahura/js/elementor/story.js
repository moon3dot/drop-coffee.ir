jQuery(document).ready(function($){
    let story_swiper = null,
        progress_start = true;

    $(document).on('click', '.story-element .story', function(){
        let story = $(this),
            count = parseInt(story.data('count')),
            widgetID = story.data('wid'),
            wrapEl = $('.story-element-gallery-wrap-' + widgetID),
            selected_index = $(`.story-element-gallery-wrap-${widgetID} .story-image[data-id="${story.data('id')}"]`).parent().index() || 0,
            img = story.find('img');

        img.addClass('story-rescale');
        ahuraSetCookie(`story_seen_${widgetID}_${story.data('id')}`, true);

        setTimeout(() => {
            img.removeClass('story-rescale');
            story.find('svg').addClass('stroke-animation');

            setTimeout(() => {
                story.addClass('seen');
                story.find('svg').removeClass('stroke-animation');

                if (count <= 0)
                    return false;

                wrapEl.addClass('show');

                let story_progressbar = $(`.story-element-gallery-${widgetID} .story-progressbar > div > div`), i = 0;
                let progress_init = function () {
                    i = 0;
                    if(progress_start === false){
                        return false;
                    }
                    story_progressbar.css('width', 0);
                    let start_progress = setInterval(() => {
                        i++;
                        story_progressbar.css('width', i + '%');
                        if(i === 100){
                            i = 0;
                            setTimeout(() => {
                                progress_init()
                            }, 500);
                            clearInterval(start_progress);
                        }
                    }, 50);
                };

                if (!wrapEl.hasClass('slider-init')){
                    wrapEl.addClass('slider-init');

                    story_swiper = new Swiper(".story-element-gallery-" + widgetID, {
                        loop: false,
                        grabCursor: true,
                        autoHeight: true,
                        navigation: {
                            nextEl: ".swiper-button-next",
                            prevEl: ".swiper-button-prev",
                        },
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                        },
                        on: {
                            slideChange(){
                                i = 0;
                                let item = $(this.slides[this.activeIndex]),
                                    item_img_wrap = item.find('.story-image'),
                                    story_el = $('.story.elementor-repeater-item-' + item_img_wrap.data('id'));
                                if(!story_el.hasClass('seen')){
                                    story_el.addClass('seen');
                                    ahuraSetCookie(`story_seen_${item_img_wrap.data('wid')}_${item_img_wrap.data('id')}`, true);
                                }
                            },
                            slideChangeTransitionEnd(swiper){
                                if (this.isEnd && this.activeIndex === this.slides.length - 1) {
                                    setTimeout(function () {
                                        $('.story-element-gallery-wrap-' + story.data('wid')).removeClass('show');
                                    }, 5000);
                                }
                            },
                        }
                    });
                }

                story_swiper.on('init', function () {
                    if(!this.autoplay.paused && this.slides.length > 1){
                        progress_init();
                    }
                });

                story_swiper.on('slideChange', function () {
                    if (selected_index > 0 && this.activeIndex === selected_index) {
                        progress_start = false;
                        this.autoplay.stop();
                    } else {
                        this.autoplay.start();
                    }
                });

                story_swiper.slideTo(selected_index);
            }, 7000);
        }, 100);
    });

    $(document).find('.story-element-item').each(function (i) {
        let item = $(this);
        if (ahuraCheckCookie(`story_seen_${item.data('wid')}_${item.data('id')}`)) {
            item.addClass('seen');
        }
    });

    $(document).on('click', '.close-overlay, .close-story', function () {
        $('.story-element-gallery-wrap').removeClass('show');
    });
});
