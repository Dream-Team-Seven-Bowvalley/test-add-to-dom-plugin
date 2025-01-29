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

// Add buttons
function add_buttons()
{
    global $product;

    if (is_product()) {

        ?>
        <div>
            <h3>Choose a color:</h3>
            <div>
                <button class="circle-button green-button" id="green-border-button" data-color="green"></button>
                <button class="circle-button red-button" id="red-border-button" data-color="red"></button>
                <button class="blue-button circle-button" id="blue-border-button" data-color="blue"></button>

            </div>
            <h3>Choose a texture:</h3>
            <div class="circle-buttons-container">
                <button class="circle-button wood-button" id="wood-border-button"></button>
                <button class="circle-button metal-button" id="metal-border-button"></button>
                <button class="circle-button plastic-button" id="plastic-border-button"></button>
            </div>
            <br />
        </div>
        <?php

    }
}

// Add custom field to product editor
function polymuse_custom_field()
{
    woocommerce_wp_text_input(
        array(
            'id' => '_3d_model_url',
            'label' => '3D Model URL',
            'description' => 'Enter the URL of the 3D model file (e.g., .glb or .gltf)',
            'desc_tip' => true,
        )
    );
}

// Save custom field data
function polymuse_save_custom_field($post_id)
{
    $model_url = $_POST['_3d_model_url'];
    if (!empty($model_url)) {
        update_post_meta($post_id, '_3d_model_url', esc_url($model_url));
    }
}


// Add 3D model and thumbnail to gallery
function polymuse_add_model_and_thumbnail_to_gallery($html, $attachment_id)
{
    global $product;

    // Debug logging
    error_log('polymuse_add_model_and_thumbnail_to_gallery called');
    error_log('Attachment ID: ' . $attachment_id);
    error_log('HTML received: ' . $html);

    if (!$product) {
        error_log('No product found');
        return $html;
    }

    $model_url = get_post_meta($product->get_id(), '_3d_model_url', true);
    error_log('Model URL: ' . $model_url);

    if (!empty($model_url)) {
        // Create thumbnail URL for the 3D model
        $model_thumbnail_url = plugins_url('3d-model-thumbnail.png', __FILE__);
        error_log('Model Thumbnail URL: ' . $model_thumbnail_url);

        // Check if this is the first image in the gallery
        static $first_image = true;

        if ($first_image) {
            $first_image = false;
            // Create the model viewer div
            $model_viewer = '<div data-thumb="' . esc_url($model_thumbnail_url) . '" ';
            $model_viewer .= 'data-thumb-alt="3D Model" ';
            $model_viewer .= 'data-thumb-srcset="' . esc_url($model_thumbnail_url) . ' 100w" ';
            $model_viewer .= 'data-thumb-sizes="(max-width: 100px) 100vw, 100px" ';
            $model_viewer .= 'class="woocommerce-product-gallery__image polymuse-model-viewer">';
            $model_viewer .= '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls ar style="width: 100%; height: 100%;"></model-viewer>';
            $model_viewer .= '</div>';

            error_log('Modified HTML: ' . $html);
            return $model_viewer . $html;
        }
    }

    return $html;
}




function polymuse_enqueue_assets()
{
    wp_enqueue_style('polymuse-styles', plugins_url('/styles.css', __FILE__));
    wp_enqueue_script('polymuse-script', plugins_url('polymuse.js', __FILE__), array('jquery'), '1.0', true);
}


function polymuse_add_model_viewer_script()
{
    echo '<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>';
}

// Add hidden input field for product color variation
function add_hidden_input_field_color_variation($form_html) {
    ?>
    <input type="hidden" id="product_color_variation" name="product_color_variation" value="">
    <?php
  }

// Update product variation based on the selected color
function update_product_variation($cart_item_data, $product_id)
{
    if (isset($_POST['product_color_variation'])) {
        $variation_id = $_POST['product_color_variation'];
        $cart_item_data['color_variation_id'] = $variation_id;
    }
    return $cart_item_data;
}
// Display variation data in the cart
function display_variation_data($item_name, $cart_item, $cart_item_key)
{
    if (isset($cart_item['color_variation_id'])) {
        $product = wc_get_product($cart_item['color_variation_id']);
        $item_name .= ' - ' . $product->get_attribute('color');
    }
    return $item_name;
}

// Add variation data to order item meta
function add_variation_data_to_order_item_meta($item_id, $values, $cart_item_key)
{
    if (isset($values['variation_id'])) {
        $product = wc_get_product($values['variation_id']);
        wc_add_order_item_meta($item_id, 'Color', $product->get_attribute('color'));
    }
}
// Display variation data in the order email
function display_variation_data_in_email($item_meta, $item)
{
    if (isset($item_meta['Color'])) {
        $item_meta .= '<br>Color: ' . $item_meta['Color'];
    }
    return $item_meta;
}

function test_add_to_dom_plugin()
{
    $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

    if (
        in_array($plugin_path, wp_get_active_and_valid_plugins())
        || in_array($plugin_path, wp_get_active_network_plugins())
    ) {
        add_action('woocommerce_before_add_to_cart_form', 'add_buttons');

        add_action('woocommerce_product_options_general_product_data', 'polymuse_custom_field');
        add_action('woocommerce_process_product_meta', 'polymuse_save_custom_field');
        add_filter('woocommerce_single_product_image_thumbnail_html', 'polymuse_add_model_and_thumbnail_to_gallery', 10, 2);
        add_action('wp_head', 'polymuse_add_model_viewer_script');
        add_action('wp_enqueue_scripts', 'polymuse_enqueue_assets');
        add_action('woocommerce_before_add_to_cart_button', 'add_hidden_input_field_color_variation');
        add_filter('woocommerce_add_cart_item_data', 'update_product_variation', 10, 2);
        add_filter('woocommerce_cart_item_name', 'display_variation_data', 10, 3);
        add_action('woocommerce_add_order_item_meta', 'add_variation_data_to_order_item_meta', 10, 3);
        // add_filter('woocommerce_email_order_item_meta', 'display_variation_data_in_email', 10, 2);

    }
}

test_add_to_dom_plugin();





