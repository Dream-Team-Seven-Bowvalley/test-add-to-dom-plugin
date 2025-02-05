jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // Check if the model viewer exists
    const modelViewer = $('.polymuse-model-viewer')[0];

    // If model viewer exists, set up the mutation observer
    if (modelViewer) {
        console.log('Model viewer found');

        // Create a mutation observer to monitor changes to the model viewer
        const observer = new MutationObserver(function (mutationsList) {
            for (const mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'model') {
                    handleModelLoaded();
                }
            }
        });

        // Start observing the model viewer for attribute changes
        observer.observe(modelViewer, {
            attributes: true, // Monitor attribute changes
            attributeFilter: ['model'] // Only monitor changes to the 'model' attribute
        });

        function handleModelLoaded() {
            const model = modelViewer.model;
            const materials = model.materials;
            const variants = modelViewer.availableVariants || []; // Adjust this logic if needed

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
                        modelViewer.variantName = variant; // Update model viewer with the selected variant
                    });
                    variantButtonsContainer.append(button);
                });
            } else {
                variantButtonsContainer.text('No variants available');
            }
        }
    } else {
        console.log('Model viewer not found');
    }
});
