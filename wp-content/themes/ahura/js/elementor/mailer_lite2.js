jQuery(document).ready(function($){
    $('body').on('submit', '.mailerlite-subscribe-form', function(e){
        e.preventDefault();
        let form = $(this),
            loader = form.find('.line-loader'),
            fields = form.find('.ml-form-input'), 
            successMsg = form.data('success-message'),
            errorMsg = form.data('error-message'),
            item, field, fieldType, fieldVal, isTextarea, msg, error = 0;

        fields.each(function(i){
            item = $(this);
            isTextarea = item.hasClass('ml-form-textarea');
            field = isTextarea ? item.find('textarea') : item.find('input');
            fieldType = isTextarea ? 'textarea' : field.attr('type');
            fieldVal = field.val();

            item.removeClass('invalid');

            if(item.hasClass('ml-validate-required')){
                if(fieldType == 'radio' || fieldType == 'checkbox'){
                    if(!field.prop('checked')){
                        item.addClass('invalid');
                        error = 1;
                    }
                } else {
                    item.removeClass('invalid');
                    if(!fieldVal.length){
                        item.addClass('invalid');
                        error = 1;
                    }
                }
            }
            if(item.hasClass('ml-validate-email')){
                if(!fieldVal.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
                    item.addClass('invalid');
                    error = 1;
                }
            }
        });

        if(error || form.hasClass('has-loader')){
            return false;
        }

        $.ajax({
            url: ajax_data.au,
            data: "action=ahura_mailer_lite_subscribe&" + form.serialize(),
            type: 'POST',
            dataType: 'json',
            beforeSend: function () {
                ahuraDestroyFixedMessages(5);
                form.addClass('has-loader');
                loader.slideDown();
            },
            success: function (res) {
                form.removeClass('has-loader');
                loader.slideUp();

                if(res.message !== undefined){
                    msg = res.message;
                } else {
                    if(res.status == 'success' && successMsg.length){
                        msg = successMsg;
                    } else if(errorMsg.length){
                        msg = errorMsg;
                    }
                }

                ahuraShowFixedMessage(msg, res.status);

                if(res.status == 'success'){
                    form[0].reset();
                }
            },
            error: function (){
                ahuraDestroyFixedMessages();
                form.removeClass('has-loader');
                loader.slideUp();
            }
        });
    });
});