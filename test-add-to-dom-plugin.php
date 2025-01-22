<?php
/*
 * Plugin Name:     Test Add to Dom Plugin
 * Plugin URI:      https://github.com/DreamTeamSeven/test-add-to-dom-plugin
 * Description:     A plugin to test adding to the DOM
 * Version:         0.0.1
 * Requires at least: 6.7.1
 * Requires PHP:    8.3
 * Author:          Dream Team Seven
 * Author URI:      https://github.com/DreamTeamSeven
 * License:         No License
 * License URI:     https://choosealicense.com/no-permission
 * Update URI:      https://github.com/DreamTeamSeven/test-add-to-dom-plugin
 * Text Domain:     test-add-to-dom-plugin
 * Requires Plugins: WooCommerce
 */

function test_add_to_dom_plugin() {
    if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        add_action( 'admin_notices', 'test_add_to_dom_plugin_notice' );
        return;
    }
}

function test_add_to_dom_plugin_notice() {
    ?>
    <div class="notice notice-warning is-dismissible">
        <p><?php _e( 'Test Add to Dom Plugin requires WooCommerce to be installed and activated.', 'test-add-to-dom-plugin' ); ?></p>
    </div>
    <?php
}

function my_custom_header_element() {
    echo '<p style="background-color: #f0f0f0; padding: 10px;">This is my custom header element!</p>';
}

function add_circle_buttons() {
    if ( is_product() ) {
        ?>
        <div class="circle-buttons">
            <button class="circle-button green-button" id="green-border-button">Button 1</button>
            <button class="circle-button red-button" id="red-border-button">Button 2</button>
        </div>
        <?php
    }
}

function enqueue_scripts() {
    wp_enqueue_style( 'circle-button-css', plugins_url( 'circle-button.css', __FILE__ ) );
    wp_enqueue_script( 'circle-button-js', plugins_url( 'circle-button.js', __FILE__ ), array( 'jquery' ), '1.0', true ); // Added jQuery dependency
}

test_add_to_dom_plugin();

add_action( 'wp_body_open', 'my_custom_header_element' );
add_action( 'woocommerce_before_add_to_cart_button', 'add_circle_buttons' );
add_action( 'wp_enqueue_scripts', 'enqueue_scripts' );

?>