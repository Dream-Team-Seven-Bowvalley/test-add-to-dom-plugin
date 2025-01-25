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

//Add 20px b4 the buttons

function add_20_px_before_buttons()
{
    echo '<div style="height: 20px;"></div>';
}
// Add buttons
function add_buttons()
{
    global $product;

    if (is_product()) {
        //Add 20px b4 the buttons
        add_action('woocommerce_before_add_to_cart_button', 'add_20_px_before_buttons');
        ?>
        <div class="added-content">
            <div class="buttons">
                <h3>Choose a color:</h3>
                <div class="circle-buttons-container">
                    <button class="circle-button green-button" id="green-border-button"></button>
                    <button class="circle-button red-button" id="red-border-button"></button>
                    <button class="circle-button blue-button" id="blue-border-button"></button>
                </div>
                <h3>Choose a texture:</h3>
                <div class="circle-buttons-container">
                    <button class="circle-button wood-button" id="wood-border-button"></button>
                    <button class="circle-button metal-button" id="metal-border-button"></button>
                    <button class="circle-button plastic-button" id="plastic-border-button"></button>
                </div>
                <br />
            </div>
            <?php // Close PHP tags before the if statement
                    if (wp_is_mobile()) {
                        ?>
                <button type="button" class="single_add_to_cart_button button alt wp-element-button view-in-space-button"
                    id="view-in-space-button">
                    View In your Space
                </button>
            <?php // Reopen PHP tags after the if statement's HTML
                    } ?>
        </div>
        <?php

    }
}

function add_3d_model_viewer()
{
    ?>
    <div >
        <h1> test</h1>
        <model-viewer src="https://modelviewer.dev/shared-assets/models/Astronaut.glb" alt="A 3D model of an astronaut"
            auto-rotate camera-controls ar width="300" height="300"></model-viewer>
    </div>
    <?php
}


// Enqueue buttons CSS
function enqueue_buttons_css()
{
    wp_enqueue_style('circle-button-css', plugins_url('buttons.css', __FILE__));
}

function enqueue_model_viewer_script()
{
    wp_enqueue_script('model-viewer', 'https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js', array(), '1.0', true);
}


// // Enqueue circle button JS
// function enqueue_buttons_js()
// {
//     wp_enqueue_script('add-shadow-js', plugins_url('add-shadow.js', __FILE__), array('jquery'));
// }
function test_add_to_dom_plugin()
{
    $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

    if (
        in_array($plugin_path, wp_get_active_and_valid_plugins())
        || in_array($plugin_path, wp_get_active_network_plugins())
    ) {
        // Add actions
        add_action('woocommerce_before_add_to_cart_form', 'add_buttons');
        add_action('wp_enqueue_scripts', 'enqueue_buttons_css');
        add_action('wp_enqueue_scripts', 'enqueue_model_viewer_script');
        // add_action('woocommerce_before_single_product_thumbnails', 'add_3d_model_viewer');
        add_action('woocommerce_before_single_product_summary', 'add_3d_model_viewer');
        // add_action('wp_enqueue_scripts', 'enqueue_buttons_js');
    }
}

test_add_to_dom_plugin();





