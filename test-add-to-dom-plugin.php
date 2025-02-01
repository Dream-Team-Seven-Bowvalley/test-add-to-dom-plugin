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
        // Retrieve the JSON data from the product meta
        $variant_json_data = get_post_meta($product->get_id(), '_variant_json_data', true);      

        // Decode the JSON data
        $json_data = json_decode($variant_json_data, true);

        ?>
        <div>
            <?php foreach ($json_data as $variant_group) { ?>
                <h3><?php echo esc_html($variant_group['title']); ?>:</h3>
                <div>
                    <?php foreach ($variant_group['variants'] as $variant) { 
                        $variant_title = esc_attr($variant['title']);
                        $variant_value = isset($variant['value']) ? esc_attr($variant['value']) : null;
                        ?>

                        <?php if ($variant_value) { ?>
                            <!-- If color hex exists, use it for background -->
                            <button class="circle-button" 
                                    id="<?php echo $variant_title; ?>-button" 
                                    data-color="<?php echo $variant_value; ?>" 
                                    style="background-color: <?php echo $variant_value; ?>">
                            </button>
                        <?php } else { ?>
                            <!-- If no hex, use regular button -->
                            <button class="wp-element-button" 
                                    id="<?php echo $variant_title; ?>-button">
                                <?php echo $variant_title; ?>
                            </button>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <br />
        </div>
        <?php
    }
}


// Add Placeholder image to product to hide later to make selection stay on the model
// Set Product image as placeholder using local image
function set_default_placeholder_product_image_from_url($post_id)
{
    if (get_post_type($post_id) !== 'product') {
        return;
    }

    // URL to the placeholder image
    $placeholder_image_url = get_site_url() . '/wp-content/uploads/woocommerce-placeholder.png';

    // Get the attachment ID from the URL
    $attachment_id = attachment_url_to_postid($placeholder_image_url);

    // Check if the product already has an image
    if (!has_post_thumbnail($post_id) && $attachment_id) {
        // Set the placeholder image as the product thumbnail
        set_post_thumbnail($post_id, $attachment_id);
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

function polymuse_custom_field_variant_json_data()
{
    woocommerce_wp_text_input(
        array(
            'id' => '_variant_json_data',
            'label' => 'Variant JSON Data',
            'description' => 'Enter the JSON data for the variant product',
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

function polymuse_save_custom_field_variant_json_data($post_id)
{
    $variant_json_data = $_POST['_variant_json_data'];
    if (!empty($variant_json_data)) {
        // Sanitize the JSON data
        $sanitized_json_data = wp_kses_post($variant_json_data);
        // Save the sanitized JSON data
        update_post_meta($post_id, '_variant_json_data', $sanitized_json_data);
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
            $model_viewer .= 'class="woocommerce-product-gallery__image polymuse-model-viewer">';
            $model_viewer .= '<model-viewer src="' . esc_url($model_url) . '" alt="3D model of ' . esc_attr($product->get_name()) . '" auto-rotate camera-controls ar style="width: 100%; height: 100%;"></model-viewer>';
            $model_viewer .= '</div>';

            // Hide default this will make selecting variants work properly
            $html = '<style>.woocommerce-product-gallery__image--placeholder:first-child { display: none; }</style>';
            error_log('Modified HTML: ' . $html);
            return $model_viewer . $html;
        }
    }

    return $html;
}

function polymuse_enqueue_assets()
{
    // wp_enqueue_script('jquery');
    wp_enqueue_style('polymuse-styles', plugins_url('/styles.css', __FILE__));
    wp_enqueue_script('polymuse-script', plugins_url('/polymuse.js', __FILE__), array('jquery'), '1.0', true);
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
        // The plugin works correctly when there is a default that is hidden(allowing the 3d model to takes its place)
        add_action('save_post', 'set_default_placeholder_product_image_from_url', 10, 1);


        // Add 3D model URL and Json data field to product editor
        add_action('woocommerce_product_options_general_product_data', 'polymuse_custom_field_model_url');
        add_action('woocommerce_product_options_general_product_data', 'polymuse_custom_field_variant_json_data');

        // Save custom field data
        add_action('woocommerce_process_product_meta', 'polymuse_save_custom_field_model_url');
        add_action('woocommerce_process_product_meta', 'polymuse_save_custom_field_variant_json_data');

        // Add 3D model and thumbnail to gallery
        add_filter('woocommerce_single_product_image_thumbnail_html', 'polymuse_add_model_and_thumbnail_to_gallery', 10, 2);

        
        // Add variant style buttons to product page
        add_action('woocommerce_before_add_to_cart_form', 'add_buttons');

        // Enqueue assets
        add_action('wp_head', 'polymuse_add_model_viewer_script');
        add_action('wp_enqueue_scripts', 'polymuse_enqueue_assets');       
      

    }
}

test_add_to_dom_plugin();







