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

// Display 3D model on product page
function polymuse_display()
{
    global $product;

    $model_url = get_post_meta($product->get_id(), '_3d_model_url', true);

    if (!empty($model_url)) {
        echo '<div id="polymuse-3d-viewer">';
        echo '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls ar></model-viewer>';
        echo '</div>';
    }
}

function polymuse_add_model_to_gallery($html, $attachment_id)
{
    global $product;

    // Debug logging
    error_log('polymuse_add_model_to_gallery called');
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
            // Modify the thumbnail HTML to include the 3D model thumbnail
            // $model_thumbnail = '<li><img src="' . $model_thumbnail_url . '" alt="3D Model Thumbnail" class="model-thumbnail" data-gallery-item="3d-model" /></li>';
            $model_thumbnail = '<li><div class="model-thumbnail" data-gallery-item="3d-model" style="background-image: url(' . $model_thumbnail_url . ');"></div></li>';
            error_log('Model Thumbnail HTML: ' . $model_thumbnail);
            // Prepend the 3D model thumbnail
            $html = $model_thumbnail . $html;

            // Create the model viewer div
            $model_viewer = '<div class="woocommerce-product-gallery__image polymuse-model-viewer" data-gallery-item="3d-model">';
            $model_viewer .= '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls ar style="width: 100%; height: 100%;"></model-viewer>';
            $model_viewer .= '</div>';

            $first_image = false;

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
        add_filter('woocommerce_single_product_image_thumbnail_html', 'polymuse_add_model_to_gallery', 10, 4);
        add_action('wp_head', 'polymuse_add_model_viewer_script');
        add_action('wp_enqueue_scripts', 'polymuse_enqueue_assets');       

    }
}

test_add_to_dom_plugin();





