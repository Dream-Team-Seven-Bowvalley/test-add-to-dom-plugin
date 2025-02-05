jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize({ passive: true }, adjustModelViewerHeight);

    const modelViewer = $('.polymuse-model-viewer')[0];

    if (modelViewer) {
        console.log('Look at me');
        const checkModelLoaded = () => {
            if (modelViewer.model && modelViewer.model.materials) {
                const model = modelViewer.model;
                const materials = modelViewer.model.materials;
                const variants = modelViewer.availableVariants || [];

                console.log('Look at me 1');
                console.log('model', model);
                console.log('materials', materials);
                console.log('variants', variants);

                // Add buttons for variants after model is loaded
                const variantButtonsContainer = $('#variant-options-container');
                variantButtonsContainer.empty();

                if (variants.length > 0) {
                    variants.forEach(variant => {
                        console.log('Look at me 2');
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
            } else {
                setTimeout(checkModelLoaded, 100);
            }
        };
        checkModelLoaded();
    }
});