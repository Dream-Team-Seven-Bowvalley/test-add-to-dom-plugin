jQuery(document).ready(function ($) {
    function adjustModelViewerHeight() {
        $('.polymuse-model-viewer').height(500);
    }

    adjustModelViewerHeight();
    $(window).resize(adjustModelViewerHeight);

    setupModelViewerVariants();

    // For variable product page
    changeVariantInputToLabel();

    addVariantButtonOnClick();


    // if model viewer is found, create variant buttons
    function setupModelViewerVariants() {
        // Get the model viewer element
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
                // Create variant selection dropdown
                // const select = document.createElement('select');
                // select.id = 'variant-select';
                // if (variants && variants.length > 0) {
                //     variants.forEach(name => {
                //         const option = document.createElement('option');
                //         option.value = name;
                //         option.textContent = name;
                //         select.appendChild(option);
                //     });
                //     // Add default option
                //     const defaultOption = document.createElement('option');
                //     defaultOption.value = 'default';
                //     defaultOption.textContent = 'Default';
                //     select.appendChild(defaultOption);
                    
                //     // Add change listener
                //     select.addEventListener('input', (event) => {
                //         modelViewer.variantName = event.target.value === 'default' ? null : event.target.value;
                //     });
                    
                //     // Add select to document
                //     modelViewer.parentNode.insertBefore(select, modelViewer);
                // }
                // Create buttons for each variant
                const variantButtonsContainer = $('#variant-options-container')[0];
                if (variantButtonsContainer) {
                    if (variants && variants.length > 0) {
                        variants.forEach(variant => {
                            const button = $('<button class="variant-selector-button alt wp-element-button"></button>')[0];
                            button.textContent = variant;
                            button.addEventListener('click', () => {
                                modelViewer.variantName = variant;
                            });
                            variantButtonsContainer.appendChild(button);
                        });
                    } else {
                        variantButtonsContainer.textContent = 'No variants available';
                    }
                }
            });

        } else {

            console.log('Model Viewer element not found.');
        }
    }

    // Change variant input to label
    function changeVariantInputToLabel() {
        const variantSelect = $('#variant');
        variantSelect.hide();

        const variantLabel = $('<label id="variantLabel" style="margin-right: 5px;">Choose an option</label>')[0];
        variantSelect.after(variantLabel);
    }

    // Update variant label and hidden select
    function updateVariantLabel(variant) {
        const variantLabel = $('#variantLabel')[0];
        const variantSelect = $('#variant');
        console.log('Update variant:', variant);
        console.log('Variant label:', variantLabel);
        console.log('Variant select:', variantSelect);
        console.log('Variant select value:', variantSelect.val());

        variantLabel.textContent = variant;
        variantSelect.val(variant).trigger('change');
    }

    // Add on click event to variant buttons
    function addVariantButtonOnClick() {
        const variantButtonsContainer = $('#variant-options-container')[0];
        console.log('variantButtonsContainer:', variantButtonsContainer);
        if (variantButtonsContainer) {
            $(variantButtonsContainer).on('click', 'button', function () {
                const variant = $(this).text();
                console.log('Variant clicked:', variant);
                updateVariantLabel(variant);
            });
        } else {
            variantButtonsContainer.textContent = 'No variants available';
        }      
    }
});



