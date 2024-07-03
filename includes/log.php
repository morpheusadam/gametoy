<?php

function write_log($message) {
    // Define the log file path
    $log_file = WP_CONTENT_DIR . '/plugins/gametoy/logs/debug.log';

    // Ensure the log directory exists
    if (!file_exists(dirname($log_file))) {
        wp_mkdir_p(dirname($log_file));
    }

    // Get the current timestamp
    $timestamp = current_time('Y-m-d H:i:s');

    // Format the log message
    $formatted_message = "[{$timestamp}] {$message}\n";

    // Write the log message to the file
    if (file_put_contents($log_file, $formatted_message, FILE_APPEND) === false) {
        error_log("Failed to write to log file: {$log_file}");
    }
}

