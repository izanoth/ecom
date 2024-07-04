import $ from 'jquery';

function mask(element, parameter) {
    IMask(element, {
        mask: parameter
    });
}
$(document).ready(function() {
    mask($('#phone')[0], '(00) 00000-0000');
})