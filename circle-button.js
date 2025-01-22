jQuery(document).ready(function($) {
    $('#green-border-button').click(function() {
        $('.woocommerce-product-gallery').removeClass('red-border').addClass('green-border');
    });

    $('#red-border-button').click(function() {
        $('.woocommerce-product-gallery').removeClass('green-border').addClass('red-border');
    });
});
