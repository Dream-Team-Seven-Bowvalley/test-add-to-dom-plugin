jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const modelViewer = $('.polymuse-model-viewer')[0];

    if (modelViewer) {
        console.log('Model viewer found');

        if (modelViewer.loaded) {
            console.log('Model viewer already loaded');
        } else {
            console.log('Model viewer not loaded');
            setTimeout(() => {
                if (modelViewer.loaded) {
                    console.log('Model viewer loaded');
                }
                else {
                    console.log('Model viewer not loaded');
                }
            }, 3000);
        }

        modelViewer.addEventListener('load', () => {  // The ONLY reliable way
            console.log('Model viewer loaded (event fired)');
            // Your code to work with the model goes HERE.
            // Now you can access modelViewer.model, etc.
        });

        modelViewer.addEventListener('error', (error) => {
            console.error('Model viewer loading error:', error);
        });
    }
});