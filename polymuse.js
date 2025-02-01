jQuery(document).ready(function ($) {
    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
        var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
        $('.polymuse-model-viewer').height(500);
    }
    
    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // Function to handle variant selection
    function handleVariantSelection() {
        $(".wp-element-button, .circle-button[data-color]").on("click", function () {
            const $button = $(this);
            const variantTitle = $button.attr("id").replace("-button", ""); // Get title name
            const variantValue = $button.data("color") || $button.text().trim(); // Get variant value

            console.log("Variant Selected:", variantTitle, variantValue);

            // Find the corresponding WooCommerce select dropdown
            const $variantSelect = $(`select[name='attribute_${variantTitle.toLowerCase()}']`);

            if ($variantSelect.length) {
                const $selectedOption = $variantSelect.find(`option[value="${variantValue}"]`);

                if ($selectedOption.length) {
                    console.log(`Selecting variant: ${variantValue} for ${variantTitle}`);
                    $variantSelect.val($selectedOption.val()).trigger("change");
                } else {
                    console.log("No matching option found in the select dropdown.");
                }
            } else {
                console.log(`No select field found for ${variantTitle}`);
            }
        });
    }

    // Run on document ready
    handleVariantSelection();
});
