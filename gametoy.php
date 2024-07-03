<?php
/*
Plugin Name: GameToy
Description: A plugin to display API results in the admin dashboard.
Version: 1.0
Author: Your Name
Text Domain: gametoy
*/

// Add menu item to admin dashboard
include plugin_dir_path(__FILE__) . 'includes/admin-menu.php';

// Enqueue scripts and styles
include plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';

// Include the API function
include plugin_dir_path(__FILE__) . 'includes/class-gametoy-api.php';

// Include log function
include plugin_dir_path(__FILE__) . 'includes/log.php';

// Include WooCommerce hooks
include plugin_dir_path(__FILE__) . 'includes/woocommerce-hooks.php';

// Include submit order function
include plugin_dir_path(__FILE__) . 'includes/class-gametoy-submitorder.php';
?>