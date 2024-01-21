jQuery('document').ready(function($){
    $(document).on('click', '.ahura_elementor_modal_video_wrapper .ah-modal-video-btn', function(e){
        e.preventDefault()
        let el = $(this),
            modal = el.closest('.ahura_elementor_modal_video_wrapper').find('.ah-modal-box'),
            videoWrapper = el.closest('.ahura_elementor_modal_video_wrapper').find('.ah-video')
        modal.fadeIn('fast', function(e){
            videoWrapper.fadeIn('slow', function(e){
                videoWrapper.find('video').trigger('play')
            })
        })
    })

    $(document).on('click', '.ahura_elementor_modal_video_wrapper .ah-modal-box', function(e){
        let el = $(this),
            videoWrapper = el.closest('.ahura_elementor_modal_video_wrapper').find('.ah-video')
        videoWrapper.find('video').trigger('pause')
        videoWrapper.fadeOut('fast', function(e){
            el.fadeOut()
        })
    })
})