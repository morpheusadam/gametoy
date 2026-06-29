<?php

if ( ! function_exists( 'gametoy_get_api_credentials' ) ) {
    /**
     * Resolve the VtrustCard merchant API credentials.
     *
     * Order of precedence:
     *   1. Constants defined in wp-config.php (recommended, keeps secrets out of the DB):
     *        define( 'GAMETOY_CLIENT_ID', '...' );
     *        define( 'GAMETOY_CLIENT_SECRET', '...' );
     *   2. Options saved from the GameToy → Settings page.
     *
     * NOTE: credentials are no longer hard-coded in the source. If you previously
     * used the leaked demo keys, rotate them in your VtrustCard merchant panel.
     *
     * @return array{clientId:string,clientSecret:string}
     */
    function gametoy_get_api_credentials() {
        $client_id     = defined( 'GAMETOY_CLIENT_ID' ) ? GAMETOY_CLIENT_ID : get_option( 'gametoy_client_id', '' );
        $client_secret = defined( 'GAMETOY_CLIENT_SECRET' ) ? GAMETOY_CLIENT_SECRET : get_option( 'gametoy_client_secret', '' );

        return array(
            'clientId'     => (string) $client_id,
            'clientSecret' => (string) $client_secret,
        );
    }
}

function getGoodsList($pageNum, $pageSize) {
    $url = "http://merchantapi.vtrustcard.com/api/v1/getGoodsList/$pageNum/$pageSize";

    $creds        = gametoy_get_api_credentials();
    $clientId     = $creds['clientId'];
    $clientSecret = $creds['clientSecret'];

    if ( empty( $clientId ) || empty( $clientSecret ) ) {
        write_log( 'GameToy API credentials are not configured. Set them under GameToy → Settings (or in wp-config.php).' );
        return array( 'error' => 'API credentials are not configured.' );
    }

    $timestamp = time(); // Current timestamp
    $nonce = bin2hex(random_bytes(16)); // Generate a random nonce

    // Request parameters
    $requestParams = [
        'pageNum' => $pageNum,
        'pageSize' => $pageSize,
        'timestamp' => $timestamp,
        'nonce' => $nonce
    ];

    // Generate AuthSign
    $signatureString = json_encode($requestParams) . $clientSecret;
    $authSign = strtolower(md5($signatureString));

    $headers = [
        "ClientId: $clientId",
        "AuthSign: $authSign",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestParams)); // Send request parameters as JSON payload

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        write_log('CURL error: ' . curl_error($ch)); // Log message
    }
    curl_close($ch);

    $data = json_decode($response, true);

    // Add products to WooCommerce
    if (!empty($data['data'])) {
        foreach ($data['data'] as $product) {
            gametoy_add_product_to_woocommerce($product);
        }
        write_log('Products added to WooCommerce.'); // Log message
    } else {
        write_log('No products found in API response.'); // Log message
    }

    return $data;
}

function gametoy_add_product_to_woocommerce($product) {
    $product_id = wc_get_product_id_by_sku($product['id']);
    if (!$product_id) {
        $new_product = new WC_Product_Simple();
        $new_product->set_name($product['goodsName']);
        $new_product->set_regular_price($product['payPrice']);
        $new_product->set_sku($product['id']);
        $new_product->set_description('Cost Currency: ' . $product['costCurrency']);
        $new_product->save();
        write_log('Added new product to WooCommerce: ' . $product['goodsName']); // Log message
    } else {
        write_log('Product already exists in WooCommerce: ' . $product['goodsName']); // Log message
    }
}
?>
