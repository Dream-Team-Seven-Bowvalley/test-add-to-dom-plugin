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

                const model = modelViewer.model;
                console.log(model);

                const materials = modelViewer.model.materials;
                console.log(materials);

                // Check for available variants
                const variants = modelViewer.availableVariants;
                console.log('Available variants:', variants);
            } else {
                console.log('Model Viewer element not found.');
            }

        })
        .catch(error => { // Handle errors if the module fails to load
            console.error('Error loading Model Viewer library:', error);
        });

});