<?php

function gametoy_logs_page() {
    $log_file = WP_CONTENT_DIR . '/plugins/gametoy/logs/debug.log';

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
        <h1><?php _e('GameToy Logs', 'gametoy'); ?></h1>
        <form method="post" action="">
            <textarea name="log_content" style="width: 100%; height: 500px;"><?php echo esc_textarea($logs); ?></textarea>
            <p>
                <input type="submit" name="save_logs" class="button button-primary" value="<?php _e('Save Logs', 'gametoy'); ?>">
            </p>
        </form>
    </div>
    <?php
}
?>