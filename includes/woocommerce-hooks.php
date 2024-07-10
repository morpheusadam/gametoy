<?php

// Hook for order status change to "completed"
add_action('woocommerce_order_status_completed', 'gametoy_order_status_completed', 10, 1);

function generateUniqueOrderId() {
    // Generate a random 7-digit integer
    $uniqueOrderId = random_int(1000000, 9999999); // 7-digit range

    return $uniqueOrderId;
}

function generateUniquePlayerId() {
    // Generate a random 7-digit integer
    $uniquePlayerId = random_int(1000000, 9999999); // 7-digit range

    return $uniquePlayerId;
}

function generateRandomNumber() {
    // Generate a random 11-digit integer
    $randomNumber = random_int(10000000000, 99999999999); // 11-digit range

    return $randomNumber;
}

function gametoy_order_status_completed($order_id) {
    account_log('Order status changed to completed for order ID: ' . $order_id); // Log message

    $order = wc_get_order($order_id);

    // Get order details
    $order_data = $order->get_data();
    $order_items = $order->get_items();

    // Prepare data for API request
    $ip = $_SERVER['REMOTE_ADDR'];
    $merchantOrderId = generateUniqueOrderId();
    $notifyUrl = home_url('/wc-api/WC_Gateway_Gametoy');
    $priceGroupGoodsId = ''; // You need to map this from your product data
    $buyNumber = 1; // Assuming 1 for simplicity, you can adjust as needed
    $rechargePlatformConfig = []; // You need to map this from your product data

    header('Content-Type: text/html; charset=UTF-8');

    foreach ($order_items as $item_id => $item) {
        $product = $item->get_product();
        $priceGroupGoodsId =  $product->get_sku(); // Example mapping, adjust as needed
        $rechargePlatformConfig[] = [
            'name'=> '玩家id',
            'filedName' => 'playerid', // Use the new function here
            'value' => '51673744358', // Only playerid value
            'selected' => 0,
            'tip' => '请填写玩家id'
        ];
    }

    // Log the prepared data
    $log_data = [
        'message' => 'Prepared data for API request',
        'data' => [
            'ip' => $ip,
            'merchantOrderId' => $merchantOrderId,
            'notifyUrl' => $notifyUrl,
            'priceGroupGoodsId' => $priceGroupGoodsId,
            'buyNumber' => $buyNumber,
            'rechargePlatformConfig' => $rechargePlatformConfig
        ]
    ];
    account_log(json_encode($log_data, JSON_UNESCAPED_UNICODE)); // تغییر این خط

    // Call the API
    $response = submitOrder($ip, $merchantOrderId, $notifyUrl, $priceGroupGoodsId, $buyNumber, json_encode($rechargePlatformConfig, JSON_UNESCAPED_UNICODE)); // تغییر این خط

    // Log the full response
    $response_log = [
        'message' => 'Order ID: ' . $order_id . ' - Full API Response',
        'response' => $response
    ];
    account_log(json_encode($response_log, JSON_UNESCAPED_UNICODE)); // تغییر این خط

    // Send email to customer
    $customer_email = $order->get_billing_email();
    $subject = 'اطلاعات سفارش شما';

    // Extract necessary data from the response
    $response_data = $response['data']['order'];
    $code = $response['data']['code'];
    $playerid = $rechargePlatformConfig[0]['value'];
    $orderId = $response_data['orderId'];
    $payPrice = $response_data['payPrice'];
    $totalBuyNumber = $response_data['totalBuyNumber'];
    $priceGroupGoodsId = $response_data['priceGroupGoodsId'];


    $exchangeRate = 60000; // 1 Dollar = 60,000 Toman
    $payPriceDollar = $payPrice / $exchangeRate;

    // Create the email body
    $body = "
    <div style='font-family: Arial, sans-serif;'>
        <h2 style='color: #5f27cd;'>سفارش شما تکمیل شد</h2>
        <p>لطفا موارد ذکر شده در این صفحه را با دقت مطالعه نمایید</p>
        <p>سلام،</p>
        <p>سفارش شما تکمیل شد و به شرح زیر است:</p>
        <table style='width: 100%; border-collapse: collapse;'>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>کد</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$code</td>
            </tr>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>شناسه بازیکن</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$playerid</td>
            </tr>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>شناسه سفارش</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$orderId</td>
            </tr>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>قیمت پرداختی</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$payPriceDollar</td>
            </tr>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>تعداد کل خرید</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$totalBuyNumber</td>
            </tr>
            <tr>
                <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>شناسه گروه قیمت کالا</th>
                <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>$priceGroupGoodsId</td>
            </tr>
        </table>
    </div>
";

    $email_template = create_persian_email_template($subject, $body);

    // Send email and log the result
    $headers = "From: sender@cigiftcard.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    $mail_sent = mail($customer_email, $email_template['subject'], $email_template['body'], $headers);

    if ($mail_sent) {
        write_log('Email sent successfully to: ' . $customer_email);
    } else {
        write_log('Failed to send email.');
    }
}
?>