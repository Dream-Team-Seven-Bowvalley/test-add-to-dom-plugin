jQuery(document).ready(function ($) {
    console.log("jQuery is loaded and script is running.");

    // Event delegation to handle dynamically added buttons
    $(document).on('click', '.circle-button', function () {
        var color = $(this).attr('data-color'); // Get color from button

        if (!color) {
            console.warn("No data-color attribute found on this button.");
            return;
        }

        var capitalColor = capitalizeFirstLetter(color); // Capitalize first letter

        // ✅ Console logs to check if event is triggered
        console.log('✅ Button Clicked - Color:', capitalColor);

        // Set the selected value in the dropdown
        $('#color').val(capitalColor).change();

        // Log the currently selected color from the dropdown
        var selectedColor = $('#color').find(':selected').text();
        console.log('🎨 Dropdown Selected Color:', selectedColor);
    });

    // Function to capitalize the first letter of a string
    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Debugging: Check if buttons exist on page load
    if ($('.circle-button').length > 0) {
        console.log("✅ Found", $('.circle-button').length, "color buttons on page load.");
    } else {
        console.warn("⚠️ No .circle-button elements found on page load.");
    }
});
