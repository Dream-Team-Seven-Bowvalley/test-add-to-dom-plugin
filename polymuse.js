jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // Check if the model viewer exists
    const modelViewer = $('.polymuse-model-viewer')[0];

    // If model viewer exists, listen for the load event
    if (modelViewer) {
        console.log('Model viewer found');
        // Wait for the model to be fully loaded
        const model = modelViewer.model;
        const materials = modelViewer.model.materials;
        const variants = modelViewer.availableVariants || [];  // Adjust this logic if needed

        console.log('model', model);
        console.log('materials', materials);
        console.log('variants', variants);

        // Add buttons for variants after model is loaded
        const variantButtonsContainer = $('#variant-options-container');
        // variantButtonsContainer.empty();  // Clear previous buttons

        if (variants.length > 0) {
            variants.forEach(variant => {
                const button = $('<button></button>');
                button.text(variant); // Set button text as the variant name
                button.on('click', function () {
                    modelViewer.variantName = variant;  // Update model viewer with the selected variant
                });
                variantButtonsContainer.append(button);
            });
        } else {
            variantButtonsContainer.text('No variants available');
        }
    } else {
        console.log('Model viewer not found');
    }
});



