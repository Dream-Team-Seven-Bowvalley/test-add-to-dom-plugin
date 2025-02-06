jQuery(document).ready(function ($) {

    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

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