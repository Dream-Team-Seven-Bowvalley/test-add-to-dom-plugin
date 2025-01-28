jQuery(document).ready(function ($) {
    // Update hidden input field when a color button is clicked
    $('.circle-button').on('click', function () {
        console.log('Button clicked!');
        var color = $(this).attr('data-color'); // Use data-color instead of id
        console.log('Color:', color);
        $('#product_color_variation').val(color);
        console.log('Hidden input field value:', $('#product_color_variation').val());
    })

    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(500);
    }

    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);
});