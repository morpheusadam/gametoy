<?php

// Hook for order status change to "completed"
add_action('woocommerce_order_status_completed', 'gametoy_order_status_completed', 10, 1);

function gametoy_order_status_completed($order_id) {
    write_log('Order status changed to completed for order ID: ' . $order_id); // Log message

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
    write_log([
        'message' => 'Prepared data for API request',
        'data' => [
            'ip' => $ip,
            'merchantOrderId' => $merchantOrderId,
            'notifyUrl' => $notifyUrl,
            'priceGroupGoodsId' => $priceGroupGoodsId,
            'buyNumber' => $buyNumber,
            'rechargePlatformConfig' => $rechargePlatformConfig
        ]
    ]);

    // Call the API
    $response = submitOrder($ip, $merchantOrderId, $notifyUrl, $priceGroupGoodsId, $buyNumber, json_encode($rechargePlatformConfig));

    // Log the full response
    write_log([
        'message' => 'Order ID: ' . $order_id . ' - Full API Response',
        'response' => $response
    ]);
}
?>