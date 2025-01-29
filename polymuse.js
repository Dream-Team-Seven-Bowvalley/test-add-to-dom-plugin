jQuery(document).ready(function ($) {
     // Update hidden input field when a color button is clicked
     $('.circle-button').on('click', function () {
        var color = $(this).attr('data-color'); // Get color from button
        var capitalColor = capitalizeFirstLetter(color); // Capitalize first letter

        // Set hidden input value
        $('#product_color_variation').val(color);

        // Update select option
        // $('#color').val(capitalColor).change(); // Change event ensures UI updates properly

        // If WooCommerce uses a custom UI, trigger an event
        $('#color').trigger('change').trigger('select2:select');
    });

    // Function to capitalize the first letter of a string
    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }



    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(500);
    }

    $('form.cart').on('submit', function () {
        console.log('Hidden input field value on submit:', $('#product_color_variation').val());
    });

    // Add listener to "Proceed to Checkout" link
    $('a[href*="checkout"]').on('click', function () {
        // Display product info and metadata
        console.log('Product info and metadata:');
        console.log('Product name:', $('.product_title').text());
        console.log('Product price:', $('.price').text());
        console.log('Product color variation:', $('#product_color_variation').val());
    });

    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);
});

