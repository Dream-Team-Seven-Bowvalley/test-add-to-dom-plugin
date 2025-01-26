// jQuery(document).ready(function($) {
//     // Ensure the 3D model slide is the same height as other slides
//     function adjustModelViewerHeight() {
//         var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
//         //console.log(galleryHeight);
//         $('.polymuse-model-viewer').height(500);
//     }

//     // Run on page load and when the window is resized
//     adjustModelViewerHeight();
//     $(window).resize(adjustModelViewerHeight);  

// });

jQuery(document).ready(function($) {
    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(galleryHeight);
    }

    // Get the 3D model thumbnail
    var $modelThumbnail = $('.model-thumbnail[data-is-3d-model="true"]');

    // Get the main image container
    var $mainImageContainer = $('.woocommerce-product-gallery__image');

    // Add a click event handler to the 3D model thumbnail
    $modelThumbnail.on('click', function(event) {
        event.preventDefault();

        // Get the 3D model viewer element
        var $modelViewer = $('.polymuse-model-viewer');

        // Show the 3D model viewer element
        $modelViewer.show();

        // Hide the main image container
        $mainImageContainer.hide();
    });

    // Run on page load, window resize, and orientation change
    $(window).on('resize orientationchange', adjustModelViewerHeight);
    adjustModelViewerHeight();
});