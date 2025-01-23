document.addEventListener('DOMContentLoaded', function() {
    const button = document.querySelector('.circle-button.green-button');
    const productImage = document.querySelector('.woocommerce div.product div.images img');

    if (button && productImage) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            productImage.style.boxShadow = '0 0 10px 5px green';
        });
    }
});