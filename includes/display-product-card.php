<?php
$id = isset($product['id']) ? htmlspecialchars($product['id']) : 'N/A';
$payPrice = isset($product['payPrice']) ? htmlspecialchars($product['payPrice']) : 'N/A';
$goodsName = isset($product['goodsName']) ? htmlspecialchars($product['goodsName']) : 'N/A';
$costCurrency = isset($product['costCurrency']) ? htmlspecialchars($product['costCurrency']) : 'N/A';
$platformConfig = isset($product['platformConfig']) ? json_decode($product['platformConfig'], true) : [];

echo '<div class="col-md-4 mb-4">';
echo '<div class="card text-right">'; // Added text-right class for RTL
echo '<div class="card-body">';
echo '<h5 class="card-title">' . $goodsName . '</h5>';
echo '<p class="card-text"><strong>ID:</strong> ' . $id . '</p>';
echo '<p class="card-text"><strong>Pay Price:</strong> ' . $payPrice . '</p>';
echo '<p class="card-text"><strong>Cost Currency:</strong> ' . $costCurrency . '</p>';
echo '<p class="card-text"><strong>Platform Config:</strong></p>';
if (!empty($platformConfig)) {
    echo '<ul class="list-group list-group-flush">';
    foreach ($platformConfig as $config) {
        $name = isset($config['name']) ? htmlspecialchars($config['name']) : 'N/A';
        $value = isset($config['value']) ? htmlspecialchars($config['value']) : 'N/A';
        $filedName = isset($config['filedName']) ? htmlspecialchars($config['filedName']) : 'N/A';
        $tip = isset($config['tip']) ? htmlspecialchars($config['tip']) : 'N/A';
        echo '<li class="list-group-item"><strong>Name:</strong> ' . $name . '</li>';
        echo '<li class="list-group-item"><strong>Value:</strong> ' . $value . '</li>';
        echo '<li class="list-group-item"><strong>Field Name:</strong> ' . $filedName . '</li>';
        echo '<li class="list-group-item"><strong>Tip:</strong> ' . $tip . '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>N/A</p>';
}
echo '</div>';
echo '</div>';
echo '</div>';
?>