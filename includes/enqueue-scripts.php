<?php

function gametoy_enqueue_scripts() {
    wp_enqueue_style('gametoy-style', plugin_dir_url(__FILE__) . '../assets/css/style.css');
    wp_enqueue_script('gametoy-script', plugin_dir_url(__FILE__) . '../assets/js/script.js', [], false, true);
}
add_action('admin_enqueue_scripts', 'gametoy_enqueue_scripts');
?>