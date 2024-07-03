<?php

function gametoy_settings_page() {
    ?>
    <div class="wrap gametoy-bootstrap">
        <h1><?php _e('GameToy Settings', 'gametoy'); ?></h1>
        <?php include plugin_dir_path(__FILE__) . 'form.php'; ?>
        <div class="api-response">
            <?php
            if (isset($_POST['gametoy_action'])) {
                $pageNum = intval($_POST['pageNum']);
                $pageSize = intval($_POST['pageSize']);
                if ($_POST['gametoy_action'] == 'fetch_api_data') {
                    $response = getGoodsList($pageNum, $pageSize);
                    include plugin_dir_path(__FILE__) . 'display-api-response.php';
                    if (!isset($response['data']) || empty($response['data'])) {
                        echo '<p>' . __('No data available', 'gametoy') . '</p>';
                        write_log('No data available for fetch_api_data action.'); // Log message
                    }
                } elseif ($_POST['gametoy_action'] == 'import_data') {
                    $response = getGoodsList($pageNum, $pageSize);
                    if (!isset($response['data']) || empty($response['data'])) {
                        echo '<p>' . __('No data available', 'gametoy') . '</p>';
                        write_log('No data available for import_data action.'); // Log message
                    } else {
                        echo '<p>' . __('Products have been added to WooCommerce.', 'gametoy') . '</p>';
                        write_log('Products have been added to WooCommerce.'); // Log message
                    }
                }
            }
            ?>
        </div>
    </div>
    <?php
}
?>