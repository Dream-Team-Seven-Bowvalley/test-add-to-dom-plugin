jQuery(document).ready(function ($) {

    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(500);
    }
    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const $colorSelect = $("select[name='attribute_color']");
    $(".circle-button[data-color]").on("click", function () {
        const color = $(this).data("color");
        const $selectedOption = $colorSelect.find(`option[value="${color}"]`);
        console.log('Selected option:', $selectedOption.length ? $selectedOption.val() : 'not found');
        $colorSelect.val($selectedOption.val()).trigger('change');
    });

});

