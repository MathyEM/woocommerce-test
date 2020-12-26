jQuery(function() {
    console.log("IT WORKS");
    
    jQuery('#request-form').submit(function(e) {
        e.preventDefault();
        console.log(e);

        let data = {
            'action': 'rental_request',
            'something': 'something else'
        }

        jQuery.post(myAjax.ajaxurl, data, function(response) {
			alert('Got this from the server: ' + response);
		});
    })
});
