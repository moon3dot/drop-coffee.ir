jQuery(document).ready(function($){
    let uploader;
    $("#term_meta_choose_icon").on('click', function(e){
        e.preventDefault()
        if(uploader)
        {
            uploader.open()
            return
        }
        let mwthis = $(this),
            parent = mwthis.parent()
        uploader = wp.media()
        uploader.open()
        uploader.on('select', function(){
            let attachment = uploader.state().get('selection').first().toJSON(),
                img = $('<img>')
            img.attr('src', attachment.sizes.full.url)
            img.css('width', '100%')
            parent.find('#icon-preview').html(img)
            parent.find('input[name="term_meta[icon]"]').val(attachment.id)
            parent.find('#term_meta_remove_icon').show()
        })
    })
    $("#term_meta_remove_icon").on('click', function(e){
        e.preventDefault()
        let mwthis = $(this),
            parent = mwthis.parent()
        
        parent.find('input[name="term_meta[icon]"]').val('')
        parent.find('#icon-preview').html('')
        mwthis.hide()
    })
})