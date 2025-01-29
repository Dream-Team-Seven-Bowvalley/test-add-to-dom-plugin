?>
    <script>
        console.log('DOM is ready');
        jQuery(function($) {
            // Find the select element for color and texture
            const $colorSelect = $("select[name='attribute_color']");

            // Handle color selection
            $(".circle-button").on("click", function () {
                const colorValue = $(this).data("color");
                // Get the color from the id of the clicked button
                const buttonId = $(this).attr('id');
                const color = buttonId.replace('-border-button', '');
                console.log('Color selected:', color);

                // Set the select value if it exists
                if ($colorSelect.length) {
                    // Capitalize first letter to match select options
                    const capitalizedColor = color.charAt(0).toUpperCase() + color.slice(1);
                    $colorSelect.val(capitalizedColor).trigger('change');
             
                }
            });

          
        });
    </script>
    <?php