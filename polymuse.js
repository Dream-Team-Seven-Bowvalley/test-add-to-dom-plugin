jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }
    
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    function handleVariantSelection() {
        $(".wp-element-button, .circle-button[data-color]").on("click", function () {
            const $button = $(this);
            let variantTitle = $button.attr("id").replace("-button", "").trim(); // Clean title
            let variantValue = $button.data("color") || $button.text().trim(); // Get value

            console.log("Variant Selected:", variantTitle, variantValue);

            // Convert title to match WooCommerce attribute naming
            let attributeName = `attribute_${variantTitle.toLowerCase().replace(/\s+/g, '_')}`;
            console.log(`Looking for select field: ${attributeName}`);

            // Find the corresponding WooCommerce select field
            const $variantSelect = $(`select[name="${attributeName}"]`);

            if ($variantSelect.length) {
                const $selectedOption = $variantSelect.find(`option[value="${variantValue}"]`);

                if ($selectedOption.length) {
                    console.log(`Selecting variant: ${variantValue} for ${variantTitle}`);
                    $variantSelect.val($selectedOption.val()).trigger("change");
                } else {
                    console.log("No matching option found in the select dropdown.");
                }
            } else {
                console.log(`No select field found for ${variantTitle} (expected name: ${attributeName})`);
            }
        });
    }

    handleVariantSelection();
});
