jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    const modelViewer = document.querySelector('.polymuse-model-viewer'); // Use querySelector

    if (modelViewer) {
        console.log('Model viewer found');

        if (modelViewer.loaded) {
            console.log('Model viewer already loaded');
        } else {
            console.log('Model viewer not loaded');
            modelViewer.addEventListener('load', () => {
                console.log('Model viewer loaded');
            });
        }

    }
});