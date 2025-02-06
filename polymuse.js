jQuery(document).ready(function($) {
    const modelViewer = $('model-viewer')[0];
    const variantButtonsContainer = $('#variant-buttons')[0];
  
    $(modelViewer).on('load', function() {
      const model = modelViewer.model;
      console.log(model);
  
      const materials = modelViewer.model.materials;
      console.log(materials);
  
      // Check for available variants
      const variants = modelViewer.availableVariants;
      console.log('Available variants:', variants);
  
      // Get material info for each variant
      const variantInfo = {};
      if (variants) {
        variants.forEach(variant => {
          modelViewer.variantName = variant;
          const material = modelViewer.model.materials[0]; // Assuming first material
          if (material && material.pbrMetallicRoughness && material.pbrMetallicRoughness.baseColorFactor) {
            variantInfo[variant] = material.pbrMetallicRoughness.baseColorFactor;
          }
        });
        // Reset to first variant
        modelViewer.variantName = variants[0];
      }
  
      // Create buttons for each variant
      if (variants && variants.length > 0) {
        variants.forEach(variant => {
          const button = $('<button>');
          button.text(variant);
          button.on('click', function() {
            modelViewer.variantName = variant;
          });
          $(variantButtonsContainer).append(button);
        });
      } else {
        $(variantButtonsContainer).text('No variants available');
      }
    });
  });