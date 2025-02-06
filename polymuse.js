jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);


    const modelViewer = document.querySelector('model-viewer');


    if (modelViewer) {
        console.log('Model viewer found:', modelViewer);

        $(modelViewer).on('load', () => {
            console.log('Model viewer loaded (event fired)');
            const model = modelViewer.model;
            console.log('Model:', model);

            const materials = modelViewer.model.materials;
            console.log(materials);

            // Check for available variants
            const variants = modelViewer.availableVariants;
            console.log('Available variants:', variants);

            // Get the container
            const container = $('#variant-options-container')[0];

            if (container) {
                // Add materials info
                if (materials && materials.length > 0) {
                    const materialsDiv = document.createElement('div');
                    materialsDiv.innerHTML = '<h4>Materials:</h4>';
                    materials.forEach(material => {
                        materialsDiv.innerHTML += `<div>${material.name}</div>`;
                    });
                    container.appendChild(materialsDiv);
                }

                // Add variants info
                if (variants && variants.length > 0) {
                    const variantsDiv = document.createElement('div');
                    variantsDiv.innerHTML = '<h4>Variants:</h4>';
                    variants.forEach(variant => {
                        variantsDiv.innerHTML += `<button onclick="modelViewer.variantName='${variant}'">${variant}</button>`;
                    });
                    container.appendChild(variantsDiv);
                }
            }

            // checkIfModelViewerIsLoaded(modelViewer); // Call the function ONCE
        });


    } else {
        console.log('Model Viewer element not found.');
    }

    function checkIfModelViewerIsLoaded(modelViewer) {
        if (modelViewer && modelViewer.loaded) { // Check if modelViewer exists and is loaded
            console.log('Model viewer loaded');
        } else {
            console.log('Model viewer not loaded');
            setTimeout(() => checkIfModelViewerIsLoaded(modelViewer), 1000); // Correct: Pass function REFERENCE
        }
    }
});

