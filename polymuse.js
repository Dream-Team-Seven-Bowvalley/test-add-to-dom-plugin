jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    function handleVariantSelection() {
        // Hide all select elements and insert a label to display selected values
        $("select").each(function () {
            const $select = $(this);
            const attributeName = $select.attr("name"); // Example: "attribute_color"

            // Hide the dropdown
            $select.hide();

            // Insert a label after the select to display the selected variant
            $('<label class="selected-variant-label">' +
                `<span class="selected-variant" data-attribute="${attributeName}">Choose an option</span>` +
                '</label>').insertAfter($select);
        });

        // Handle variant button clicks
        $(".wp-element-button, .circle-button[data-color]").on("click", function () {
            const $button = $(this);
            let variantTitle = $button.attr("id")?.replace("-button", "").trim(); // Extract variant title
            let variantValue = $button.data("color") || $button.text().trim(); // Use color hex or text

            console.log("🟢 Variant Selected:", variantTitle, variantValue);

            // **Find the correct select field dynamically**
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

                    // Update label next to the select dropdown
                    $(`.selected-variant[data-attribute="${$matchingSelect.attr("name")}"]`).text(variantTitle);

                    // Update the 3D model color(For education not useful for production)
                    const $modelViewer = $("model-viewer");
                    if ($modelViewer.length && variantValue) {
                        const materials = $modelViewer[0].model?.materials || [];
                        if (materials.length > 0) {
                            materials.forEach((material) => {
                                material.pbrMetallicRoughness.setBaseColorFactor(variantValue);
                                console.log(`🎨 Color changed for ${material.name}: ${variantValue}`);
                            });
                        } else {
                            console.warn("⚠️ No materials found in model.");
                        }
                    }
                } else {
                    console.log(`⚠️ No matching option found for "${variantTitle}"`);
                }
            } else {
                console.log(`❌ No select field found for "${variantTitle}"`);
            }

            // Highlight the selected button
            $button.siblings().removeClass("selected");
            $button.addClass("selected");
        });
    }

    handleVariantSelection();
});
