<?php

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

    add_submenu_page(
        'gametoy', // Parent slug
        __('Logs', 'gametoy'), // Page title
        __('Logs', 'gametoy'), // Menu title
        'manage_options', // Capability
        'gametoy_logs', // Menu slug
        'gametoy_logs_page' // Function to display the page
    );

    add_submenu_page(
        'gametoy', // Parent slug
        __('Account Logs', 'gametoy'), // Page title
        __('Account Logs', 'gametoy'), // Menu title
        'manage_options', // Capability
        'gametoy_account_logs', // Menu slug
        'gametoy_account_logs_page' // Function to display the page
    );
}

// Include settings page
include plugin_dir_path(__FILE__) . 'settings-page.php';

// Include logs page
include plugin_dir_path(__FILE__) . 'logs-page.php';

// Include account logs page
include plugin_dir_path(__FILE__) . 'account-logs-page.php';
?>