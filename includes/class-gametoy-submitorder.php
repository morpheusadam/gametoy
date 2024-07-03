<?php
function submitOrder($ip, $merchantOrderId, $notifyUrl, $priceGroupGoodsId, $buyNumber, $rechargePlatformConfig) {
    $url = "http://merchantapi.vtrustcard.com/api/v1/submitOrder";
    $clientId = "fefd9390573126a3f3be47452a084325";
    $clientSecret = "2baf41c8a36a98363239e0637b804ba9";
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

    // Debugging information
    echo "Request URL: $url\n";
    echo "Request Headers: " . print_r($headers, true) . "\n";
    echo "Request Parameters: " . json_encode($requestParams) . "\n";

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
    } else {
        echo "Response: " . $response . "\n";
    }
    curl_close($ch);

    return json_decode($response, true);
}
