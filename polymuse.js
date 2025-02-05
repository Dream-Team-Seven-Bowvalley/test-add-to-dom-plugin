jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize({ passive: true }, adjustModelViewerHeight);

    const modelViewer = $('.polymuse-model-viewer')[0];

    if (modelViewer) {
        console.log('Look at me');

        // Wait for the model to load and become available
        modelViewer.addEventListener('load', function () {
            console.log('Model loaded');
            const model = modelViewer.model;
            const materials = model.materials;
            const variants = modelViewer.availableVariants || [];

            console.log('Model:', model);
            console.log('Materials:', materials);
            console.log('Variants:', variants);

            // Add buttons for variants after model is loaded
            const variantButtonsContainer = $('#variant-options-container');
            variantButtonsContainer.empty();

            if (variants.length > 0) {
                variants.forEach(variant => {
                    console.log('Adding variant button:', variant);
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
    }
});
