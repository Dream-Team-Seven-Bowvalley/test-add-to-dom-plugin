jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const modelViewer = $('.polymuse-model-viewer')[0];

    if (modelViewer) {
        console.log('Model viewer found');

        // Function to handle the model loaded event
        function handleModelLoaded() {
            const model = modelViewer.model;
            const materials = model ? model.materials : undefined;
            const variants = modelViewer.availableVariants || [];

            console.log('Model:', model);
            console.log('Materials:', materials);
            console.log('Variants:', variants);

            // Add buttons for variants after model is loaded
            const variantButtonsContainer = $('#variant-options-container');
            variantButtonsContainer.empty();

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
        }

        // Listen for the model-visibility event to ensure the model is fully loaded
        $(modelViewer).on('model-visibility', function () {
            handleModelLoaded();
        });

        // Check if the model is already loaded and rendered
        if (modelViewer.model) {
            handleModelLoaded();
        }
    } else {
        console.log('Model viewer not found');
    }
});
