jQuery(document).ready(function($){
    /**
    *
    * 
    *  Post like
    * 
    */
    $('body').on('click', '.post-like-buttons .btn-post-like-action', function(e){
        e.preventDefault();
        let btn = $(this),
            pid = btn.data('post-id'),
            likeBtn = btn.parent().find('.btn-post-like'),
            disBtn = btn.parent().find('.btn-post-dislike'),
            counter = likeBtn.find('.counter'),
            isLike = btn.data('like'),
            msg = $('body').find('.ahura-post-like-msg-' + pid),
            disCounter = disBtn.find('.counter'),
            error = 0;

        if(btn.hasClass('btn-post-like') && ahuraGetCookie('post_liked_' + pid) == 'true'){
            msg.text(ajax_data.translate.already_liked).addClass('warning show');
            error = 1;
        } else if(btn.hasClass('btn-post-dislike') && ahuraGetCookie('post_disliked_' + pid) == 'true'){
            msg.text(ajax_data.translate.already_disliked).addClass('warning show');
            error = 1;
        }

        setTimeout(function(){
            if(msg.hasClass('warning')){
                msg.removeClass('success warning error show');
            }
        }, 5000);

        if(error){
            return false;
        }

        $.ajax({
            url: ajax_data.au,
            data: {
                action: 'ahura_post_like',
                pid: pid,
                nonce: ajax_data.nonce,
                is_like: isLike,
                is_liked: ahuraGetCookie('post_liked_' + pid),
                is_disliked: ahuraGetCookie('post_disliked_' + pid),
            },
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                msg.removeClass('success warning error show');
                btn.addClass('has-loader');
                btn.parent().addClass('has-loader');
            },
            success: function (res) {
                btn.removeClass('has-loader');
                btn.parent().removeClass('has-loader');

                if(res.status === 'success'){
                    if(btn.hasClass('btn-post-like') && res.isLike !== undefined){
                        ahuraSetCookie('post_disliked_' + pid, false, 200);
                        ahuraSetCookie('post_liked_' + pid, true, 200);
                        likeBtn.addClass('liked');
                        disBtn.removeClass('disliked');
                        counter.text(res.likes);
                        disCounter.text(res.dislikes);
                    } else if(btn.hasClass('btn-post-dislike') && res.isDisLike !== undefined){
                        ahuraSetCookie('post_liked_' + pid, false, 200);
                        ahuraSetCookie('post_disliked_' + pid, true, 200);
                        likeBtn.removeClass('liked');
                        btn.addClass('disliked');
                        disCounter.text(res.dislikes);
                        counter.text(res.likes);
                    }
                }

                if(res.msg !== undefined){
                    msg.text(res.msg).addClass(res.status + ' show');

                    setTimeout(function(){
                        msg.removeClass('success warning error show');
                    }, 8000);
                } else {
                    msg.removeClass('success warning error show');
                }
            },
            error: function (){
                btn.removeClass('has-loader');
                btn.parent().removeClass('has-loader');
                msg.removeClass('success warning error show');
            }
        });
    });

    $(document).on('submit', '#ahura-login-form', function(e){
        e.preventDefault();
        let form = $(this),
            formData = form.serialize(),
            captchaCode = form.find('.security-code').val();

        if(ajax_data.show_captcha && (!captchaCode || captchaCode !== captcha_codes['ahura-login-captcha'])){
            ahuraShowFixedMessage(ajax_data.translate.invalid_security_code, 'error');
            return false;
        }
      
        $.ajax({
            url: ajax_data.au,
            data: "action=ahura_user_login&" + formData,
            type: 'POST',
            dataType: 'json',
            timeout: 15000,
            beforeSend: function(){
                form.addClass('blur-loading');
            },
            success: function(res){
                ahuraShowFixedMessage(res.msg, res.status);
                ahuraReGenerateCaptchaCodes();

                if(res.status != 'success'){
                    form.removeClass('blur-loading');
                } else {
                    location.reload();
                }
            },
            error: function(){
                form.removeClass('blur-loading');
                ahuraShowFixedMessage(ajax_data.translate.unknown_error, 'error');
            }
        })
    });

    $(document).on('submit', '#ahura-register-form', function(e){
        e.preventDefault();
        let form = $(this),
            formData = form.serialize(),
            loginTabBtn = $('.ahura-tabs .tab-item[data-target="#user-login-tab"]'),
        	loginForm = $(document).find('#ahura-login-form').first(),
            captchaCode = form.find('.security-code').val();

        if(ajax_data.show_captcha && (!captchaCode || captchaCode !== captcha_codes['ahura-register-captcha'])){
            ahuraShowFixedMessage(ajax_data.translate.invalid_security_code, 'error');
            return false;
        }

        $.ajax({
            url: ajax_data.au,
            data: "action=ahura_user_register&" + formData,
            type: 'POST',
            dataType: 'json',
            timeout: 15000,
            beforeSend: function(){
                form.addClass('blur-loading');
            },
            success: function(res){
                ahuraShowFixedMessage(res.msg, res.status);
                form.removeClass('blur-loading');
                ahuraReGenerateCaptchaCodes();

                if(res.status === 'success'){
                    if(typeof res.auto_login !== "undefined" && loginTabBtn.length > 0){
                        loginTabBtn.trigger('click');
                      	loginForm.find('input[name="username"]').val(form.find('input[name="username"]').val());
                      	loginForm.find('input[name="password"]').val(form.find('input[name="password"]').val());
                      	loginForm.submit();
                    } else {
                        form[0].reset();
                    }
                }
            },
            error: function(){
                form.removeClass('blur-loading');
                ahuraShowFixedMessage(ajax_data.translate.unknown_error, 'error');
            }
        })
    });

    $(document).on('submit', '#ahura-resetpass-form', function(e){
        e.preventDefault();
        let form = $(this),
            formData = form.serialize(),
            captchaCode = form.find('.security-code').val();

        if(ajax_data.show_captcha && (!captchaCode || captchaCode !== captcha_codes['ahura-resetpwd-captcha'])){
            ahuraShowFixedMessage(ajax_data.translate.invalid_security_code, 'error');
            return false;
        }

        $.ajax({
            url: ajax_data.au,
            data: "action=ahura_user_resetpass&" + formData,
            type: 'POST',
            dataType: 'json',
            timeout: 15000,
            beforeSend: function(){
                form.addClass('blur-loading');
            },
            success: function(res){
                ahuraShowFixedMessage(res.msg, res.status);
                form.removeClass('blur-loading');
                ahuraReGenerateCaptchaCodes();

                if(res.status === 'success'){
                    form[0].reset();
                }
            },
            error: function(){
                form.removeClass('blur-loading');
                ahuraShowFixedMessage(ajax_data.translate.unknown_error, 'error');
            }
        })
    });
});