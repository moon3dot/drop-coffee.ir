jQuery(document).ready(function ($) {
    $(document).on('input', '.search-form input[name="s"]', function (e) {
        let mw_this = $(this),
            form = mw_this.closest('form'),
            keyword = mw_this.val(),
            search_res_wrapper = $(mw_this).parent().find("#ajax_search_res"),
            post_type = $(mw_this).parent().find('.search_post_type').length ? $(mw_this).parent().find('.search_post_type').val() : 'all',
            ajax_load_spinner = $(mw_this).parent().find("#ajax_search_loading");

        if (keyword.length < 2) {
            ajax_load_spinner.removeClass('show-loader').hide();
            search_res_wrapper.html("").removeClass('show');
            return false;
        }

        ajax_load_spinner.addClass('show-loader').show();

        $.ajax({
            url: search_data.au,
            type: 'post',
            data: {
                action: 'mw_search_ajax',
                keyword: keyword,
                post_type: post_type,
                template: form.data('template') || 1,
                show_thumb: true,
                show_price: true,
            },
            success: function (response) {
                if (keyword.length < 2) {
                    search_res_wrapper.removeClass('show');
                }
                search_res_wrapper.html(response).addClass('show');
                ajax_load_spinner.removeClass('show-loader').hide();
            }
        });
    });

    $(document).on('click', 'body', function (e) {
        let mw_ajax_res_box = $('#ajax_search_res');
        // check if ajax result box is open
        if (!$(e.target).closest(mw_ajax_res_box.closest('form')).length) {
            // hide ajax result box
            mw_ajax_res_box.removeClass('show');
        }
    })

    $(document).on('focus', '.search-form input[name="s"]', function (e) {
        let mw_ajax_res_box = $('#ajax_search_res');
        if (this.value) {
            if (this.value.length < 2) {
                mw_ajax_res_box.removeClass('show');
                return false;
            }
            let mw_ajax_res_box = $('#ajax_search_res');
            // open ajax result box
            mw_ajax_res_box.addClass('show');
        }
    });
});