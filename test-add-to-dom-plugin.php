<?php
/*
 * Plugin Name:       3D Model Viewer
 * Plugin URI:        https://github.com/DreamTeamSeven/3d-model-viewer
 * Description:       A plugin to display 3D models on WooCommerce product pages
 * Version:           1.0.0
 * Requires at least: 6.7.1
 * Requires PHP:      8.3
 * Author:            Dream Team Seven
 * Author URI:        https://github.com/DreamTeamSeven
 * License:           No License
 * License URI:       https://choosealicense.com/no-permission
 * Update URI:        https://github.com/DreamTeamSeven/3d-model-viewer
 * Text Domain:       3d-model-viewer
 * Requires Plugins:  WooCommerce
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Check if WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

    // Add custom field to product editor
    function add_3d_model_url_field() {
        woocommerce_wp_text_input(
            array(
                'id' => '_3d_model_url',
                'label' => '3D Model URL',
                'description' => 'Enter the URL of the 3D model file (e.g., .glb or .gltf)',
                'desc_tip' => true,
            )
        );
    }
    add_action('woocommerce_product_options_general_product_data', 'add_3d_model_url_field');

    // Save custom field data
    function save_3d_model_url_field($post_id) {
        $model_url = $_POST['_3d_model_url'];
        if (!empty($model_url)) {
            update_post_meta($post_id, '_3d_model_url', esc_url($model_url));
        }
    }
    add_action('woocommerce_process_product_meta', 'save_3d_model_url_field');

    // Add 3D model to product gallery
    function add_3d_model_to_gallery($html, $attachment_id) {
        global $product;

        $model_url = get_post_meta($product->get_id(), '_3d_model_url', true);

        if (!empty($model_url)) {
            // Create thumbnail URL for the 3D model
            $model_thumbnail_url = plugins_url('3d-model-thumbnail.png', __FILE__);

            // Check if this is the first image in the gallery
            static $first_image = true;

            if ($first_image) {
                // Modify the thumbnail HTML to include the 3D model thumbnail
                $model_thumbnail = '<li><img src="' . esc_url($model_thumbnail_url) . '" alt="3D Model Thumbnail" class="model-thumbnail" data-gallery-item="3d-model" /></li>';

                // Prepend the 3D model thumbnail
                $html = $model_thumbnail . $html;

                // Create the model viewer div
                $model_viewer = '<div class="woocommerce-product-gallery__image polymuse-model-viewer" data-gallery-item="3d-model">';
                $model_viewer .= '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls style="width: 100%; height: 100%;"></model-viewer>';
                $model_viewer .= '</div>';

                $first_image = false;

                return $model_viewer . $html;
            }
        }

        return $html;
    }

    add_filter('woocommerce_single_product_image_thumbnail_html', 'add_3d_model_to_gallery', 10, 2);

    // Enqueue styles and scripts
    function enqueue_assets() {
        wp_enqueue_style('3d-model-viewer-styles', plugins_url('styles.css', __FILE__));
        wp_enqueue_script('3d-model-viewer-script', plugins_url('script.js', __FILE__), array('jquery'), '1.0', true);
    }
    add_action('wp_enqueue_scripts', 'enqueue_assets');

    // Add model-viewer script to header
    function add_model_viewer_script() {
        echo '<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>';
    }
    add_action('wp_head', 'add_model_viewer_script');
}