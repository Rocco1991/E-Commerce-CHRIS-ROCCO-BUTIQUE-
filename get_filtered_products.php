<?php
// server/get_filtered_products.php

include('connection.php'); // Ensure that the path to connection.php is correct

if (isset($_POST['search'])) {
    $category = $_POST['category'];
    $price = $_POST['price'];
    $color = $_POST['color'];

    // Prepare the SQL statement with color filtering
    if ($color === 'all') {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price=?");
        $stmt->bind_param('si', $category, $price);
    } else {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price=? AND product_color=?");
        $stmt->bind_param('sis', $category, $price, $color);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Store the filtered products in an array
    $filteredProducts = [];

    while ($row = $result->fetch_assoc()) {
        $filteredProducts[] = $row;
    }

    // Return the filtered products as JSON
    header('Content-Type: application/json');
    echo json_encode($filteredProducts);
}
?>
