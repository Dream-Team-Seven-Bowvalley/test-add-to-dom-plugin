jQuery(document).ready(function ($) {
    const modelViewer = $('model-viewer')
    const variantButtonsContainer = $('#variant-buttons')[0];

    $(modelViewer).on('load', function () {
        const model = modelViewer.model;
        console.log(model);

        const materials = modelViewer.model.materials;
        console.log(materials);

        // Check for available variants
        const variants = modelViewer.availableVariants;
        console.log('Available variants:', variants);
    });
});
