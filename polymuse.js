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

        // Hide the variations table
        // $('.variations').hide();

        // Handle variant button clicks
        $(".wp-element-button, .circle-button[data-color]").on("click", function () {
            const $button = $(this);
            let variantTitle = $button.attr("id").replace("-button", "").trim(); // Extract variant title
            let variantValue = $button.data("color") || $button.text().trim(); // Use color hex or text
            let nodes = $button.data("nodes") ? JSON.parse($button.attr("data-nodes")) : [];
            let materials = $button.data("materials") ? JSON.parse($button.attr("data-materials")) : [];

            console.log("🟢 Variant Selected:", variantTitle, variantValue, nodes, materials);

            // Update the 3D model color
            const modelViewer = document.querySelector("model-viewer");
            if (modelViewer && variantValue && materials.length > 0) {
                materials.forEach((materialName) => {
                    const material = modelViewer.model.materials.find(m => m.name === materialName);
                    if (material) {
                        material.pbrMetallicRoughness.setBaseColorFactor(variantValue);
                        console.log(`🎨 Color changed for ${materialName}: ${variantValue}`);
                    }
                });
            }

            // Highlight the selected button
            $button.siblings().removeClass("selected");
            $button.addClass("selected");
        });

    }

    handleVariantSelection();
});
