<?php 
session_start();

include('connection.php');

if( isset($_POST['place_order']) ){
  
    
    // 1. get user info and store it in DB
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
    $user_id = 1;
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn ->prepare("INSERT INTO orders (order_cost,order_status,user_id,user_phone,user_city,user_address,order_date)
                    VALUES (?,?,?,?,?,?,?); ");

    $stmt->bind_param('isiisss',$order_cost,$order_status,$user_id,$phone,$city,$address,$order_date);

    $stmt->execute();



    // 2. get products from cart (from session)

    // 3. issue new order and store order information in DB

    // 4. store each single item in order_items DB

    // 5. remove everything from cart 

    // 6. inform user that everything is fine or there is a problem
}



?>