<?php
/*
Plugin Name: GameToy
Description: A plugin to display API results in the admin dashboard.
Version: 1.0
Author: Your Name
*/

// Add menu item to admin dashboard
add_action('admin_menu', 'gametoy_add_admin_menu');

function gametoy_add_admin_menu() {
    add_menu_page(
        'GameToy Settings', // Page title
        'GameToy', // Menu title
        'manage_options', // Capability
        'gametoy', // Menu slug
        'gametoy_settings_page' // Function to display the page
    );
}

function gametoy_settings_page() {
    ?>
    <div class="wrap">
        <h1>GameToy Settings</h1>
        <form method="post" action="">
            <input type="hidden" name="gametoy_action" value="fetch_api_data">
            <input type="submit" value="Fetch API Data" class="button button-primary">
        </form>
        <?php
        if (isset($_POST['gametoy_action']) && $_POST['gametoy_action'] == 'fetch_api_data') {
            $response = getGoodsList(1, 8);
            echo '<h2>API Response</h2>';
            echo '<pre>' . print_r($response, true) . '</pre>';
        }
        ?>
    </div>
    <?php
}

// Include the API function
include plugin_dir_path(__FILE__) . 'includes/class-gametoy-api.php';
?>