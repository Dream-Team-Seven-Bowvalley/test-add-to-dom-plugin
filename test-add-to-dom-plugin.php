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
function add_placeholder_to_product_gallery()
{
    if (is_product()) {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Add placeholder image to thumbnails
                const placeholderImage = `
                    <div class="woocommerce-product-gallery__image">
                        <a href="https://example.com/placeholder-image.webp">
                            <img src="https://example.com/placeholder-image.webp" 
                                 alt="Placeholder Image" 
                                 class="placeholder-thumbnail" 
                                 width="100" height="100">
                        </a>
                    </div>`;
                
                const galleryWrapper = document.querySelector('.woocommerce-product-gallery__wrapper');
                if (galleryWrapper) {
                    galleryWrapper.insertAdjacentHTML('beforeend', placeholderImage);
                }

                // Add click functionality to show placeholder as main image
                const mainImage = document.querySelector('.woocommerce-product-gallery__image img');
                const thumbnails = document.querySelectorAll('.woocommerce-product-gallery__image img');

                thumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', function (e) {
                        e.preventDefault();
                        const newSrc = this.src;
                        const newLargeImage = this.closest('a').href;
                        mainImage.src = newSrc;
                        mainImage.closest('a').href = newLargeImage;
                    });
                });
            });
        </script>
        <?php
    }
}

// Hook to add image placeholder
function enqueue_placeholder_styles()
{
    wp_enqueue_style(
        'placeholder-styles',
        plugins_url('placeholder-styles.css', __FILE__)
    );
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
add_action('woocommerce_after_single_product_summary', 'add_placeholder_to_product_gallery', 20);
// add_action('wp_enqueue_scripts', 'enqueue_placeholder_styles');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_css');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_js');


// add_action('woocommerce_before_single_product_summary', 'add_green_Shadow_to_product_image');