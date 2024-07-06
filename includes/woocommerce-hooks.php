<?php

// Hook for order status change to "completed"
add_action('woocommerce_order_status_completed', 'gametoy_order_status_completed', 10, 1);

function gametoy_order_status_completed($order_id) {
    account_log('Order status changed to completed for order ID: ' . $order_id); // Log message

    $order = wc_get_order($order_id);

    // Get order details
    $order_data = $order->get_data();
    $order_items = $order->get_items();

    // Prepare data for API request
    $ip = $_SERVER['REMOTE_ADDR'];
    $merchantOrderId = $order_data['id'];
    $notifyUrl = home_url('/wc-api/WC_Gateway_Gametoy');
    $priceGroupGoodsId = ''; // You need to map this from your product data
    $buyNumber = 1; // Assuming 1 for simplicity, you can adjust as needed
    $rechargePlatformConfig = []; // You need to map this from your product data

    foreach ($order_items as $item_id => $item) {
        $product = $item->get_product();
        $priceGroupGoodsId =  $product->get_sku(); // Example mapping, adjust as needed
        $rechargePlatformConfig[] = [
            'name' => $product->get_name(), // Changed to product name
            'value' => $product->get_sku(), // Changed to product SKU
            'filedName' => 'playerid',
            'selected' => 0,
            'tip' => '1'
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
    account_log($log_data);

    // Call the API
    $response = submitOrder($ip, $merchantOrderId, $notifyUrl, $priceGroupGoodsId, $buyNumber, json_encode($rechargePlatformConfig));

    // Log the full response
    $response_log = [
        'message' => 'Order ID: ' . $order_id . ' - Full API Response',
        'response' => $response
    ];
    account_log($response_log);

    // Send email to customer
    $customer_email = $order->get_billing_email();
    $subject = 'اطلاعات سفارش شما';
    $body = json_encode($response['response'], JSON_PRETTY_PRINT); // فقط ارسال response

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