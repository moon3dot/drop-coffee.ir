jQuery(document).ready(function($){
    let playerOpt = {
        src: [''],
        preload: false,
        autoplay: false,
        loop: false,
        html5: true,
    },
    audioPlayer = new Howl(playerOpt),
    countdown = null, 
    intervals = [],
    playerElements = $('body').find('.ahura-sound-player'),
    playerBtnElements = playerElements.find('.sound-btn-playing'),
    playerInterval;

    if(audioPlayer){
        audioPlayer.stop();
    }

    $(window).bind('beforeunload', function(){
        ahuraDeleteCookie('audio_src');
        ahuraDeleteCookie('audio_hash');
    });

    if($('.ahura-sound-player.has-loader').length > 0){
        setTimeout(function(){
            $('.ahura-sound-player.has-loader').removeClass('has-loader');
        }, 2000);
    }

    if(playerBtnElements.length > 0){
        playerBtnElements.each(function(i){
            let el = $(this),
                pid = el.data('player-id'),
                btnHash = el.data('hash'),
                saveAudio = ahura_elementor_players_data[`player_${pid}`] ? (ahura_elementor_players_data[`player_${pid}`].save_audio == true) : false;
            if(!saveAudio){
                ahuraSetCookie(`player_${pid}_audio_` + btnHash, 0);
            }
        });
    }

    $('body').on('click', '.ahura-sound-player .sound-btn-play.in-playlist', function (e){
        e.preventDefault();
        let btn = $(this);
        if (btn.hasClass('in-playlist')){
            $('body').find('.sound-btn-playing').removeClass('sound-btn-pause').addClass('sound-btn-play');
            if(audioPlayer){
                audioPlayer.stop();
                if(playerInterval){
                    playerInterval.stop();
                }
                if(countdown){
                    countdown.stop();
                }
            }
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-play', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            audioTitle = btn.data('title'),
            audioSubTitle = btn.data('subtitle'),
            audioCover = btn.data('cover'),
            audioLen = btn.data('length'),
            audioPriDur = btn.data('duration'),
            soundWrap = $('body').find(`.sound-player-${playerID}`),
            rangeInput = soundWrap.find('.sound-timer-line input[type="range"]'),
            saveAudio = ahura_elementor_players_data[`player_${playerID}`] ? (ahura_elementor_players_data[`player_${playerID}`].save_audio == true) : false,
            audio = btn.data('audio'),
            audioHashName, audioSeek, audioCurrentSeek, audioCurrentDur, progressLine, audioDur;

        audioPlayer.off();

        if(playerInterval){
            playerInterval.stop();
        }
        if(countdown){
            countdown.stop();
        }

        if(audio && audio !== undefined){
            audioPlayer.stop();

            $('body').find('.ahura-sound-player .sound-btn-pause').removeClass('sound-btn-pause').addClass('sound-btn-play');
            $('body').find('.ahura-sound-player.is-playing').removeClass('is-playing');
            soundWrap.addClass('is-playing');
            soundWrap.find('.sound-timer-wrap').attr('id', `timer-progress-${playerID}-` + btn.data('hash'));

            if($(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-down`).text() == '00:00' && countdown !== null){
                countdown.init();
            }

            soundWrap.find('.sound-player-content .sound-title').text(audioTitle);
            soundWrap.find('.sound-player-content .sound-subtitle').text(audioSubTitle);
            soundWrap.find('.sound-player-content .sound-btn-download').attr('href', audio);

            soundWrap.find('.player-share-buttons-content a, .sound-player-content .sound-btn-playing, .sound-player-content .sound-btn-sec-prev, .sound-player-content .sound-btn-sec-next, .sound-player-content .sound-player-range, .sound-player-content .sound-timer-line .stl').data({
                'title': audioTitle,
                'subtitle': audioSubTitle,
                'cover': audioCover,
                'length': audioLen,
                'duration': audioPriDur,
                'audio': audio,
                'hash': btn.data('hash'),
            });

            if(btn.hasClass('in-playlist')){
                let itemID = btn.data('item-id'),
                    playListItem = soundWrap.find(`.sound-player-playlist .sound-playlist-item`),
                    playListActiveItem = soundWrap.find('.sound-player-playlist .sound-playlist-item.active');
                $('body').find('.ahura-sound-player .sound-player-playlist .sound-playlist-item').removeClass('active');
                $('body').find('.ahura-sound-player .sound-player-playlist .sound-playlist-item-' + itemID).addClass('active');
                if(playListActiveItem.length > 0){
                    if(playListItem.last().hasClass('active')){
                        soundWrap.find(`.sound-btn-next`).addClass('btn-disabled');
                    } else {
                        soundWrap.find(`.sound-btn-next`).removeClass('btn-disabled');
                    }

                    soundWrap.find(`.sound-btn-prev`).removeClass('btn-disabled');

                    if(playListItem.first().hasClass('active')){
                        soundWrap.find(`.sound-btn-prev`).addClass('btn-disabled');
                    }
                }

                soundWrap.find('.sound-player-content .sound-btn-playing.in-content').removeClass('sound-btn-play').addClass('sound-btn-pause');
            } else {
                if(soundWrap.find('.sound-player-playlist .sound-playlist-item').length > 0){
                    if(soundWrap.find('.sound-player-playlist .sound-playlist-item-' + btn.data('hash'))){
                        soundWrap.find('.sound-player-playlist .sound-playlist-item-' + btn.data('hash')).first().addClass('active');
                    } else if(!soundWrap.find('.sound-player-playlist .sound-playlist-item.active').length){
                        soundWrap.find('.sound-player-playlist .sound-playlist-item').first().addClass('active');
                    }
                    $('body').find('.ahura-sound-player .sound-player-playlist .sound-btn-playing').removeClass('sound-btn-pause').addClass('sound-btn-play');
                    soundWrap.find('.sound-player-content .sound-btn-playing').removeClass('sound-btn-pause').addClass('sound-btn-play');
                    soundWrap.find(`.sound-player-playlist .sound-playlist-item .sound-btn-play[data-hash="${btn.data('hash')}"]`).first().addClass('sound-btn-pause').removeClass('sound-btn-play');
                }
            }

            if(playerInterval !== undefined){
                playerInterval.init();
            }

            intervals = [];
            soundWrap.find('.sound-timer-wrap').trigger('change');
            audioHashName = `player_${playerID}_audio_` + btn.data('hash');
            progressLine = soundWrap.find(`#timer-progress-${playerID}-${btn.data('hash')} .sound-timer-progress`);

            let is_new = ahuraGetCookie('audio_end') == 'true' || ahuraGetCookie('player_id') != playerID || ahuraGetCookie('audio_src') != audio && ahuraGetCookie('audio_hash') != btn.data('hash');

            if(is_new){
                audioCurrentSeek = audioPlayer.seek();
                audioPlayer.unload();
                audioPlayer._src = audio;
                audioPlayer.load();
            }

            audioPlayer.on();

            ahuraSetCookie('audio_end', false);
            ahuraSetCookie('player_id', playerID);
            ahuraSetCookie('audio_src', audio);
            ahuraSetCookie('audio_hash', btn.data('hash'));
            audioCurrentDur = audioPlayer.duration();
            audioSeek = ahuraGetCookie(audioHashName);
            audioSeek = !isNaN(audioSeek) && audioSeek !== undefined ? audioSeek : audioCurrentSeek;
            if(saveAudio && audioSeek){
                audioPlayer.seek(audioSeek);
            } else if(audioSeek > 0) {
                audioPlayer.seek(audioSeek);
            }
            ahuraSetCookie(audioHashName, audioSeek);

            audioPlayer.play();

            let play_callback = function (){
                audioPriDur = audioPriDur && audioPriDur !== undefined ? audioPriDur : audioPlayer.duration();
                btn.removeClass('sound-btn-play').addClass('sound-btn-pause');

                let timeDownEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-down`),
                    timeDefEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-default`);

                playerInterval = ahuraSetInterval(function(){
                    audioCurrentSeek = audioPlayer.seek();
                    ahuraSetCookie(audioHashName, audioPlayer.seek());
                    audioSeek = ahuraGetCookie(audioHashName);
                    if(audioSeek <= 0){
                        return false;
                    }
                    audioDur = ahuraGetCookie(`player_${playerID}_audio_duration_` + btn.data('hash'));
                    progressLineWidth = parseInt(progressLine.get(0).style.width);
                    progressLine.parent().parent().find('.sound-timer-line .stl').css('width', ((ahuraGetCookie(audioHashName) / audioDur) * 100) + '%');
                    progressLine.css('width', ((ahuraGetCookie(audioHashName) / audioDur) * 100) + '%');
                    rangeInput.val((ahuraGetCookie(audioHashName) / audioDur) * 100);
                    ahuraSetCookie(`player_${playerID}_audio_duration_` + btn.data('hash'), audioPriDur);

                    setTimeout(function(){
                        audioDur = ahuraGetCookie(`player_${playerID}_audio_duration_` + btn.data('hash'));
                        if(ahura_players_timer_countdowns && ahura_players_timer_countdowns !== undefined){
                            if(ahura_players_timer_countdowns['audio_' + playerID] !== undefined){
                                clearInterval(ahura_players_timer_countdowns['audio_' + playerID]);
                            }
                        }
                        countdown = new ahuraMSecCountdown(timeDownEl, (audioDur - audioSeek), timeDefEl, audioDur, playerID);
                        if(countdown !== null){
                            countdown.start();
                            ahuraSetCookie('player_countdown_id_' + playerID, countdown.timer['audio_' + playerID]);
                        }
                    },320);

                    if(progressLineWidth == 99 || progressLineWidth == 100){
                        btn.removeClass('sound-btn-pause').addClass('sound-btn-play');
                        $('body').find('.ahura-sound-player .sound-player-playlist .sound-btn-playing, .ahura-sound-player .sound-player-content .sound-btn-playing').removeClass('sound-btn-pause').addClass('sound-btn-play');
                        ahuraDeleteCookie(audioHashName);
                        ahuraDeleteCookie(`player_${playerID}_audio_duration_` + btn.data('hash'));
                        progressLine.parent().parent().find('.sound-timer-line .stl').css('width', '0%');
                        progressLine.css('width', '0%');
                        rangeInput.val(0);
                        audioPlayer.stop();
                        audioPlayer.off();
                        ahuraDeleteCookie('audio_src');
                        ahuraDeleteCookie('audio_hash');
                        ahuraSetCookie('audio_end', true);
                        if(countdown !== null){
                            countdown.init();
                        }
                        if(playerInterval){
                            playerInterval.init();
                        }
                        audioPlayer.unload();
                    }
                }, 300, playerID);

                playerInterval.start();

                if(audioCover && audioCover !== undefined){
                    soundWrap.find('.sound-pri-cover').css('background-image', `url(${audioCover})`);
                }

                if(audioLen && audioLen !== undefined){
                    soundWrap.find('.sound-timer-default').text(audioLen);
                }

                ahuraSetCookie('player_interval_id_' + playerID, playerInterval.timer['interval_' + playerID]);
            }

            if(is_new){
                audioPlayer.on('play', play_callback);
            } else {
                audioPlayer.once('play', play_callback);
            }

            audioPlayer.on('playerror', function (e){
                btn.addClass('shake-animation');
                setTimeout(() => {
                    btn.removeClass('shake-animation');
                }, 1000);
            });
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-pause', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            audioHash = btn.data('hash'),
            soundWrap = $('body').find(`.sound-player-${playerID}`);
        audioPlayer.pause();
        btn.removeClass('sound-btn-pause').addClass('sound-btn-play');
        if(!btn.hasClass('in-content')){
            soundWrap.find('.sound-player-content .sound-btn-playing').removeClass('sound-btn-pause').addClass('sound-btn-play');
        }
        if(btn.hasClass('in-content')){
            if(!soundWrap.find('.sound-player-playlist .sound-playlist-item').length){
                soundWrap.find('.sound-player-playlist .sound-playlist-item').removeClass('active');
                // soundWrap.find('.sound-player-playlist .sound-playlist-item').first().addClass('active');
            }
        }
        if(btn.hasClass('in-content')){
            $('body').find(`.sound-player-playlist .sound-playlist-item.active .sound-btn-pause[data-hash="${audioHash}"]`).addClass('sound-btn-play').removeClass('sound-btn-pause');
        }
        if(countdown !== null){
            countdown.stop();
        }
        if(playerInterval){
            playerInterval.init();
        }
    });

    $('body').on('input', '.ahura-sound-player .sound-timer-line input[type="range"]', function(e){
        let input = $(this),
            playerID = input.data('player-id'),
            soundWrap = $('body').find(`.sound-player-${playerID}`),
            progressLine = soundWrap.find(`#timer-progress-${playerID}-${input.data('hash')} .sound-timer-progress`),
            duration = audioPlayer.duration(),
            audioHashName = `player_${playerID}_audio_` + input.data('hash'),
            currentTimeInSeconds = ((input.val() * duration) / 100).toFixed(2);
        if(((currentTimeInSeconds / duration) * 100) > 99){
            return false;
        }
        if(audioPlayer.playing()){
            playerInterval.stop();
            countdown.stop();
            audioPlayer.pause();
        }
        ahuraSetCookie(audioHashName, currentTimeInSeconds);
        audioPlayer.seek(currentTimeInSeconds);
        progressLine.parent().parent().find('.sound-timer-line .stl').css('width', ((currentTimeInSeconds / duration) * 100) + '%');
        progressLine.css('width', ((currentTimeInSeconds / duration) * 100) + '%');
    });

    $('body').on('change', '.ahura-sound-player .sound-timer-line input[type="range"]', function(e){
        let input = $(this),
            duration = audioPlayer.duration(),
            currentTimeInSeconds = ((input.val() * duration) / 100).toFixed(2),
            playerID = input.data('player-id');
        if(((currentTimeInSeconds / duration) * 100) > 99){
            return false;
        }
        if($('body').find(`.sound-player-${playerID} .sound-player-content .sound-btn-pause`).length > 0){
            audioPlayer.play();
            playerInterval.start();
            countdown.start();
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-sec-next', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            sound = audioPlayer.pause()._sounds[0],
            currentSeek = sound._seek,
            forwardTo = currentSeek + 30,
            timeDownEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-down`),
            timeDefEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-default`),
            audioHashName = `player_${playerID}_audio_` + btn.data('hash'),
            audioDurHashName = `player_${playerID}_audio_sec_next` + btn.data('hash');

        ahuraSetCookie(audioHashName, forwardTo);
        audioPlayerForwardTo(audioPlayer, forwardTo);
        if($('body').find(`.sound-player-${playerID} .sound-player-content .sound-btn-pause`).length > 0){
            audioPlayer.play();
            countdown.start();
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-sec-prev', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            sound = audioPlayer.pause()._sounds[0],
            currentSeek = sound._seek,
            forwardTo = currentSeek - 30,
            timeDownEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-down`),
            timeDefEl = document.querySelector(`.sound-player-${playerID} #timer-progress-${playerID}-${btn.data('hash')} .sound-timer-default`),
            audioHashName = `player_${playerID}_audio_` + btn.data('hash'),
            audioDurHashName = `player_${playerID}_audio_sec_prev` + btn.data('hash');
        ahuraSetCookie(audioHashName, forwardTo);
        audioPlayerForwardTo(audioPlayer, forwardTo);
        if($('body').find(`.sound-player-${playerID} .sound-player-content .sound-btn-pause`).length > 0){
            audioPlayer.play();
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-share', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            itemID = btn.data('item-id'), wrap;
        if(btn.hasClass('sound-btn-share-in-playlist')){
            wrap = $('body').find(`.sound-player-${playerID} .sound-player-playlist .sound-player-share-buttons-` + itemID).first();
        } else {
            wrap = $('body').find(`.sound-player-${playerID} .sound-player-content .sound-player-share-buttons`);
            wrap.parent().addClass('opened-overlay');
        }
        wrap.slideToggle();
    });

    $('body').on('click', '.ahura-sound-player .share-close', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            itemID = btn.data('item-id'), 
            wrap = $('body').find(`.sound-player-${playerID} .sound-player-content`);
        wrap.removeClass('opened-overlay');
        btn.parent().parent().slideUp();
    });

    $('body').on('click', '.ahura-sound-player .sound-player-content .player-share-buttons-content a', function(e){
        let btn = $(this),
        pattern = btn.data('pattern'),
        title = btn.data('title'),
        subTitle = btn.data('subtitle'),
        audio = btn.data('audio'), url;
        if(pattern !== undefined && title !== undefined && subTitle !== undefined && audio !== undefined){
            e.preventDefault();
            url = pattern.replace('{{url}}', audio);
            url = url.replace('{{title}}', title + ' / ' + subTitle);
            btn.attr('href', url);
            window.open(url, '_blank');
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-playlist', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            wrap = $('body').find(`.sound-player-${playerID} .sound-player-playlist`);
        wrap.slideToggle();
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-next', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            player = $('body').find(`.sound-player-${playerID}`),
            playlist = $('body').find(`.sound-player-${playerID} .sound-player-playlist`), playBtn;
        if(!playlist.find('.sound-playlist-item').last().hasClass('active')){
            if(playlist.find('.sound-playlist-item.active').length > 0){
                playlist.find('.sound-playlist-item.active').next().addClass('active');
                playlist.find('.sound-playlist-item.active').prev().removeClass('active');
            } else {
                playlist.find('.sound-playlist-item').first().addClass('active');
            }
        }
        if(playlist.find('.sound-playlist-item.active').length > 0){
            player.find('.sound-btn-prev').removeClass('btn-disabled');
        }
        if(playlist.find('.sound-playlist-item').last().hasClass('active')){
            btn.addClass('btn-disabled');
        }
        if(playlist.find('.sound-playlist-item.active .sound-btn-playing').length > 0){
            playlist.find('.sound-playlist-item .sound-btn-pause').trigger('click');
            ahuraDeleteCookie('audio_src');
            ahuraDeleteCookie('audio_hash');
            playlist.find('.sound-playlist-item.active .sound-btn-playing').trigger('click');
        }
    });

    $('body').on('click', '.ahura-sound-player .sound-btn-prev', function(e){
        e.preventDefault();
        let btn = $(this),
            playerID = btn.data('player-id'),
            player = $('body').find(`.sound-player-${playerID}`),
            playlist = $('body').find(`.sound-player-${playerID} .sound-player-playlist`);
        if(!playlist.find('.sound-playlist-item').first().hasClass('active')){
            if(playlist.find('.sound-playlist-item.active').length > 0){
                playlist.find('.sound-playlist-item.active').prev().addClass('active');
                playlist.find('.sound-playlist-item.active').next().removeClass('active');
            } else {
                //playlist.find('.sound-playlist-item').last().addClass('active');
               /*btn.addClass('btn-disabled');
                player.find('.sound-btn-next').removeClass('btn-disabled');
                player.find('.sound-player-content .sound-btn-playing').trigger('click');*/
            }
        }
        if(playlist.find('.sound-playlist-item').first().hasClass('active')){
            player.find('.sound-btn-next').removeClass('btn-disabled');
            playlist.find('.sound-playlist-item .sound-btn-pause').trigger('click');
            playlist.find('.sound-playlist-item.active .sound-btn-playing').trigger('click');
            player.find('.sound-btn-prev').addClass('btn-disabled');
            ahuraDeleteCookie('audio_src');
            ahuraDeleteCookie('audio_hash');
        } else {
            playlist.find('.sound-playlist-item .sound-btn-pause').trigger('click');
            if(playlist.find('.sound-playlist-item.active .sound-btn-playing').length > 0){
                playlist.find('.sound-playlist-item.active .sound-btn-playing').trigger('click');
                ahuraDeleteCookie('audio_src');
                ahuraDeleteCookie('audio_hash');
            }
        }
    });

    $('body').on('input', '.sound-player-1 .sound-volume input[type="range"]', function (){
        let input = $(this),
            icon = input.parent().parent().find('i'),
            volumeValue = input.val(),
            volume = volumeValue / 100;

        if(volumeValue > 50){
            icon.attr('class', 'fas fa-volume-up');
        } else {
            if(volumeValue <= 0){
                icon.attr('class', 'fas fa-volume-mute');
            } else if(volumeValue <= 50) {
                icon.attr('class', 'fas fa-volume-down');
            }
        }

        audioPlayer.volume(volume);
    });

    $('body').on('click', '.sound-player-1 .sound-speed .sound-speed-box .speed-item', function (){
        let btn = $(this),
            rateValue = btn.data('value');

        btn.parent().find('.active').removeClass('active');
        btn.addClass('active');

        audioPlayer.rate(rateValue);
    });
});

function audioPlayerForwardTo(audioPlayer, forwardTo, countdownTime = 0, timeDownEl = null, timeDefEl = null, playerID = null){
    let duration = audioPlayer.duration();
    if (forwardTo >= duration) {
        return;
    }
    audioPlayer.seek(forwardTo);
    if(timeDownEl != null && timeDefEl != null && playerID != null){
        if(ahura_players_timer_countdowns && ahura_players_timer_countdowns !== undefined){
            if(ahura_players_timer_countdowns['audio_' + playerID] !== undefined){
                clearInterval(ahura_players_timer_countdowns['audio_' + playerID]);
                ahura_players_timer_countdowns['audio_' + playerID] = null;
            }
        }

        countdown = new ahuraMSecCountdown(timeDownEl, countdownTime, timeDefEl, duration, playerID);

        if(countdown !== null){
            countdown.start();
        }
    }
}

function ahuraMSecCountdown(elem, seconds, defElem = null, defSeconds = 0, player_id = 0) {
    var that = {};

    that.elem = elem;
    that.player_id = player_id;
    that.defelem = defElem;
    that.defseconds = defSeconds;
    that.seconds = seconds;
    that.totalTime = seconds * 100;
    that.usedTime = 0;
    that.startTime = +new Date();
    that.timer = [];
  
    that.count = function() {
        that.usedTime = Math.floor((+new Date() - that.startTime) / 10);

        var tt = that.totalTime - that.usedTime;

        if (tt <= 0 || !jQuery(`.sound-player-${that.player_id} .sound-btn-pause`).length) {
            clearInterval(that.timer['audio_' + that.player_id]);
            clearInterval(ahura_players_timer_countdowns['audio_' + that.player_id]);
            ahura_players_timer_countdowns['audio_' + that.player_id] = null;
        } else {
            var di = Math.floor(tt / (24 * 60 * 60 * 100));
            var mi = Math.floor(tt / (60 * 100));
            var ss = Math.floor((tt - mi * 60 * 100) / 100);
            var ms = tt - Math.floor(tt / 100) * 100;
            if(that.elem){
                that.elem.innerHTML = that.fillZero(mi) + ":" + that.fillZero(ss);

                if(that.defelem.innerHTML === '00:00'){
                    that.defelem.innerHTML = that.fillZero(mi) + ":" + that.fillZero(ss);
                }
            }
        }
    };
    
    that.init = function() {
        if(that.timer['audio_' + that.player_id]){
            clearInterval(that.timer['audio_' + that.player_id]);
            clearInterval(ahura_players_timer_countdowns['audio_' + that.player_id]);
            ahura_players_timer_countdowns['audio_' + that.player_id] = null;
            that.elem.innerHTML = '00:00';
            that.totalTime = seconds * 100;
            that.defelem.innerHTML = '00:00';
            that.usedTime = 0;
            that.startTime = +new Date();
            that.timer = [];
            ahura_players_timer_countdowns = [];
        }
    };
  
    that.start = function() {
        if(!that.timer['audio_' + that.player_id]){
            clearInterval(that.timer['audio_' + that.player_id]);
            clearInterval(ahura_players_timer_countdowns['audio_' + that.player_id]);
            ahura_players_timer_countdowns['audio_' + that.player_id] = null;
            that.timer = [];
            that.timer['audio_' + that.player_id] = setInterval(that.count, 1);
            ahura_players_timer_countdowns['audio_' + that.player_id] = that.timer['audio_' + that.player_id];
        }
    };
  
    that.stop = function() {
        if (that.timer['audio_' + that.player_id]) {
            clearInterval(that.timer['audio_' + that.player_id]);
            clearInterval(ahura_players_timer_countdowns['audio_' + that.player_id]);
            ahura_players_timer_countdowns['audio_' + that.player_id] = null;
        }
    };
  
    that.fillZero = function(num) {
      return num < 10 ? '0' + num : num;
    };
  
    return that;
}

function ahuraSetInterval(callback, time, interval_id = 0){
    var that = {};

    that.interval_id = interval_id ? interval_id : 1;
    that.time = time;
    that.timer = [];

    that.count = callback;

    that.init = function(){
        if(that.timer['interval_' + that.interval_id]){
            clearInterval(that.timer['interval_' + that.interval_id]);
            that.timer = [];
        }
    };

    that.start = function() {
        if(!that.timer['interval_' + that.interval_id]){
            clearInterval(that.timer['interval_' + that.interval_id]);
            that.timer = [];
            that.timer['interval_' + that.interval_id] = setInterval(that.count, that.time);
        }
    };

    that.stop = function() {
        if (that.timer['interval_' + that.interval_id]) {
            clearInterval(that.timer['interval_' + that.interval_id]);
            that.timer = [];
        }
    };

    return that;
}

function ahuraClearPlayersIntervals(){
    jQuery('body').find('.ahura-sound-player').each(function(){
        if(ahuraCheckCookie('player_interval_id_' + jQuery(this).data('player-id'))){
            clearInterval(ahuraGetCookie('player_interval_id_' + jQuery(this).data('player-id')));
        }
        if(ahuraCheckCookie('player_countdown_id_' + jQuery(this).data('player-id'))){
            clearInterval(ahuraGetCookie('player_countdown_id_' + jQuery(this).data('player-id')));
        }
    });
}