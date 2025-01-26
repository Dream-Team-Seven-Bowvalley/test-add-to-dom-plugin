$(document).ready(function() {
    $('.polymuse-model-link').on('click', function(event) {
        event.preventDefault();

        // Get the model URL from the data attribute
        var modelUrl = $(this).find('img').attr('data-model-url');

        // Create the model viewer div
        var modelViewer = $('<div>').html('<model-viewer src="' + modelUrl + '" alt="3D model" auto-rotate camera-controls ar style="width: 100%; height: 100%;"></model-viewer>');

        // Add the model viewer to the page
        $('body').append(modelViewer);
    });
});