<?php
function submitOrder($ip, $merchantOrderId, $notifyUrl, $priceGroupGoodsId, $buyNumber, $rechargePlatformConfig) {
    $url = "http://merchantapi.vtrustcard.com/api/v1/submitOrder";

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
        'ip' => $ip,
        'merchantOrderId' => $merchantOrderId,
        'notifyUrl' => $notifyUrl,
        'orderItemsBOList' => [
            [
                'priceGroupGoodsId' => $priceGroupGoodsId,
                'buyNumber' => $buyNumber,
                'rechargePlatformConfig' => $rechargePlatformConfig
            ]
        ],
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
        write_log('CURL error (submitOrder): ' . curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}
