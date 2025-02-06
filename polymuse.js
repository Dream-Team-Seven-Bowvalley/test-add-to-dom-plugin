jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);


    function checkModelViewerLoaded() {
        if (window.ModelViewer) {
            console.log('Model Viewer library loaded!');
            const modelViewer = $('.polymuse-model-viewer')[0]; // Use jQuery selector
            if (modelViewer) {
                modelViewer.addEventListener('load', () => {
                    console.log('Model viewer loaded (event fired)');
                    // Your code to work with the model goes here
                });
                modelViewer.addEventListener('error', (error) => {
                    console.error('Model viewer loading error:', error);
                });
            } else {
                console.log('Model Viewer element not found.');
            }
        } else {
            console.log('Model Viewer library not yet loaded. Checking again...');
            setTimeout(checkModelViewerLoaded, 100);
        }
    }

    checkModelViewerLoaded();

    const modelViewer = $('.polymuse-model-viewer')[0];

    if (modelViewer) {
        console.log('Model viewer found:', modelViewer);
    }

    modelViewer.addEventListener('load', () => {
        console.log('Model viewer loaded (event fired)');
    });

    modelViewer.addEventListener('error', (error) => {
        console.error('Model viewer loading error:', error);
    });
});