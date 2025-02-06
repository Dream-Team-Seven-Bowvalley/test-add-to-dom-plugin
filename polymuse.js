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
            const model = modelViewer.getModel();
            console.log('Model viewer model:', model);
            checkIfModelViewerIsLoaded(modelViewer); // Call the function ONCE
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

