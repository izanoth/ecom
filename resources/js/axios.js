
$(document).ready(function () {
    /*******************/
    //Cart Async Update//
    /*******************/
    $(document).on('change', '[name="update"].cart_update', function() {
        var cart_id = $(this).data('id');
        var dropdown_element = $('#cart_units'+cart_id);
        var cart_units = $(this).val();
        axios.post('/cart/update', {
            id: cart_id,
            units: cart_units
        })
        .then(response => {
            console.log('ok');
            console.log(cart_units);
            console.log(dropdown_element.html(cart_units+' un.'));
                dropdown_element.html(cart_units+' un.');
                var subtotal = $('.subtotal[data-id="'+cart_id+'"]');
                subtotal.hide();
                subtotal.fadeIn('slow').html(response.data.subtotal);
            })
            .catch(function (error) {
                /*********                  ***********/
                console.error('Detalhes do erro:', error.message);
     
            })
    });


});