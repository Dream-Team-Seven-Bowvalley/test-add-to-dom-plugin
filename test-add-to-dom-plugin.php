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

// Check if WooCommerce is active
function test_add_to_dom_plugin()
{
    $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

    if (
        in_array($plugin_path, wp_get_active_and_valid_plugins())
        || in_array($plugin_path, wp_get_active_network_plugins())
    ) {
        // WooCommerce is active.
    }
}

// Add circle buttons
function add_circle_buttons()
{
    global $product;

    // Check if we're on a product page
    if (is_product()) {
        ?>
        <div class="circle-buttons">
            <h2>Choose a color:</h2>
            <div class="circle-buttons-container">
                <button class="circle-button1 green-button" id="green-border-button"> </button>
                <button class="circle-button1 red-button" id="red-border-button"> </button>
                <button class="circle-button1 blue-button" id="blue-border-button"> </button>
            </div>
            <h4>Choose a texture:</h4>
        </div>
        <?php
    }
}
// Add a custom button above the "Add to Cart" button
// Add a custom button above the "Add to Cart" button
function add_custom_button_above_add_to_cart()
{
    if (is_product()) {
        ?>
        <button 
            type="button" 
            class="single_add_to_cart_button button alt wp-element-button custom-action-button" 
            id="custom-action-button"
        >
            View In your Space
        </button>
        <br>
        <br>
        <?php
    }
}



// Enqueue circle button CSS
function enqueue_circle_button_css()
{
    wp_enqueue_style('circle-button-css', plugins_url('circle-button.css', __FILE__));
}

// Enqueue circle button JS
function enqueue_circle_button_js()
{
    wp_enqueue_script('add-shadow-js', plugins_url('add-shadow.js', __FILE__), array('jquery'));
}

// Add a default green shadow to the product image
function add_green_shadow_to_product_image()
{
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
add_action('woocommerce_before_add_to_cart_button', 'add_custom_button_above_add_to_cart');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_css');
add_action('wp_enqueue_scripts', 'enqueue_circle_button_js');

// Uncomment to add green shadow by default
// add_action('woocommerce_before_single_product_summary', 'add_green_shadow_to_product_image');
