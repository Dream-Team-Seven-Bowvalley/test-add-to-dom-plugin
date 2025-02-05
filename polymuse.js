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
        modelViewer.addEventListener('load', function () {
            // ... (your existing code to get model, materials, variants)

            const variantButtonsContainer = $('#variant-options-container');

            // Clear previous buttons (important!)
            variantButtonsContainer.empty();

            if (variants.length > 0) {
                variants.forEach(variant => {
                    const button = $('<button>words</button>');
                    button.text(variant);

                    // Attach event listener directly to the button
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
