<?php

include('connection.php');


$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='parfumes' LIMIT 4");

$stmt->execute();

$parfume_products = $stmt->get_result();


?>