<?php
echo '<h2 class="text-right">' . __('API Response', 'gametoy') . '</h2>'; // Added text-right class for RTL

if (!empty($response['data'])) {
    echo '<div class="row products">';
    foreach ($response['data'] as $product) {
        include plugin_dir_path(__FILE__) . 'display-product-card.php';
    }
    echo '</div>';
    echo '<button id="loadMore" data-page-num="1">' . __('Load More', 'gametoy') . '</button>'; // Added Load More button
} else {
    echo '<p class="text-right">' . __('No products found.', 'gametoy') . '</p>'; // Added text-right class for RTL
}
?>