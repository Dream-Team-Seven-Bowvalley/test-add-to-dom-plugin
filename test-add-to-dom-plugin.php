<?php
/*
 * Plugin Name:       Test Add to Dom Plugin
 * Plugin URI:        https://github.com/DreamTeamSeven/polymuse-woocommerce-plugin
 * Description:       A plug-in to test adding to the dom
 * Version:           0.0.0
 * Requires at least: 6.7.1
 * Requires PHP:      8.3
 * Author:            Dream Team Seven
 * Author URI:        https://github.com/DreamTeamSeven
 * License:           No License
 * License URI:       https://choosealicense.com/no-permission
 * Update URI:        https://github.com/DreamTeamSeven/polymuse-woocommerce-plugin
 * Text Domain:       polymuse-woocommerce-plugin
 * Requires Plugins:  woocommerce
 */

function test_add_to_dom_plugin()
{
    // Test to see if WooCommerce is active (including network activated).
    $plugin_path = trailingslashit( WP_PLUGIN_DIR ) . 'woocommerce/woocommerce.php';

    if (
        in_array( $plugin_path, wp_get_active_and_valid_plugins() )
        || in_array( $plugin_path, wp_get_active_network_plugins() )
    ) {
        // Custom code here. WooCommerce is active, however it has not 
        // necessarily initialized (when that is important, consider
        // using the `woocommerce_init` action).
    }
}

function my_custom_product_element() {
    // Your custom element code here
    echo '<p>This is my custom element!</p>';
}

test_add_to_dom_plugin();

add_action( 'woocommerce_single_product_summary', 'my_custom_product_element' );