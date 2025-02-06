jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const modelViewer = $('model-viewer')[0];

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

        });
    } else {
        console.log('Model Viewer element not found.');
    }
});