jQuery(function() {
    const reg_price_container = jQuery('p.form-field._regular_price_field');
    const reg_price_input = jQuery('input#_regular_price');
    disablePrices(reg_price_container, reg_price_input);

    const sale_price_container = jQuery('p.form-field._sale_price_field');
    const sale_price_input = jQuery('input#_sale_price');
    disablePrices(sale_price_container, sale_price_input);

    function disablePrices(container, input) {
        input.attr('disabled','true');
        input.attr('placeholder','Dette felt er slået fra for udlejningsprodukter')
    
        container.css('text-decoration', 'line-through');
        container.children('label').css('text-decoration', 'line-through');
    
        container.children().css('pointer-events', 'none');
    }


})