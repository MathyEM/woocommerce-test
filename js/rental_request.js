jQuery(function() {
    console.log("IT WORKS");
    
    jQuery('#request-form').submit(function(e) {
        e.preventDefault();

        let email = jQuery('#email').val();
        let phone = jQuery('#phone').val();
        let post_id = jQuery('#post-id').val();

        let product_name;
        let product_cat;
        let rental_prices;

        let date = new Date().toLocaleDateString("da-DK").replaceAll('.', '/');
        
        let data = {
            'action': 'rental_request',
            'email': email,
            'phone': phone,
            'post_id': post_id
        }

        jQuery.post(myAjax.ajaxurl, data, function(response) {
            res = JSON.parse(response);

            product_name = res.product_name;
            product_cat = res.product_cat;
            rental_prices = "Dagspris: " + res.day_price + "kr., ";
            rental_prices += "Ugentlig pris: " + res.week_price + "kr., ";
            rental_prices += "Månedlig pris: " + res.month_price + "kr.";

            let html = `
                <p>Du har sendt en forespørgsel fra ${email} og ${phone}.
                Du har sendt en forespørgsel på følgende produkt:</p>
                <ul>
                    <li><span class="font-weight-bold">Produkt:</span> ${product_name}</li>
                    <li><span class="font-weight-bold">Kategori:</span> ${product_cat}</li>
                    <li><span class="font-weight-bold">Pris:</span> ${rental_prices}</li>
                    <li><span class="font-weight-bold">Dato for forespørgsel:</span> ${date}</li>
                </ul>
            `;
            jQuery('#rental-response').html(html);
        });
    })
});
