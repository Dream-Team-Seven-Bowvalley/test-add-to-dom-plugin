jQuery(document).ready(function ($) {
    // Update hidden input field when a color button is clicked
    $('.circle-button').on('click', function () {
      var color = $(this).attr('id');
      $('#product_color_variation').val(color);
    });
  
    // Ensure the 3D model slide is the same height as other slides
    function adjustModelViewerHeight() {
      var galleryHeight = $('.woocommerce-product-gallery__wrapper').height();
      $('.polymuse-model-viewer').height(500);
    }
  
    // Run on page load and when the window is resized
    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);
  });