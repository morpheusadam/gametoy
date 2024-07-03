<?php

if (!function_exists('gametoy_account_logs_page')) {
    function gametoy_account_logs_page() {
        $log_file = WP_CONTENT_DIR . '/plugins/gametoy/logs/account.log';

        // Ensure the log directory exists
        if (!file_exists(dirname($log_file))) {
            wp_mkdir_p(dirname($log_file));
        }

        // Ensure the log file exists
        if (!file_exists($log_file)) {
            file_put_contents($log_file, '');
            chmod($log_file, 0664); // Set appropriate permissions
        }

        if (isset($_POST['save_logs'])) {
            if (current_user_can('manage_options')) {
                file_put_contents($log_file, sanitize_textarea_field($_POST['log_content']));
                echo '<div class="updated"><p>' . __('Logs have been updated.', 'gametoy') . '</p></div>';
            } else {
                echo '<div class="error"><p>' . __('You do not have permission to edit logs.', 'gametoy') . '</p></div>';
            }
        }

        $logs = file_exists($log_file) ? file_get_contents($log_file) : __('Log file not found.', 'gametoy');
        ?>
        <div class="wrap">
            <h1><?php _e('GameToy Account Logs', 'gametoy'); ?></h1>
            <form method="post" action="">
                <textarea name="log_content" style="width: 100%; height: 500px;"><?php echo esc_textarea($logs); ?></textarea>
                <p>
                    <input type="submit" name="save_logs" class="button button-primary" value="<?php _e('Save Logs', 'gametoy'); ?>">
                </p>
            </form>
        </div>
        <?php
    }
}
?>