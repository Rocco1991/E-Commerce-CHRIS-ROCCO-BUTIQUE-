<?php

include('connection.php');

// 24 proizvoda je ograničenje za shop.php a može bit ograničenje po želji bilo koliko

$stmt = $conn->prepare("SELECT * FROM products LIMIT 24");

$stmt->execute();

$featured_products = $stmt->get_result();


?>