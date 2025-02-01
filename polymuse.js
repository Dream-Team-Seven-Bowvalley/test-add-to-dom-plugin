jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }
    
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    function handleVariantSelection() {
        $(".wp-element-button, .circle-button[data-color]").on("click", function () {
            const $button = $(this);
            let variantTitle = $button.attr("id").replace("-button", "").trim(); // Extract variant title
            let variantValue = $button.data("color") || $button.text().trim(); // Use color hex or text
            
            console.log("🟢 Variant Selected:", variantTitle, variantValue);

            // **Find the correct attribute name dynamically**
            let $matchingSelect = $("select").filter(function () {
                return $(this).find(`option[value="${variantTitle}"]`).length > 0;
            });

            if ($matchingSelect.length) {
                console.log(`🔍 Found select field: ${$matchingSelect.attr("name")}`);

                // Find the correct option and select it
                let $selectedOption = $matchingSelect.find(`option[value="${variantTitle}"]`);

                if ($selectedOption.length) {
                    console.log(`✅ Selecting variant: ${variantTitle}`);
                    $matchingSelect.val($selectedOption.val()).trigger("change");
                } else {
                    console.log(`⚠️ No matching option found for "${variantTitle}"`);
                }
            } else {
                console.log(`❌ No select field found for "${variantTitle}"`);
            }
        });
    }

    handleVariantSelection();
});
