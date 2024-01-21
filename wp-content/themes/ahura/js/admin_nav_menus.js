jQuery(document).ready(function ($) {
    let refreshState = false,
        megaMenuState = $(document).find('.mega-menu-select-field')

    $(document).find('.menu-item-color-picker-input').wpColorPicker();
    
    if(refreshState === false)
    {
        setTimeout(() => {
                megaMenuState.each((index, value) => {
                    $(value).change()
                })
                refreshState = true;
        }, 1000);
    }
    
    $(document).on('change', '.mega-menu-select-field', function(e){
        let el = $(this),
            currentState = e.target.value,
            itemID = el.data('item-id')
        if(currentState == 'mega_menu')
        {
            // show other fields
            el.closest('#menu-item-settings-' + itemID).find('.menu-item-color-picker-input').closest('p').slideDown();
            el.closest('#menu-item-settings-' + itemID).find('.field-mega_menu_bg').closest('p').slideDown();
        }else{
            // hide other fields
            el.closest('#menu-item-settings-' + itemID).find('.menu-item-color-picker-input').closest('p').slideUp();
            el.closest('#menu-item-settings-' + itemID).find('.field-mega_menu_bg').closest('p').slideUp();
        }
    });

    $(document).on('change', 'select[id*="mega_menu_icon_type"]', function(e){
        let el = $(this),
            itemID = el.data('item-id'),
            selectVal = el.val();

        if(selectVal === 'image'){
            el.closest('#menu-item-settings-' + itemID).find('.mw-fonticon-selector-wrap, label[for="menu_font_icon"]').slideUp();
            el.closest('#menu-item-settings-' + itemID).find('.field-mega_menu_icon').closest('p').slideDown();
        } else {
            el.closest('#menu-item-settings-' + itemID).find('.field-mega_menu_icon').closest('p').slideUp();
            el.closest('#menu-item-settings-' + itemID).find('.mw-fonticon-selector-wrap, label[for="menu_font_icon"]').slideDown();
        }
    });

    // reinitialize color picker for new item
    $(document).on('menu-item-added', function(e, menu_item){
        let menuEl = $(menu_item);
        menuEl.find('.menu-item-color-picker-input').wpColorPicker();
        menuEl.find('.mega-menu-select-field').change();
        menuEl.find('select[id*="mega_menu_icon_type"]').change();
    })
});