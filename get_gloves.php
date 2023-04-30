<?php

include('connection.php');


$stmt = $conn->prepare("SELECT * FROM products WHERE product_category='gloves' LIMIT 4");

$stmt->execute();

$glove_products = $stmt->get_result();


?>