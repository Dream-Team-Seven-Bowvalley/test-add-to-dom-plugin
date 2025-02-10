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

// Notice for suboptimal theme
function theme_checker_admin_notice()
{
    // Define the themes to check for
    $themes_to_check = array('OceanWP', 'theme2', 'theme3');

    // Get the current theme
    $current_theme = wp_get_theme();

    // Check if the current theme is in the list of themes to check
    if (in_array($current_theme->get('Name'), $themes_to_check)) {
        // Display a message to the admin
        ?>
        <div class="is-dismissible notice notice-info">
            <p><?php _e('The theme you are using may looks suboptimal with this plugin.', 'theme-checker'); ?></p>
        </div>
        <?php
    }
}


// Add custom field to product editor
function polymuse_custom_field_model_url()
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
function polymuse_save_custom_field_model_url($post_id)
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
        $model_thumbnail_url = plugins_url('3d.webp', __FILE__);
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
            $model_viewer .= 'class="woocommerce-product-gallery__image polymuse-model-viewer" ">';
            $model_viewer .= '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls ar ar-modes="webxr scene-viewer quick-look" style="width: 100%; height: 100%;"></model-viewer>';
            $model_viewer .= '</div>';

            // Hide default this will make selecting variants work properly
            // with out this when you select a variant product  there will be a place holder image out of place
            // The down side is then the main product image will not show up in the carousel or thumb nail
            // A benefit is that when you select a variant the main image will not change and show the model viewer
            $html = '<style>.woocommerce-product-gallery__image--placeholder:first-child { display: none; }</style>';
            error_log('Modified HTML: ' . $html);
            return $model_viewer . $html;
        }
    }

    return $html;
}

// Add variant style buttons container to product page
function add_buttons_container()
{
    global $product;

    if (is_product()) {

        // Create a container div for variant options
        ?>
        <div id="variant-options-container"></div>
        <?php
    }
}
function polymuse_add_model_viewer_script()
{
    echo '<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>';
}

function polymuse_enqueue_assets()
{
    // wp_enqueue_script('jquery');
    wp_enqueue_style('polymuse-styles', plugins_url('/styles.css', __FILE__));
    wp_enqueue_script('polymuse-script', plugins_url('/polymuse.js', __FILE__), array('jquery'), '1.0', true);
}


function test_add_to_dom_plugin()
{
    $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';

    if (
        in_array($plugin_path, wp_get_active_and_valid_plugins())
        || in_array($plugin_path, wp_get_active_network_plugins())
    ) {

        // Notice for suboptimal themes
        add_action('admin_notices', 'theme_checker_admin_notice');
        // Add 3D model URL and Json data field to product editor
        add_action('woocommerce_product_options_general_product_data', 'polymuse_custom_field_model_url');

        // Save custom field data when entered
        add_action('woocommerce_process_product_meta', 'polymuse_save_custom_field_model_url');

        // Add 3D model and thumbnail to gallery
        add_filter('woocommerce_single_product_image_thumbnail_html', 'polymuse_add_model_and_thumbnail_to_gallery', 10, 2);

        // Add variant options buttons container to product page
        add_action('woocommerce_before_add_to_cart_form', 'add_buttons_container');

        // Enqueue assets
        add_action('wp_head', 'polymuse_add_model_viewer_script');
        add_action('wp_enqueue_scripts', 'polymuse_enqueue_assets');
    }
}

test_add_to_dom_plugin();







