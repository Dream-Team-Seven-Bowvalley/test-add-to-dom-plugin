jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // *** KEY CHANGE:  Use a MutationObserver ***
    const variantButtonsContainer = $('#variant-options-container');

    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes) {
                mutation.addedNodes.forEach(function(node) {
                    // Check if the model-viewer has been added
                    if (node.classList && node.classList.contains('polymuse-model-viewer')) {
                        const modelViewer = node.querySelector('model-viewer'); // Get the model-viewer inside

                        if (modelViewer) {
                            modelViewer.addEventListener('load', function () {
                                const model = modelViewer.model;
                                const materials = modelViewer.model.materials;
                                const variants = modelViewer.availableVariants || [];

                                variantButtonsContainer.empty(); // Clear previous buttons

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
                        }
                    }
                });
            }
        });
    });

    // Start observing the container for changes (specifically, when the model-viewer is added)
    observer.observe(variantButtonsContainer[0], { childList: true, subtree: true }); // subtree for nested elements


});