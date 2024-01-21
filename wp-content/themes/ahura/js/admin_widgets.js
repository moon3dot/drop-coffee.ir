jQuery(document).ready(function($){
    $(document).on('click', '.ahura_social_upload', function(e){
        e.preventDefault();
        let mw_this = $(this);
        let media_uploader = wp.media({
            title: 'Selcet an icon',
            button: {
                'text' : 'Select'
            },
            multiple: false
        });
        media_uploader.on('select', function(){
            let media_attachment = media_uploader.state().get('selection').first().toJSON(),
                wrapper = mw_this.closest('p').find('input');
            wrapper.val(media_attachment.url);
            wrapper.trigger('input');
        });
        media_uploader.open();
    });

    //Contact Widget
    $(document).on('click','#ahura_contact_widget_new_info',function(){
       let btn = $(this),
           itemsName = btn.data('item-name'),
           itemsID = btn.data('item-id'),
           itemsWrap = btn.parent().find('.contact-2-widget-items'),
           lastItemID = itemsWrap.find('.contact-item:last-child'),
           widgetID = btn.data('widget-id'),
           widgetSaveBtn = $('#widget-' + widgetID + '-savewidget');
           lastItemID = lastItemID.length > 0 ? parseInt(lastItemID.attr('item-id')) : 1;
           let ID = lastItemID + 1;
       itemsWrap.append(
           $('<div/>', {'class': 'contact-item', 'item-id': ID}).append(
               $('<button/>', {'class': 'ahura_contact_item_delete acid', 'type': 'button', text: ahura_widget_manage_translate.Delete, 'data-widget-id': widgetID}),
               $('<br/>'),
               $('<label/>', {text: ahura_widget_manage_translate.Title}),
               $('<input/>', {'type': 'text', 'class': 'widefat', 'id': `${itemsID}-${ID}`, 'name': `${itemsName}[contacts][${ID}][title]`}),
               $('<label/>', {text: ahura_widget_manage_translate.Value}),
               $('<input/>', {'type': 'text', 'class': 'widefat', 'id': `${itemsID}-${ID}`, 'name': `${itemsName}[contacts][${ID}][value]`}),
           )
       );
       if(widgetSaveBtn.length > 0){
           widgetSaveBtn.attr('disabled', false);
       }
    });

    //Handle remove contact item
    $(document).on('click','.ahura_contact_item_delete',function(){
        let btn = $(this),
            widgetID = btn.data('widget-id'),
            widgetSaveBtn = $('#widget-' + widgetID + '-savewidget'),
            newSaveBtn = $('.edit-widgets-header__actions .components-button');
        $(this).parent().slideUp(function(){
            if(widgetSaveBtn.length > 0){
                widgetSaveBtn.attr('disabled', false);
            } else if(newSaveBtn.length > 0) {
                btn.parent().find('input').change();
            }
           $(this).remove();
       });
    })
});