<?php
session_start();

include('connection.php');

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: /checkout.php?message=Please login/register to place an order');
    exit;
}

if (isset($_POST['place_order'])) {
    // Get user info
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    // Get order cost from session
    $order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : null;

    // Get user ID from session
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Check if necessary data is available
    if ($order_cost === null || $user_id === null) {
        header("Location: ../index.php?error=Order%20data%20missing");
        exit;
    }

    // Insert order into orders table
    $order_status = "not paid";
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_name, user_email, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('dssssssss', $order_cost, $order_status, $user_id, $name, $email, $phone, $city, $address, $order_date);
    
    if (!$stmt->execute()) {
        // Handle database error
        header("Location: ../index.php?error=Failed%20to%20place%20order");
        exit;
    }

    $order_id = $stmt->insert_id;

    // Insert order items into order_items table
    foreach ($_SESSION['cart'] as $id => $product) {
        // Validate product data
        if (isset($product['product_id'], $product['product_name'], $product['product_image'], $product['product_price'], $product['product_quantity'])) {
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];

            $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param('iissdiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);

            if (!$stmt1->execute()) {
                // Handle database error
                header("Location: ../index.php?error=Failed%20to%20add%20order%20items");
                exit;
            }
            
        } else {
            // Handle invalid product data
            header("Location: ../index.php?error=Invalid%20product%20data");
            exit;
        }
    }

    // Clear cart
    unset($_SESSION['cart']);

    // Redirect to order confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit;
}

?>
