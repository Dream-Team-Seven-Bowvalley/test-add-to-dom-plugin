jQuery(document).ready(function($) {
    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(500);
    }

    // Run on page load and when the window is resized
    adjustModelViewerHeight();

    // Use passive event listener for resize to avoid blocking scroll
    if (window.matchMedia('(pointer: fine)').matches) {
        // This is a workaround if you're dealing with other event listeners being active
        $(window).on('resize', { passive: true }, adjustModelViewerHeight);
    } else {
        $(window).resize(adjustModelViewerHeight);
    }
});