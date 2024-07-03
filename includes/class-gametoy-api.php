<?php

function getGoodsList($pageNum, $pageSize) {
    $url = "http://merchantapi.vtrustcard.com/api/v1/getGoodsList/$pageNum/$pageSize";
    $clientId = "fefd9390573126a3f3be47452a084325";
    $clientSecret = "2baf41c8a36a98363239e0637b804ba9";
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
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL peer verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL host verification

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);

    $data = json_decode($response, true);

    // Add products to WooCommerce
    if (!empty($data['data'])) {
        foreach ($data['data'] as $product) {
            gametoy_add_product_to_woocommerce($product);
        }
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
    }
}
?>