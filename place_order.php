<?php

session_start();

include('connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: /checkout.php?message=Please login/register to place an order');
}

if (isset($_POST['place_order']) ) {

        // 1. GET USER INFO AND STORE IT IN DATABASE
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $order_cost = isset($_SESSION['total']) ? $_SESSION['total'] : null;
            $order_status = "not paid";
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            $order_date = date('Y-m-d H:i:s');

            if ($order_cost === null || $user_id === null) {
                header("location: ../index.php");
                exit;
            }
        
            $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_name, user_email, user_phone, user_city, user_address, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('dssssssss', $order_cost, $order_status, $user_id, $name, $email, $phone, $city, $address, $order_date);
            $stmt->execute();
    
            // 2. ISSUE NEW ORDER AND STORE ORDER INFO IN DATABASE
            $order_id = $stmt->insert_id;

            // 3. GET PRODUCTS FROM CART (FROM SESSION)
            foreach ($_SESSION['cart'] as $id => $product) {
                if (isset($product['product_id'], $product['product_name'], $product['product_image'], $product['product_price'], $product['product_quantity'])) {
                    $product_id = $product['product_id'];
                    $product_name = $product['product_name'];
                    $product_image = $product['product_image'];
                    $product_price = $product['product_price'];
                    $product_quantity = $product['product_quantity'];

             // 4. STORE EACH SINGLE ITEM IN ORDER_ITEMS DATABASE
            $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param('iissdiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);

            if (!$stmt1->execute()) {
                header("location: ../index.php");
                exit;
            }
        }
    }
            // 5. REMOVE EVERYTHING FROM CART
            unset($_SESSION['cart']);

            header("location: order_confirmation.php?order_id=$order_id");
            exit;
}

?>