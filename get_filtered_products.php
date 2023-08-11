<?php
// server/get_filtered_products.php

include('server/connection.php');

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
    $products = $stmt->get_result();

    // Return the filtered products as JSON
    header('Content-Type: application/json');
    echo json_encode($products->fetch_all(MYSQLI_ASSOC));
}
?>
