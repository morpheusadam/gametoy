<?php
/*
Plugin Name: GameToy
Description: A plugin to display API results in the admin dashboard.
Version: 1.0
Author: Your Name
Text Domain: gametoy
*/

// Add menu item to admin dashboard
add_action('admin_menu', 'gametoy_add_admin_menu');

function gametoy_add_admin_menu() {
    add_menu_page(
        __('GameToy Settings', 'gametoy'), // Page title
        __('GameToy', 'gametoy'), // Menu title
        'manage_options', // Capability
        'gametoy', // Menu slug
        'gametoy_settings_page', // Function to display the page
        '', // Icon URL
        6 // Position
    );
}

function gametoy_settings_page() {
    ?>
    <div class="wrap gametoy-bootstrap">
        <h1><?php _e('GameToy Settings', 'gametoy'); ?></h1>
        <?php include plugin_dir_path(__FILE__) . 'includes/form.php'; ?>
        <div class="api-response">
            <?php
            if (isset($_POST['gametoy_action'])) {
                $pageNum = intval($_POST['pageNum']);
                $pageSize = intval($_POST['pageSize']);
                if ($_POST['gametoy_action'] == 'fetch_api_data') {
                    $response = getGoodsList($pageNum, $pageSize);
                    include plugin_dir_path(__FILE__) . 'includes/display-api-response.php';
                    if (!isset($response['data']) || empty($response['data'])) {
                        echo '<p>' . __('No data available', 'gametoy') . '</p>';
                    }
                } elseif ($_POST['gametoy_action'] == 'import_data') {
                    $response = getGoodsList($pageNum, $pageSize);
                    if (!isset($response['data']) || empty($response['data'])) {
                        echo '<p>' . __('No data available', 'gametoy') . '</p>';
                    } else {
                        echo '<p>' . __('Products have been added to WooCommerce.', 'gametoy') . '</p>';
                    }
                }
            }
            ?>
        </div>
    </div>
    <?php
}

function gametoy_enqueue_scripts() {
    wp_enqueue_style('gametoy-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('gametoy-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', [], false, true);
}
add_action('admin_enqueue_scripts', 'gametoy_enqueue_scripts');

// Include the API function
include plugin_dir_path(__FILE__) . 'includes/class-gametoy-api.php';
?>