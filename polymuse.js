jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);
    

    const modelViewer = $('#product-model-viewer-element');
   

    if (modelViewer) {
        console.log('Model viewer found:', modelViewer);

        $(modelViewer).on('load', () => {
            console.log('Model viewer loaded (event fired)');
            // Your code to work with the model goes here
        });

        $(modelViewer).on('model-ready', () => {
            console.log('Model viewer loaded (model-ready event fired)');
            // Your code to work with the model goes here
        });

        // Undefined
        const model = modelViewer.model;
        console.log('Model viewer model:', model);

        // Never fires
        modelViewer.addEventListener('load', () => {
            console.log('Model viewer loaded (event fired)');
            // Your code to work with the model goes here
        });
        // Never fires
        modelViewer.addEventListener('error', (error) => {
            console.error('Model viewer loading error:', error);
        });
        // Never fires
        if (modelViewer.hasAttribute('src')) {
            console.log('Model viewer source:', modelViewer.getAttribute('src'));
        }

        // Goes for ever 
        // checkIfModelViewerIsLoaded(modelViewer); // Call the function ONCE

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

