jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const modelViewer = document.querySelector('.polymuse-model-viewer'); // Use querySelector

    if (modelViewer) {
        console.log('Model viewer found');

        modelViewer.addEventListener('load', () => { // Listen for the model-viewer load event
            console.log('Model viewer loaded');

            const model = modelViewer.model;
            console.log('model', model);

            model.addEventListener('load', () => { // listen for the model load event
                console.log('Model Loaded');
                const materials = model.materials;
                const variants = model.availableVariants || [];

                console.log('materials', materials);
                console.log('variants', variants);

                const variantButtonsContainer = $('#variant-options-container');
                if (variants.length > 0) {
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


            model.addEventListener('error', (error) => {
                console.error('Model loading error:', error);
            });

        });

        modelViewer.addEventListener('error', (error) => {
            console.error('Model viewer loading error:', error);
        });

    } else {
        console.log('Model viewer not found');
    }
});