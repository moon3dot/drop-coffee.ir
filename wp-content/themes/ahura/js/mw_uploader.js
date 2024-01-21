jQuery(document).ready(function ($) {
    $(document).on('click', '.mw_upload_media', function (e) {
        e.preventDefault();
        let mw_this = $(this);
        let mediaUploader = wp.media({
            title: 'Select',
            button: {
                'text': 'Select'
            },
            multiple: false
        });
        mediaUploader.on('select', function () {
            let mw_media_data_wrapper = mw_this.parent().next('input.mw_media_url'),
                mw_attachment = mediaUploader.state().get('selection').first().toJSON();
            mw_media_data_wrapper.val(mw_attachment.url);
        });
        mediaUploader.open();
    });

    $(document).on('click', '.ah-uploader-box .ah-select-file-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            dataType = btn.data('type') || 0,
            wrap = btn.closest('.ah-uploader-box'),
            buttons = wrap.find('.ah-select-file-btn'),
            selectedBox = wrap.find('.ah-uploader-selected'),
            attachmentSourceEl = wrap.find('.ah-attachment-source');

        let mediaArgs = {
            title: 'Select',
            button: {
                'text': 'Select'
            },
            multiple: false
        };

        if (dataType){
            mediaArgs.library = {type: dataType.split(',')};
        }

        let mediaUploader = wp.media(mediaArgs);

        mediaUploader.on('select', function () {
            let attachment = mediaUploader.state().get('selection').first().toJSON();

            if (attachment.url && attachment.id){
                if (attachment.type == 'image'){
                    if(attachmentSourceEl.length){
                        attachmentSourceEl.attr('src', attachment.url);
                    } else {
                        let image = $('<img/>', {src: attachment.url, class: 'ah-attachment-source'});
                        selectedBox.prepend(image);
                    }
                } else if(attachment.type == 'video'){
                    if(attachmentSourceEl.length){
                        attachmentSourceEl.attr('src', attachment.url);
                    } else {
                        let video = $('<video/>', {src: attachment.url, class: 'ah-attachment-source'});
                        selectedBox.prepend(video);
                    }
                } else {
                    if(attachmentSourceEl.length){
                        attachmentSourceEl.attr('src', attachment.url);
                    } else {
                        let filename = $('<div/>', {text: attachment.filename, class: 'ah-attachment-source type-text'});
                        selectedBox.prepend(filename);
                    }
                }

                wrap.find('input').val(attachment.id);
                selectedBox.show();
                buttons.hide();
            }
        });
        mediaUploader.open();
    });

    $(document).on('click', '.ah-uploader-box .ah-delete-selected-file-btn', function (e) {
        e.preventDefault();
        let btn = $(this),
            wrap = btn.closest('.ah-uploader-box'),
            selectedWrap = wrap.find('.ah-uploader-selected'),
            buttons = wrap.find('.ah-select-file-btn');
        selectedWrap.hide();
        selectedWrap.find('.ah-attachment-source').remove();
        wrap.find('input').val('');
        buttons.show();
    });
});