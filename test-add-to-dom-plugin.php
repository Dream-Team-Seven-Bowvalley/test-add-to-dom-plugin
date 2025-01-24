<?php
/*
 * Plugin Name:       Test Add to Dom Plugin
 * Plugin URI:        https://github.com/DreamTeamSeven/test-add-to-dom-plugin
 * Description:       A plugin to test adding to the DOM
 * Version:           0.0.0
 * Requires at least: 6.7.1
 * Requires PHP:      8.3
 * Author:            Dream Team Seven
 * Author URI:        https://github.com/DreamTeamSeven
 * License:           No License
 * License URI:       https://choosealicense.com/no-permission
 * Update URI:        https://github.com/DreamTeamSeven/test-add-to-dom-plugin
 * Text Domain:       test-add-to-dom-plugin
 * Requires Plugins:  WooCommerce
 */

function test_add_to_dom_plugin()
{
    // Test to see if WooCommerce is active (including network activated).
    $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

    if (
        in_array($plugin_path, wp_get_active_and_valid_plugins())
        || in_array($plugin_path, wp_get_active_network_plugins())
    ) {
        // Custom code here. WooCommerce is active, however it has not 
        // necessarily initialized (when that is important, consider
        // using the `woocommerce_init` action).
    }
}
function my_custom_header_element()
{
    // Your custom header element code here
    echo '<p style="background-color: #f0f0f0; padding: 10px;">This is my custom header element!</p>';
}

// Hook to add circle buttons
function add_circle_buttons()
{
    global $product;

    // Check if we're on a product page
    if (is_product()) {
        ?>
        <div class="circle-buttons">
            <h2>Choose a color:</h2>
            <div class="circle-buttons-container">
                <button class="circle-button green-button" id="green-border-button"> </button>
                <button class="circle-button red-button" id="red-border-button"> </button>
                <button class="circle-button blue-button" id="blue-border-button"> </button>
            </div>
        </div>
        <?php
    }
}

// Add 3D image place holder
function add_image_to_gallery_and_thumbnail()
{
    global $product;

    // Ensure we are on a product page
    if (is_product()) {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const galleryWrapper = document.querySelector('.woocommerce-product-gallery__wrapper');
                const thumbnailWrapper = document.querySelector('.woocommerce-product-gallery');

                if (galleryWrapper && thumbnailWrapper) {
                    // Add a new image to the gallery
                    const newImage = document.createElement('div');
                    newImage.classList.add('woocommerce-product-gallery__image');
                    newImage.innerHTML = `
                        <a href="https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp">
                            <img 
                                src="https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp" 
                                alt="New Image" 
                                class="wp-post-image" />
                        </a>
                    `;
                    galleryWrapper.appendChild(newImage);

                    // Add a new thumbnail
                    const newThumbnail = document.createElement('div');
                    newThumbnail.classList.add('woocommerce-product-gallery__image');
                    newThumbnail.setAttribute('data-thumb', 'https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp');
                    newThumbnail.innerHTML = `
                        <a href="https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp">
                            <img 
                                src="https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp" 
                                alt="New Thumbnail" 
                                class="wp-post-image" />
                        </a>
                    `;
                    thumbnailWrapper.appendChild(newThumbnail);

                    // Add click event for thumbnail to update the main image
                    newThumbnail.addEventListener('click', function (event) {
                        event.preventDefault();
                        const mainImage = document.querySelector('.woocommerce-product-gallery__image a img');
                        if (mainImage) {
                            mainImage.src = 'https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp';
                            mainImage.closest('a').href = 'https://yiteg94znhby2sle.public.blob.vercel-storage.com/chair1-cX37DzmkP4D6JaurEeJj9d1OL2uxTR.webp';
                        }
                    });
                }
            });
        </script>
        <?php
    }
}




// Hook to enqueue circle button CSS
function enqueue_circle_button_css()
{
    wp_enqueue_style('circle-button-css', plugins_url('circle-button.css', __FILE__));
}
// Hook to enqueue circle button JS
function enqueue_circle_button_js()
{
    wp_enqueue_script('add-shadow-js', plugins_url('add-shadow.js', __FILE__), array('jquery'));
}


function add_green_Shadow_to_product_image()
{
    global $product;

    // Check if we're on a product page
    if (is_product()) {
        ?>
        <style>
            .woocommerce div.product div.images img {
                box-shadow: 0 0 10px 5px green !important;
            }
        </style>
        <?php
    }
}


test_add_to_dom_plugin();

// Add actions
add_action('woocommerce_before_add_to_cart_button', 'add_circle_buttons');
add_action('woocommerce_before_single_product_summary', 'add_image_to_gallery_and_thumbnail');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_css');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_js');


// add_action('woocommerce_before_single_product_summary', 'add_green_Shadow_to_product_image');