jQuery(document).ready(function ($) {
    let videos = $('body:not(.elementor-page) video');

    videos.each(function (index) {
        let video_src = $(this).attr('src');
        if(typeof video_src !== "undefined" && video_src != ""){
            let video_cover = $(this).attr('poster');
            $(this).replaceWith(`
            <div class="ahura_player">
                <video src="${video_src}" poster="${video_cover}"></video>
                <div class="video_controls">
                    <div class="video_controls_wrapper">
                        <div class="video_controls_top">
                        <input type="range" min="0" value="0" class="current_time"/>
                    </div>
                        <div class="video_controls_left">
                            <div class="video_play"><i class="fa fa-play"></i></div>
                            <div class="video_pause"><i class="fa fa-pause"></i></div>
                            <div class="video_audio_wrapper"><input type="range" class="video_audio" step="0.1" min="0" max="1" value="0.9"/> <i class="fa fa-volume-up"></i></div>
                            <span class="video_timer"><i class="video_time_duration">00:00</i> / <i class="video_time_current">00:00</i></span>
                        </div>
                        <div class="video_controls_right">
                            <div class="video_fullscreen"><i class="fa fa-expand"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            `)
            let player = $('.ahura_player')
            delete videos
            let videos = $('.ahura_player video')
            player.each(function(){

                let currentVideo = $(this).find('video')
                let controls = $(this).find('.video_controls')
                let play = $(controls).find('.video_play')
                let pause = $(controls).find('.video_pause')
                let full_screen = $(controls).find('.video_fullscreen')
                let audio = $(controls).find('.video_audio')
                let videoTime = $(controls).find('.currentTime')
                let video_Time = $(controls).find('.current_time')
                let current_timer = $(controls).find('.video_time_current')
                let duration_timer = $(controls).find('.video_time_duration')

                $(currentVideo).on('timeupdate',function(){
                    $(videoTime).val(videos[index].currentTime)
                    $(video_Time).val(videos[index].currentTime)

                    const videoCureent = Math.round(videos[index].currentTime);
                    const time_cureent = formatTime(videoCureent)
                    current_timer.text(time_cureent.minutes + ':' + time_cureent.seconds)
                })
                $(currentVideo).on('loadedmetadata',function(){
                    const videoDuration = Math.round(videos[index].duration)
                    const time_duration = formatTime(videoDuration)
                    duration_timer.text(time_duration.minutes + ':' + time_duration.seconds)
                })
                $(currentVideo).on('loadedmetadata', function() {
                    $(videoTime).attr('max', videos[index].duration);
                    $(video_Time).attr('max', videos[index].duration);
                });
                $(video_Time).on('change input',function(){
                    videos[index].currentTime = $(this).val()
                })
                $(currentVideo).on('click', function () {
                    if (videos[index].paused) {
                        currentVideo.trigger('play')
                        HandleStartVideoCss()
                    } else {
                        currentVideo.trigger('pause')
                        HandleStopVideoCss()
                    }
                })
                $(currentVideo).dblclick(function(){
                    if(document.fullscreenElement){
                        document.exitFullscreen()
                    }
                    let video = document.getElementsByClassName('ahura_player')[0]
                    if (!video.fullscreenElement) {
                        video.requestFullscreen();
                    }else if (!video.webkitRequestFullscreen) {
                        video.webkitRequestFullscreen();
                    }else if (!video.msRequestFullscreen) {
                        video.msRequestFullscreen();
                    }
                })
                $(play).on('click', function () {
                    currentVideo.trigger('play')
                    HandleStartVideoCss()
                })
                $(pause).on('click', function () {
                    currentVideo.trigger('pause')
                    HandleStopVideoCss()
                })
                $(full_screen).on('click', function (i) {
                    if(document.fullscreenElement){
                        document.exitFullscreen()
                    }else{
                        document.getElementsByClassName('ahura_player')[0].requestFullscreen()
                    }
                })
                $('.video_audio_wrapper').find('i').on('click',function(){
                    if(videos[index].volume != 0){
                        videos[index].volume = 0
                        $(this).removeClass('fa-volume-up')
                        $(this).addClass('fa-volume-mute')
                        $(audio).val(0)
                    }else{
                        videos[index].volume = 0.9
                        $(this).removeClass('fa-volume-mute')
                        $(this).addClass('fa-volume-up')
                        $(audio).val(0.9)
                    }
                })
                $(audio).on('change input', function () {
                    let video = videos[index]
                    video.volume = $(this).val()
                })
                $(currentVideo).on('mouseover',function(e){
                    let timeout
                    let x = e.clientX
                    let y = e.clientY
                    $(currentVideo).on('mousemove',function(w){
                        let x1 = w.clientX
                        let y1 = w.clientY
                        clearTimeout(timeout)
                        timeout = setTimeout(function(){
                            if(x == x1 && y == y1){
                                HandleHideVideoControlsCss()
                            }else{
                                clearTimeout(timeout)
                                setTimeout(function(){
                                    HandleHideVideoControlsCss()
                                },3000)
                            }
                        }, 3000)
                    })
                    $(currentVideo).on('mousemove',function(){
                        HandleVisibleVideoControlsCss()
                    })
                })
                $(videos[index]).on('ended',function(){
                    HandleStopVideoCss()
                })

                $(currentVideo).on('error',function(e){
                    if(e.target.error){
                        $('.ahura_player').html(ahura_player.msg.no_video).addClass('no-video')
                    }
                })

                function HandleStartVideoCss(){
                    $(play).css('display','none')
                    $(pause).css('display','flex')
                }

                function HandleStopVideoCss(){
                    $(play).css('display','flex')
                    $(pause).css('display','none')
                }
                function HandleHideVideoControlsCss(){
                    $(controls).removeClass('show-video-controls')
                }
                function HandleVisibleVideoControlsCss(){
                    $(controls).addClass('show-video-controls')
                }
                function formatTime(timeInSeconds){
                    const result = new Date(timeInSeconds * 1000).toISOString().substr(11,8)
                    return {
                        minutes: result.substr(3, 2),
                        seconds: result.substr(6, 2),
                    };
                }
            })
        }
    })
})