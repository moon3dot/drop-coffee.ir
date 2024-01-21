jQuery(document).ready(function($){
    function get_radio_field_value(el)
    {
        let fieldName = el.attr('name'),
            fieldEl = $(`input[name=${fieldName}]`),
            value = fieldEl.filter(':checked').val()
        return value
    }
    function change_radio_value(input, value)
    {
        input.filter(`[value=${value}]`).prop('checked', true)
        // input.change()
    }
    function is_in_rtl_mode()
    {
        return $('body').hasClass('rtl')
    }
    // handle logo alignment
    $('input[data-customize-setting-link="ahura_header_logo_alignment"]').on('change', function(e){
        // let value = $(this).val()
        let value = get_radio_field_value($(this))

        let action_box_position = $('input[data-customize-setting-link="ahura_action_btn_alignment"]'),
            action_box_position_checked_item = action_box_position.filter(':checked')
        switch(value)
        {
            case 'right':
                // change action box alignment if it is in right section
                if(action_box_position_checked_item.val() == 'right')
                {
                    change_radio_value(action_box_position, 'left')
                    action_box_position_checked_item.change()
                }
            break;
            case 'center':
                let menu_position = $('input[data-customize-setting-link="ahura_menu_position"]')
                // if menu position is middle change it to top
                let menu_position_checked_item = menu_position.filter(':checked')
                if(menu_position_checked_item.val() == 'middle')
                {
                    change_radio_value(menu_position, 'top')
                    menu_position_checked_item.change()
                }
            break;
            case 'left':
                // change action box alignment if it is in left section
                if(action_box_position_checked_item.val() == 'left')
                {
                    change_radio_value(action_box_position, 'right')
                    action_box_position_checked_item.change()
                }
            break;
        }
    })
    // haneld menu position
    $('input[data-customize-setting-link="ahura_menu_position"]').on('change', function(e){
        // let value = $(this).val()
        let value = get_radio_field_value($(this))
        switch(value)
        {
            case 'top':
                break;
            case 'middle':
                // check logo alignment
                let logo_alignment = $('input[data-customize-setting-link="ahura_header_logo_alignment"]'),
                    current_logo_alignment_item = logo_alignment.filter(':checked')
                // if logo alignment is center change it alignment
                if(current_logo_alignment_item.val() == 'center')
                {
                    change_radio_value(logo_alignment, is_in_rtl_mode() ? 'right' : 'left')
                    current_logo_alignment_item.change()
                }
                break;
            case 'bottom':
                // if is rtl => mega menu: right, menu: left
                let mega_menu_alignment = $('input[data-customize-setting-link="ahura_mega_menu_alignment"]'),
                    mega_menu_alignment_checked_item = mega_menu_alignment.filter(':checked')
                let menu_alignment = $('input[data-customize-setting-link="ahura_menu_alignment"]'),
                    menu_alignment_checked_item = menu_alignment.filter(':checked')

                if(mega_menu_alignment_checked_item.val() == 'right')
                {
                    // set menu alignment left
                    change_radio_value(menu_alignment, 'left')
                    menu_alignment_checked_item.change()
                }else{
                    // set menu alignment right
                    change_radio_value(menu_alignment, 'right')
                    menu_alignment_checked_item.change()
                }
                break;
        }
    });
    // handle menu alignment
    $('input[data-customize-setting-link="ahura_menu_alignment"]').on('change', function(e){
        let value = get_radio_field_value($(this))
        let mega_menu_alignment = $('input[data-customize-setting-link="ahura_mega_menu_alignment"]'),
            mega_menu_alignment_checked_item = mega_menu_alignment.filter(':checked')
        let menu_position = $('input[data-customize-setting-link="ahura_menu_position"]'),
            menu_position_checked_item = menu_position.filter(':checked')
        if(menu_position_checked_item.val() == 'top' || menu_position_checked_item.val() == 'middle')
        {
            return;
        }
        if(value == 'right')
        {
            // set mega menu alignemtn to left       
            if(mega_menu_alignment_checked_item.val() == 'right')     
            {
                change_radio_value(mega_menu_alignment, 'left')
                mega_menu_alignment_checked_item.change()
            }
        }else{
            // set mega menu alignment ro right
            if(mega_menu_alignment_checked_item.val() == 'left')
            {
                change_radio_value(mega_menu_alignment, 'right')
                mega_menu_alignment_checked_item.change()
            }
        }
    })
    // handle mega menu alignment
    $('input[data-customize-setting-link="ahura_mega_menu_alignment"]').on('change', function(e){
        let value = get_radio_field_value($(this))
        let menu_alignment = $('input[data-customize-setting-link="ahura_menu_alignment"]'),
            menu_alignment_checked_item = menu_alignment.filter(':checked')
        
        let menu_position = $('input[data-customize-setting-link="ahura_menu_position"]'),
            menu_position_checked_item = menu_position.filter(':checked')
        if(menu_position_checked_item.val() == 'top' || menu_position_checked_item.val() == 'middle')
        {
            return;
        }
        if(value == 'right')
        {
            // set menu alignment to left
            if(menu_alignment_checked_item.val() == 'right')
            {
                change_radio_value(menu_alignment, 'left')
                menu_alignment_checked_item.change()
            }
        }else{
            // set menu alignment to right
            if(menu_alignment_checked_item.val() == 'left')
            {
                change_radio_value(menu_alignment, 'right')
                menu_alignment_checked_item.change()
            }
        }
    })

    // handle action box alignment
    $('input[data-customize-setting-link="ahura_action_btn_alignment"]').on('change', function(e){
        let value = get_radio_field_value($(this))
        let logo_alignment = $('input[data-customize-setting-link="ahura_header_logo_alignment"]'),
            logo_alignment_checked_item = logo_alignment.filter(':checked')
        if(value == 'right')
        {
            // check logo alignment
            if(logo_alignment_checked_item.val() == 'right')
            {
                change_radio_value(logo_alignment, 'left')
                logo_alignment_checked_item.change()
            }
        }else{
            // check logo alignment
            if(logo_alignment_checked_item.val() == 'left')
            {
                change_radio_value(logo_alignment, 'right')
                logo_alignment_checked_item.change()
            }
        }
    });

    $('body').on('change', '.ahura-section-select-on-change', function(){
        let select = $(this),
            selectVal = select.val(),
            affected = select.data('affected'),
            affectedEl = (affected && affected !== undefined) ? $(affected) : false,
            affectedAttr = select.data('affected-attr'),
            affectedPattern = select.data('affected-pattern'),
            affectedVal = select.data('affected-value'),
            affectedAttrVal,
            regex,
            regexRes;

        if(affectedEl && selectVal){
            affectedAttrVal = affectedEl.attr(affectedAttr);
            if(affectedPattern){
                regex = affectedAttrVal.match(new RegExp(affectedPattern));
                regexRes = regex[1];
                affectedEl.attr(affectedAttr, affectedAttrVal.replace(regexRes, selectVal));
            } else {
                if(affectedVal){
                    selectVal = affectedVal;
                }
                affectedEl.attr(affectedAttr, selectVal);
            }
        }
    });

    /**
     * 
     * 
     * Customizer reset button
     * 
     * 
     */
     var $container = $('#customize-header-actions');
     var $button = $('<input type="submit" name="ahura-customizer-reset" id="ahura-customizer-reset" class="button-secondary button">')
         .attr('value', ahura_customizer_data.reset)
         .css({
             'float': $('body').hasClass('rtl') ? 'left' : 'right',
             'margin': '0 9px',
             'margin-top': '9px'
         });
     $button.on('click', function (event) {
         event.preventDefault();
 
         var data = {
             wp_customize: 'on',
             action: 'ahura_customizer_reset',
             nonce: ahura_customizer_data.nonce.reset
         };
 
         var response = confirm(ahura_customizer_data.confirm);
 
         if (!response) return;
 
         $button.attr('disabled', 'disabled');
 
         $.post(ahura_customizer_data.au, data, function () {
             wp.customize.state('saved').set(true);
             location.reload();
         });
     });
     $container.append($button);

     /**
      * 
      * 
      * Customizer backup
      * 
      * 
      */
      var Ahura_Customizer_Backup = {
		init: function()
		{
			$('input[name=ahura-export-button]').on('click', Ahura_Customizer_Backup.export);
			$('input[name=ahura-import-button]').on('click', Ahura_Customizer_Backup.import);
			$('.ahura-description').css('background', '#FFF');
			$('.ahura-description').css('padding', '10px');
		},
	
		export: function()
		{
			window.location.href = ahura_customizer_data.customizer_url + '?ahura-customizer-export=' + ahura_customizer_data.nonce.export;
		},
	
		import: function()
		{
			var win = $(window),
				body = $('body'),
				form = $('<form class="ahura-customizer-backup-form" method="POST" enctype="multipart/form-data"></form>'),
				controls = $('.ahura-import-controls'),
				file = $('input[name=ahura-import-file]'),
				message = $('.ahura-uploading');
			
			if ('' == file.val()) {
				alert(ahura_customizer_data.empty_import);
			} else {
				win.off('beforeunload');
				body.append(form);
				form.append(controls);
				message.show();
				form.submit();
			}
		}
	};
	
	$(Ahura_Customizer_Backup.init);

    $('.ahura-select').select2({
        placeholder: ahura_customizer_data.translate.select,
        allowClear: true
    });
})