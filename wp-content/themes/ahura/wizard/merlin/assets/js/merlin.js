let Merlin = (function($){

    let t;

    // callbacks from form button clicks.
    let callbacks = {
        install_child: function(btn) {
            var installer = new ChildTheme();
            installer.init(btn);
        },
        activate_license: function(btn) {
            var license = new ActivateLicense();
            license.init(btn);
        },
        install_plugins: function(btn){
            var plugins = new PluginManager();
            plugins.init(btn);
        },
        install_content: function(btn){
            var content = new StudioImporter();
            content.init(btn);
        }
    };

    function window_loaded(){
    	var body 		= $('.merlin__body'),
            body_loading 	= $('.merlin__body--loading'),
            body_exiting 	= $('.merlin__body--exiting'),
            drawer_trigger 	= $('#merlin__drawer-trigger'),
            drawer_opening 	= 'merlin__drawer--opening',
            drawer_opened 	= 'merlin__drawer--open',
            merlin_content = $('.merlin__content'),
            installBtn = $('.merlin__demo-install-btn');

        $(window).on('beforeunload', function(e) {
            let isDoingProcess = $('.ahura-filter-tab-items.is-doing').length;
            if(isDoingProcess){
                e.preventDefault();
            }
        });

        $(document).on('change', '#check-host-space', function (){
            let input = $(this);

            if(input.prop('checked')){
                ahuraSetCookie('check_host_space', true);
                installBtn.show();
            } else {
                ahuraSetCookie('check_host_space', false);
                installBtn.hide();
            }
        });

        $(document).on('click', 'a#skip', function (e){
            let btn = $(this),
                target = btn.data('href');
            if(target){
                if (!$('.filter-item.is-doing').length){
                    btn.attr('href', target);
                    window.location.href = target;
                    btn.addClass('opacity-loader');
                }
            }
        });

        if(ahuraGetCookie('check_host_space') === 'true'){
            $('#check-host-space').attr('checked', true).trigger('change');
        }

        $(document).on('click', '.ahura-studio-filter-tab-items a.studio-install-demo', async function(e){
            e.preventDefault();
            let btn = $(this),
                data_callback = btn.data('callback'),
                demo_id = btn.data('demo-id'),
                demo_title = btn.data('demo-title'),
                currentItem = btn.closest('.filter-item'),
                allItems = $('.ahura-studio-filter-tab-items');

            $('body').data('demo-id', demo_id);

            const { value: accept } = await Swal.fire({
                icon: 'info',
                html: ahura_data.translate.studio_import_title + ' "' + demo_title + '"',
                confirmButtonText: ahura_data.translate.studio_import,
                showCancelButton: true,
                cancelButtonText: ahura_data.translate.cancel,
                input: 'checkbox',
                inputValue: ahuraGetCookie('check_host_space') === 'true',
                inputPlaceholder: merlin_params.texts.storage_check,
                inputValidator: (result) => {
                    if(!result){
                        ahuraSetCookie('check_host_space', false);
                        return merlin_params.texts.required_input;
                    } else {
                        ahuraSetCookie('check_host_space', true);
                    }
                }
            });

            currentItem.removeClass('is-done');

            if(accept || accept === 0){
                allItems.addClass('is-doing');
                currentItem.addClass('is-doing');
                iWantLoader(btn, 'text');

                if(data_callback && typeof callbacks[data_callback] !== "undefined"){
                    callbacks[data_callback](this);
                    let demo_checker_interval = setInterval(()=>{
                        if($('body').data('demo-complete') === true || $('body').data('demo-error') === true){
                            iCantLoader(btn, 'text');
                            allItems.removeClass('is-doing');
                            currentItem.removeClass('is-doing');
                            if($('body').data('demo-complete') === true){
                                let skipBtn = $('a#skip');
                                if (skipBtn.length && !skipBtn.hasClass('success')){
                                    skipBtn.trigger('click');
                                }
                                currentItem.addClass('is-done');
                                $('body').data('demo-complete', false);
                            }
                            clearInterval(demo_checker_interval);
                        }
                    }, 1000);
                }
            }
        });

        $(document).on('click', '.merlin-demo-selector, .merlin-demo-lists-close', function (e) {
            e.preventDefault();
            let btn = $(this),
                items_wrap = $('.merlin-demo-lists-wrap');
            items_wrap.toggleClass('merlin-demo-lists-show');
        });

        $(document).on('click', '.ahura-filter-tabs ul li.search-toggle', function (e) {
            e.preventDefault();
            let btn = $(this),
                input_wrap = $('.search-wrap');
            input_wrap.slideToggle();
        });

        $(document).on('keyup', '.search-wrap input', function (e) {
            e.preventDefault();
            let input = $(this),
                inputVal = input.val(),
                items = $('.merlin-demo-lists ul li, .ahura-filter-tab-items .filter-item'),
                item;

            if(inputVal.length > 2){
                items.each(function (i) {
                    item = $(this);
                    if(item.find('span') || item.find('h3')){
                        if((item.find('span').text()).search(inputVal) >= 0 || (item.find('h3').text()).search(inputVal) >= 0){
                            item.show();
                        } else {
                            item.hide();
                        }
                    }
                });
            } else {
                items.show();
            }
        });

        $(document).on('click', '.merlin-demo-lists-wrap .demo-item a', function (e) {
            e.preventDefault();
            let btn = $(this),
                demo_id = btn.data('id'),
                demo_icon = btn.find('img').attr('src'),
                demo_title = btn.find('span').text(),
                select_el = $('.js-merlin-demo-import-select'),
                selector_btn = $('.merlin-demo-selector'),
                items_wrap = $('.merlin-demo-lists-wrap');

            items_wrap.find('.selected').removeClass('selected');
            btn.parent().addClass('selected');
            selector_btn.find('.demo-icon').css('background-image', `url(${demo_icon})`);
            selector_btn.find('.demo-title').text(demo_title);
            selector_btn.data('demo-id', demo_id);
            select_el.val(demo_id);
            select_el.trigger('change');
            items_wrap.removeClass('merlin-demo-lists-show');
        })

    	setTimeout(function(){
	        body.addClass('loaded');
	    },100);

    	drawer_trigger.on('click', function(){
            if(typeof drawer_opened !== "undefined"){
                body.toggleClass( drawer_opened );
            }
        });

    	$('.merlin__button--proceed:not(.merlin__button--closer)').click(function (e) {
		    e.preventDefault();
		    var goTo = this.getAttribute("href");

		    body.addClass('exiting');

		    setTimeout(function(){
		        window.location = goTo;
		    },400);
		});

        $(".merlin__button--closer").on('click', function(e){

            if(typeof drawer_opened !== "undefined"){
                body.removeClass( drawer_opened );
            }

            e.preventDefault();
		    var goTo = this.getAttribute("href");

		    setTimeout(function(){
		        body.addClass('exiting');
		    },600);

		    setTimeout(function(){
		        window.location = goTo;
		    },1100);
        });

        $(".button-next").on( "click", function(e) {
            e.preventDefault();
            var loading_button = merlin_loading_button(this);
            if ( ! loading_button ) {
                return false;
            }
            var data_callback = $(this).data("callback");
            if( data_callback && typeof callbacks[data_callback] !== "undefined"){
                // We have to process a callback before continue with form submission.
                callbacks[data_callback](this);
                return false;
            } else {
                return true;
            }
        });

				$( document ).on( 'change', '.js-merlin-demo-import-select', function() {
					var selectedIndex  = $( this ).val();

					$( '.js-merlin-select-spinner' ).show();

					$.post( merlin_params.ajaxurl, {
						action: 'merlin_update_selected_import_data_info',
						wpnonce: merlin_params.wpnonce,
						selected_index: selectedIndex,
					}, function( response ) {
						if ( response.success ) {
							$( '.js-merlin-drawer-import-content' ).html( response.data );
						}
						else {
							alert( merlin_params.texts.something_went_wrong );
						}

						$( '.js-merlin-select-spinner' ).hide();
					} )
						.fail( function() {
							$( '.js-merlin-select-spinner' ).hide();
							alert( merlin_params.texts.something_went_wrong )
						} );
				} );
    }

    function ChildTheme() {
    	var body 				= $('.merlin__body');
        var complete, notice 	= $("#child-theme-text");

        function ajax_callback(r) {

            if (typeof r.done !== "undefined") {
            	setTimeout(function(){
			        notice.addClass("lead");
			    },0);
			    setTimeout(function(){
			        notice.addClass("success");
			        notice.html(r.message);
			    },600);


                complete();
            } else {
                notice.addClass("lead error");
                notice.html(r.error);
            }
        }

        function do_ajax() {
            jQuery.post(merlin_params.ajaxurl, {
                action: "merlin_child_theme",
                wpnonce: merlin_params.wpnonce,
            }, ajax_callback).fail(ajax_callback);
        }

        return {
            init: function(btn) {
                complete = function() {

                	setTimeout(function(){
				$(".merlin__body").addClass('js--finished');
			},1500);

                if(typeof drawer_opened !== "undefined"){
                    body.removeClass( drawer_opened );
                }

                	setTimeout(function(){
				$('.merlin__body').addClass('exiting');
			},3500);

                    	setTimeout(function(){
				window.location.href=btn.href;
			},4000);

                };
                do_ajax();
            }
        }
    }










function ActivateLicense() {
    	var body 		= $( '.merlin__body' );
    	var wrapper 		= $( '.merlin__content--license-key' );
        var complete, notice 	= $( '#license-text' );
		var try_count = 0;
		
        function ajax_callback(r) {
			//console.log(try_count);
            if (typeof r.success !== "undefined" && r.success) {
              notice.siblings( '.error-message' ).remove();
            	setTimeout(function(){
			        notice.addClass("lead");
			    },0);
			    setTimeout(function(){
			        notice.addClass("success");
			        notice.html(r.message);
			    },600);
                complete();
            } else {
				if(try_count === 2){
					$( '.js-merlin-license-activate-button' ).removeClass( 'merlin__button--loading' ).data( 'done-loading', 'no' );
					notice.siblings( '.error-message' ).remove();
					wrapper.addClass('has-error');
					notice.html(r.message);
					notice.siblings( '.error-message' ).addClass("lead error");
				 } else {
					do_ajax();
				 }
            }
			try_count++;
        }


        function do_ajax() {

        	wrapper.removeClass('has-error');

            jQuery.post(merlin_params.ajaxurl, {
              action: "merlin_activate_license",
              wpnonce: merlin_params.wpnonce,
              license_key: $( '.js-license-key' ).val()
            }, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                	setTimeout(function(){
				$(".merlin__body").addClass('js--finished');
			},1500);

                if(typeof drawer_opened !== "undefined"){
                	body.removeClass( drawer_opened );
                }

                	setTimeout(function(){
				$('.merlin__body').addClass('exiting');
			},3500);

                    	setTimeout(function(){
				window.location.href=btn.href;
			},4000);

                };
                do_ajax();
            }
        }
    }

function PluginManager(){

    	var body = $('.merlin__body');
        var complete;
        var items_completed 	= 0;
        var current_item 		= "";
        var $current_node;
        var current_item_hash 	= "";

        function ajax_callback(response){
            var currentSpan = $current_node.find("label");
            if(typeof response === "object" && typeof response.message !== "undefined"){
                currentSpan.removeClass( 'installing success error' ).addClass(response.message.toLowerCase());

                // The plugin is done (installed, updated and activated).
                if(typeof response.done != "undefined" && response.done){
                    find_next();
                }else if(typeof response.url != "undefined"){
                    // we have an ajax url action to perform.
                    if(response.hash == current_item_hash){
                        currentSpan.removeClass( 'installing success' ).addClass("error");
                        find_next();
                    }else {
                        current_item_hash = response.hash;
                        jQuery.post(response.url, response, ajax_callback).fail(ajax_callback);
                    }
                }else{
                    // error processing this plugin
                    find_next();
                }
            }else{
                // The TGMPA returns a whole page as response, so check, if this plugin is done.
                process_current();
            }
        }

        function process_current(){
            if(current_item){
                var $check = $current_node.find("input:checkbox");
                if($check.is(":checked")) {
                    jQuery.post(merlin_params.ajaxurl, {
                        action: "merlin_plugins",
                        wpnonce: merlin_params.wpnonce,
                        slug: current_item,
                    }, ajax_callback).fail(ajax_callback);
                }else{
                    $current_node.addClass("skipping");
                    setTimeout(find_next,300);
                }
            }
        }

        function find_next(){
            if($current_node){
                if(!$current_node.data("done_item")){
                    items_completed++;
                    $current_node.data("done_item",1);
                }
                $current_node.find(".spinner").css("visibility","hidden");
            }
            var $li = $(".merlin__drawer--install-plugins li");
            $li.each(function(){
                var $item = $(this);

                if ( $item.data("done_item") ) {
                    return true;
                }

                current_item = $item.data("slug");
                $current_node = $item;
                process_current();
                return false;
            });
            if(items_completed >= $li.length){
                // finished all plugins!
                complete();
            }
        }

        return {
            init: function(btn){
                $(".merlin__drawer--install-plugins").addClass("installing");
                $(".merlin__drawer--install-plugins").find("input").prop("disabled", true);
                complete = function(){

                	setTimeout(function(){
				        $(".merlin__body").addClass('js--finished');
				    },1000);

                    if(typeof drawer_opened !== "undefined"){
                        body.removeClass( drawer_opened );
                    }

                	setTimeout(function(){
				        $('.merlin__body').addClass('exiting');
				    },3000);

                    setTimeout(function(){
				        window.location.href=btn.href;
				    },3500);

                };
                find_next();
            }
        }
    }

    function StudioImporter(){
        // Please don`t edit items sort
        let content_import_items = ['options', 'terms', 'widgets', 'media', 'content', 'menus'],
            next_btn = $('.merlin__button.button-next'),
            next_btn_text_el = next_btn.find('.merlin__button--loading__text'),
            progress_el = next_btn.find('.merlin__progress-bar'),
            progress_bar_el = progress_el.find('.js-merlin-progress-bar'),
            progress_percent_el = next_btn.find('.js-merlin-progress-bar-percentage'),
            studio_progress = $(document).find('.filter-item.is-doing .btn-progress'),
            icon_content = $('.icon--content'),
            icon_complete = $('.icon--checkmark'),
            demo_selector = $('.merlin-demo-selector'),
            media_item = $('.filter-item.is-doing li[data-content="media"], .merlin__wrapper li[data-content="media"]'),
            media_check_wrap = $(document).find('.filter-item.is-doing .filter-item-options li[data-content="media"] .round-check, .merlin__wrapper li[data-content="media"]'),
            select_demo_el = $('.js-merlin-demo-import-select'),
            unselected_options = get_unselected_items(),
            current_demo_id = select_demo_el.val() || $('.studio-install-demo.has-loader').data('demo-id') || 0,
            n = 0;

        if(unselected_options){
            $.each(unselected_options, function (i, val) {
                content_import_items.splice(content_import_items.indexOf(val), 1);
            });
        }

        function get_selected_items(){
            let items = [],
                checkboxes = document.querySelectorAll('input[type="checkbox"][id*="default_content"]');
            if(checkboxes){
                checkboxes.forEach(checkbox => {
                    if(checkbox.checked){
                        items.push(checkbox.parentNode.dataset.content);
                    }
                });
            }
            return items;
        }

        function get_unselected_items(){
            let items = [],
                checkboxes = document.querySelectorAll('input[type="checkbox"][id*="default_content"]');
            if(checkboxes){
                checkboxes.forEach(checkbox => {
                    if(!checkbox.checked){
                        items.push(checkbox.parentNode.dataset.content);
                    }
                });
            }
            return items;
        }

        function process(index = 0){
            let item = content_import_items[index],
                is_first = item === content_import_items[0],
                is_last = item === content_import_items[content_import_items.length - 1],
                options_trigger_btn,
                progress_width = 0,
                start_media = 0;

            if(current_demo_id < 0){
                return false;
            }

            $('body').data('demo-error', false);
            $('body').data('demo-complete', false);

            select_demo_el.css('pointer-events', 'none');
            demo_selector.css('pointer-events', 'none');

            if(is_first){
                options_trigger_btn = document.querySelector('body:not(.merlin__drawer--open) #merlin__drawer-trigger');
                if(options_trigger_btn){
                    options_trigger_btn.click();
                }
            }

            let callback = function (res){
                if(typeof res.data !== "undefined" && typeof res.data.empty !== "undefined" && res.data.empty === true){
                    $('body').data('demo-error', true);
                    return;
                }

                let current_filter_item_cls = '.filter-item.is-doing',
                    form = $('.is-multi-import'),
                    checkbox_key = ($(current_filter_item_cls).length ? current_filter_item_cls + ' ' : '') + `input[type="checkbox"][name="default_content[${content_import_items[index]}]"]`,
                    current_checkbox = document.querySelector(checkbox_key);

                form.css('pointer-events', 'none');

                if(current_checkbox){
                    current_checkbox.parentNode.classList.remove('status--Pending');
                    current_checkbox.parentNode.classList.add('status--Wait');

                    if(res.type === 'success'){
                        if(next_btn.length || studio_progress.length){
                            let width = (parseFloat(progress_bar_el.css('width')) / parseFloat(progress_bar_el.parent().css('width')) * 100);

                            if(studio_progress.length){
                                width = (parseFloat(studio_progress.css('width')) / parseFloat(studio_progress.parent().css('width')) * 100);
                            }

                            width = width + (100 / content_import_items.length - n);
                            width = width <= 100 ? width : 100;
                            progress_width = width;
                            if(next_btn.length){
                                progress_bar_el.css('width', width + '%');
                                progress_percent_el.text(parseInt(width) + '%');
                            } else {
                                studio_progress.attr('percent', width);
                                studio_progress.css('width', width + '%');
                            }
                        }
                        current_checkbox.parentNode.classList.remove('status--Wait');
                        current_checkbox.parentNode.classList.add('status--Done');
                    } else {
                        current_checkbox.parentNode.classList.remove('status--Wait');
                        current_checkbox.parentNode.classList.add('status--Error');
                    }
                }

                if (index < content_import_items.length - 1) {
                    process(index + 1);
                }

                if(typeof res.data !== 'undefined'){
                    if(typeof res.data.complete !== 'undefined' && res.data.complete === true){
                        $('body').data('demo-complete', true);
                        form.css('pointer-events', 'all');
                        let after_import_checkbox = document.querySelector(($(current_filter_item_cls).length ? current_filter_item_cls + ' ' : '') + `input[type="checkbox"][name="default_content[after_import]"]`);
                        if(after_import_checkbox){
                            after_import_checkbox.parentNode.classList.remove('status--Pending');
                            after_import_checkbox.parentNode.classList.remove('status--Error');
                            after_import_checkbox.parentNode.classList.remove('status--Wait');
                            after_import_checkbox.parentNode.classList.add('status--Done');
                        }

                        if(next_btn.length){
                            progress_bar_el.css('width', '100%');
                            progress_percent_el.text('100%');
                        } else {
                            studio_progress.css('width', '100%');
                        }

                        select_demo_el.css('pointer-events', 'all');
                        demo_selector.css('pointer-events', 'all');

                        setTimeout(()=>{
                            options_trigger_btn = document.querySelector('body.merlin__drawer--open #merlin__drawer-trigger');
                            if(options_trigger_btn){
                                options_trigger_btn.click();
                            }

                            ahuraSetCookie('studio-complete-demo', true);
                            $('.ahura-filter-tab-items.is-doing').removeClass('is-doing');
                            setTimeout(function (){
                                $('#skip').addClass('success').click();
                            }, 300);

                            next_step();
                        }, 2000);

                    }
                }
            }

            function process_media(index){
                if(!media_item.find('label span em').length){
                    let note_text = is_studio() ? ahura_data.translate.plz_wait : merlin_params.texts.plz_wait;
                    media_item.find('label span').append(`<em>${note_text}</em>`);
                }

                $.post(merlin_params.ajaxurl, {
                    action: "merlin_content_media",
                    wpnonce: merlin_params.wpnonce,
                    selected_index: current_demo_id,
                    step: 'media',
                    start_media: start_media,
                    is_first: is_first,
                    is_last: is_last
                }, callback_media).fail(callback_media);
            }

            let callback_media = function (res) {
                if(res != null){
                    start_media += 1;
                    progress_width = is_studio() ? parseInt(studio_progress.attr('percent')) : parseInt(progress_percent_el.text());

                    if (start_media % 6 === 0 && progress_width !== 100){
                        if (is_studio()){
                            studio_progress.css('width', (progress_width + 1) + '%');
                        } else {
                            progress_bar_el.css('width', (progress_width + 1) + '%');
                            progress_percent_el.text((parseInt(progress_width) + 1) + '%');
                        }
                    }
                    if(media_check_wrap.find('.media-counter').length){
                        media_check_wrap.find('.media-counter').text(start_media);
                    } else {
                        media_check_wrap.find('label.text-label').append(`<em class="media-counter">${start_media}</em>`);
                    }
                    process_media(start_media);
                } else {
                    media_check_wrap.addClass('status--Done').removeClass('status--Wait');
                    media_item.find('label span em').remove();
                    process(index + 1);
                }
            };

            if(item === 'media'){
                media_check_wrap.addClass('status--Wait').removeClass('status--Pending');
                process_media(start_media);
            } else {
                $.post(merlin_params.ajaxurl, {
                    action: "merlin_content",
                    wpnonce: merlin_params.wpnonce,
                    selected_index: current_demo_id,
                    step: item,
                    is_first: is_first,
                    is_last: is_last
                }, callback).fail(callback);
                n++;
            }
        }

        function next_step(){
            if(next_btn.length){
                next_btn.addClass('success');
                icon_content.css('opacity', 0);
                icon_complete.show();
                setTimeout(() => {
                    window.location.href = next_btn.attr('href');
                }, 2000);
            }
        }

        return {
            init: function (btn) {
                $.post(merlin_params.ajaxurl, {
                    action: "merlin_generate_demo_file",
                    wpnonce: merlin_params.wpnonce,
                    selected_index: current_demo_id
                }, function (res) {
                    if(typeof res.success !== "undefined" && res.success === true){
                        process(0);
                    } else {
                        merlin_unloading_button(btn);
                        if(is_studio()){
                            location.reload();
                        }
                    }
                });
            }
        }
    }

    function is_studio(){
        return $('.studio-content').length;
    }

    function merlin_loading_button( btn ){

        var $button = jQuery(btn);

        if ( $button.data( "done-loading" ) == "yes" ) {
        	return false;
        }

        var completed = false;

        var _modifier = $button.is("input") || $button.is("button") ? "val" : "text";

        $button.data("done-loading","yes");

        $button.addClass("merlin__button--loading");

        return {
            done: function(){
                completed = true;
                $button.attr("disabled",false);
            }
        }
    }

    function merlin_unloading_button(btn){
        let button = $(btn),
            completed = false;

        if (button.data("done-loading") !== "yes" ) {
            return false;
        }

        button.data("done-loading", "no");
        button.removeClass("merlin__button--loading");

        return {
            done: function(){
                completed = true;
                button.attr("disabled", false);
            }
        }
    }

    return {
        init: function(){
            t = this;
            $(window_loaded);
        },
        callback: function(func){
            console.log(func);
            console.log(this);
        }
    }
})(jQuery);

Merlin.init();
