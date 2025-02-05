jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // Get the model viewer element
    const modelViewer = $('.polymuse-model-viewer')[0];

    // Add event listener for load event
    $(modelViewer).on('load', function () {
        const model = modelViewer.model;
        console.log(model);

        const materials = modelViewer.model.materials;
        console.log(materials);

        // Check for available variants
        const variants = modelViewer.availableVariants;
        console.log('Available variants:', variants);

        // Get material info for each variant
        const variantInfo = {};
        if (variants) {
            variants.forEach(variant => {
                modelViewer.variantName = variant;
                const material = modelViewer.model.materials[0]; // Assuming first material
                if (material && material.pbrMetallicRoughness && material.pbrMetallicRoughness.baseColorFactor) {
                    variantInfo[variant] = material.pbrMetallicRoughness.baseColorFactor;
                }
            });
            // Reset to first variant
            modelViewer.variantName = variants[0];
        }

        // Create buttons for each variant
        const variantButtonsContainer = $('.variant-options-container');
        variantButtonsContainer.empty();
        if (variants && variants.length > 0) {
            variants.forEach(variant => {
                const button = $('<button></button>');
                button.text(variant);
                button.on('click', function () {
                    modelViewer.variantName = variant;
                });
                variantButtonsContainer.append(button);
            });
        } else {
            variantButtonsContainer.text('No variants available');
        }
    });
});