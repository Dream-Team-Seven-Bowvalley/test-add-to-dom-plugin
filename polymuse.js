jQuery(document).ready(function ($) {
    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        if (galleryHeight > 0) {
            $('.polymuse-model-viewer').height(galleryHeight);
        }
    }

    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);
});
