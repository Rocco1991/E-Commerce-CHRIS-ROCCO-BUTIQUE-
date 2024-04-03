<?php
session_start(); // Start the session

// Connect to database
$mysqli = new mysqli("localhost", "root", "", "chris_rocco_butique");
// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// GREŠKA

$order_id = ''; 
$product_number = ''; 
$_SESSION['total'] = ''; // You need to set this based on your logic

// Check if payment has been made
if (isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];
    $stmt = $mysqli->prepare("UPDATE payments SET status = 'paid' WHERE id = ?");
    $stmt->bind_param("i", $payment_id);

    if ($stmt->execute()) {
        // Payment status updated successfully

        // Retrieve order information from your database based on $payment_id
        $result = $mysqli->query("SELECT order_id, product_number, total_amount FROM orders WHERE payment_id = $payment_id");

        if ($result && $row = $result->fetch_assoc()) {
            // Set values for $order_id, $product_number, and $_SESSION['total']
            $order_id = $row['order_id'];
            $product_number = $row['product_number'];
            $_SESSION['total'] = $row['total_amount'];
        } else {
            // Handle the case where order information is not found
            echo "Error: Order information not found";
        }

        // Close database connection
        $stmt->close();
    } else {
        // Error updating payment status
        echo "Error: " . $stmt->error;
        $stmt->close();
    }
}

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER CONFIRMATION PAGE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWESOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS LINK DODAJE SE ..//assets/css/style.css -->
    <link rel="stylesheet" href="../assets/css/style.css">  

    <!-- FONT AWESOME KIT LINK -->
    <script src="https://kit.fontawesome.com/2660aeb402.js" crossorigin="anonymous"></script>
</head>
<body>
   

    <!-- CONFIRMATION THANK YOU & PAYMENT -->
    <div class="order-confirmation-container">
        <br>
        <br>
        <h1>THANK YOU FOR YOUR ORDER!</h1>
        <br>
        <img src="/assets/imgs/check-mark.jpg" alt="Confirmation Mark"> 
        <br>
        <br>
        <br>
        <br>
        <br>
        <p>Your order number is: <?php echo $order_id; ?></p>
        <br>
        <br>
        <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
        <br>
        <br>
        <br>
        <a href="../payment.php">PAY NOW</a>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <a href="../index.php">BACK</a> 
    </div>

    <!-- Footer (your existing HTML) -->
    

    <!-- JS LINK  -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
</body>
</html>
