jQuery(document).ready(function($){
    $(document).on('click', '.ahura_element_faq_4 .ah-items .ah-item', function(e){
        let el = $(this),
            description = el.find('.ah-description'),
            itemsWrapper = el.closest('.ah-items'),
            item = el.closest('.ah-item')

        let isCurrentItem = item.hasClass('ah-open')

        itemsWrapper.find('.ah-open').removeClass('ah-open')
        itemsWrapper.find('.ah-item .ah-description').slideUp()

        if(!isCurrentItem)
        {
            item.addClass('ah-open')    
            description.slideDown()
        }
    })
})