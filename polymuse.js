jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    // Dynamic import of the model-viewer library
    import('https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js')
        .then(() => {  // Library loaded successfully
            console.log('Model Viewer library loaded dynamically!');
            // Now you can safely use model-viewer

            const modelViewer = $('.polymuse-model-viewer')[0]; // jQuery selector

            if (modelViewer) {
                console.log('Model viewer found:', modelViewer);

                modelViewer.addEventListener('load', () => {
                    console.log('Model viewer loaded (event fired)');
                    // Your code to work with the model goes here
                });

                modelViewer.addEventListener('error', (error) => {
                    console.error('Model viewer loading error:', error);
                });

                if (modelViewer.hasAttribute('src')) {
                    console.log('Model viewer source:', modelViewer.getAttribute('src'));
                }
                // if(modelViewer.loaded)
                // const lookAtMeDiv = document.createElement('div');
                // lookAtMeDiv.textContent = 'Look at me';
                // $('#variant-options-container').append(lookAtMeDiv);

                checkIfModelViewerIsLoaded(modelViewer);
            } else {
                console.log('Model Viewer element not found.');
            }

        })
        .catch(error => { // Handle errors if the module fails to load
            console.error('Error loading Model Viewer library:', error);
        });

    function checkIfModelViewerIsLoaded(modelViewer) {
        if (modelViewer.loaded) console.log('Model viewer loaded');
        else {
            console.log('Model viewer not loaded');
            setTimeout(checkIfModelViewerIsLoaded(modelViewer), 1000);
        }
    }
});
