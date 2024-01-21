jQuery(document).ready(function($){
    function notice(msg, type='error')
    {
        let noticeBox = $('.ahura-child-page-wrapper .result-msg')
        noticeBox.text(msg)
        noticeBox.attr('class', `result-msg ${type}`)
        noticeBox.show()
    }
    $(".start-btn").on('click', function(e){
        let el = $(this),
            moveCustomizer = $('#move_customizer').is(':checked');

        el.addClass('disabled')
        notice(ahura_child_data.msg.on_process, null);

        let ajaxData = {
            action: 'ahura_create_child_theme',
        };

        if(moveCustomizer){
            ajaxData['move_customizer'] = true;
        }

        $.ajax({
            url: ahura_child_data.ajax_url,
            dataType: 'json',
            type: 'post',
            data: ajaxData,
            success: response => {
                if(response.code !== 200)
                {
                    el.removeClass('disabled')
                }
                if(response.msg)
                {
                    notice(response.msg, response.code == 200 ? 'success' : 'error')
                }
            },
            error: err => {
                notice('Has error in request')
                el.removeClass('disabled')
            }
        })
    })
})