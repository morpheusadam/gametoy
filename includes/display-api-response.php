<?php
echo '<h2 class="text-right">' . __('API Response', 'gametoy') . '</h2>'; // Added text-right class for RTL

if (!empty($response['data'])) {
    echo '<div class="row products">';
    foreach ($response['data'] as $product) {
        include plugin_dir_path(__FILE__) . 'display-product-card.php';
    }
    echo '</div>';
    echo '<div class="load-more-container text-center">'; // Added container for Load More button
    echo '<button id="loadMore" class="btn btn-primary">' . __('Load More', 'gametoy') . '</button>'; // Added Load More button
    echo '</div>';
    write_log('Displayed products and Load More button.'); // Log message
} else {
    echo '<p class="text-right">' . __('No products found.', 'gametoy') . '</p>'; // Added text-right class for RTL
    write_log('No products found.'); // Log message
}
?>