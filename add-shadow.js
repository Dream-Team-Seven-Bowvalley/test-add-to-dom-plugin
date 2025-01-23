document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('.circle-button.green-button');
    if (button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            // Add your custom button click logic here
        });
    }
});