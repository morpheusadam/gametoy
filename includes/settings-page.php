<?php

function gametoy_settings_page() {

    // --- Save VtrustCard API credentials (nonce + capability protected) ---
    if ( isset( $_POST['gametoy_save_credentials'] ) ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to manage these settings.', 'gametoy' ) );
        }
        check_admin_referer( 'gametoy_save_credentials' );

        update_option( 'gametoy_client_id', sanitize_text_field( wp_unslash( $_POST['gametoy_client_id'] ?? '' ) ) );

        // Only overwrite the secret when a new value is supplied, so re-saving
        // the form without re-typing it does not wipe the stored secret.
        $secret = trim( (string) wp_unslash( $_POST['gametoy_client_secret'] ?? '' ) );
        if ( $secret !== '' ) {
            update_option( 'gametoy_client_secret', sanitize_text_field( $secret ) );
        }

        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'GameToy API credentials saved.', 'gametoy' ) . '</p></div>';
    }

    $client_id  = (string) get_option( 'gametoy_client_id', '' );
    $has_secret = (string) get_option( 'gametoy_client_secret', '' ) !== '';
    $const_used = defined( 'GAMETOY_CLIENT_ID' ) || defined( 'GAMETOY_CLIENT_SECRET' );
    ?>
    <div class="wrap gametoy-bootstrap">
        <h1><?php _e( 'GameToy Settings', 'gametoy' ); ?></h1>

        <h2><?php _e( 'VtrustCard API Credentials', 'gametoy' ); ?></h2>
        <?php if ( $const_used ) : ?>
            <div class="notice notice-info inline"><p>
                <?php _e( 'API credentials are currently provided by constants in <code>wp-config.php</code> and take priority over the values below.', 'gametoy' ); ?>
            </p></div>
        <?php endif; ?>
        <form method="post" action="" class="mb-4 text-right">
            <?php wp_nonce_field( 'gametoy_save_credentials' ); ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="gametoy_client_id"><?php _e( 'Client ID', 'gametoy' ); ?></label></th>
                    <td>
                        <input type="text" id="gametoy_client_id" name="gametoy_client_id"
                               value="<?php echo esc_attr( $client_id ); ?>" class="regular-text" autocomplete="off">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="gametoy_client_secret"><?php _e( 'Client Secret', 'gametoy' ); ?></label></th>
                    <td>
                        <input type="password" id="gametoy_client_secret" name="gametoy_client_secret" value=""
                               class="regular-text" autocomplete="new-password"
                               placeholder="<?php echo $has_secret ? esc_attr__( 'Saved — leave blank to keep current secret', 'gametoy' ) : esc_attr__( 'Enter client secret', 'gametoy' ); ?>">
                        <p class="description">
                            <?php _e( 'For best security, define <code>GAMETOY_CLIENT_ID</code> and <code>GAMETOY_CLIENT_SECRET</code> in <code>wp-config.php</code> instead of storing them in the database.', 'gametoy' ); ?>
                        </p>
                    </td>
                </tr>
            </table>
            <p>
                <button type="submit" name="gametoy_save_credentials" value="1" class="button button-primary">
                    <?php _e( 'Save Credentials', 'gametoy' ); ?>
                </button>
            </p>
        </form>

        <hr>

        <h2><?php _e( 'Fetch / Import Products', 'gametoy' ); ?></h2>
        <?php include plugin_dir_path( __FILE__ ) . 'form.php'; ?>
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
