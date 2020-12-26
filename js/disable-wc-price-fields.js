jQuery(function() {
    const sale_price_container = jQuery('p.form-field._sale_price_field');
    const sale_price_input = jQuery('input#_sale_price');

    sale_price_input.attr('disabled','true');
    sale_price_input.attr('placeholder','Dette felt er slået fra for udlejningsprodukter')

    sale_price_container.css('text-decoration', 'line-through');
    sale_price_container.children('label').css('text-decoration', 'line-through');

    sale_price_container.children().css('pointer-events', 'none');


})