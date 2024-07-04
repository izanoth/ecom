/*****************************
 * Adding New Category/Brand *
/****************************/
document.addEventListener('alpine:init', () => {
    Alpine.data('newCatOrBrand', () => ({
        submitData(event) {
            let element = event.target;
            var value = element.getAttribute('data-value');
            var route = element.getAttribute('data-route');
            var belongs = element.getAttribute('id');
            var select = document.getElementById(element.getAttribute(
                'data-option'));
            axios.get(route, {
                params: {
                    belongs: belongs,
                    title: value
                }
            })
                .then(response => {
                    var new_id = response.data.id;
                    var new_title = response.data.title;
                    var message = response.data.message;
                    window.alert(message);
                    var new_option = document.createElement(
                        'option');
                    new_option.setAttribute('value', new_id);
                    var textNode = document.createTextNode(
                        new_title);
                    new_option.appendChild(textNode);
                    select.appendChild(new_option);
                })
                .catch(function (error) {
                    console.error('Detalhes do erro:', error
                        .message);
                })
        },
    }));

    

});


