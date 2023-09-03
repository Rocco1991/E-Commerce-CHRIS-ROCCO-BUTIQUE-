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
$product_number = '36'; 
$_SESSION['total'] = '';



// Check if payment has been made
if (isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];
    $stmt = $mysqli->prepare("UPDATE payments SET status = 'paid' WHERE id = ?");
    $stmt->bind_param("i", $payment_id);

    if ($stmt->execute()) {
        // Payment status updated successfully, redirect user to payment.php
        header("Location: payment.php");
        exit;
    } else {
        // Error updating payment status
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close database connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORDER CONFIRMATION PAGE</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- CSS LINK  DODAJE SE ..//assets/css/style.css  -->
    <link rel="stylesheet" href="../assets/css/style.css">  

</head>
<body>



  <!--Navbar -->

  <nav class="navbar navbar-expand-lg py-3 fixed-top navbar-light">
        <div class="container">
            <a href="../index.php"><img class="logo" src="../assets/imgs/Logo.png"></a>
            <h2 class="brand">CHRIS ROCCO BUTIQUE</h2>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../../index.php">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../shop.php">SHOP</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../blog.php">BLOG</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../../contact.php">CONTACT US</a>
                    </li>


                    <li class="nav-item">
                        <a href="../../cart.php"> <i class="fa-solid fa-cart-shopping"></i></a>
                    </li>

                    <li class="nav-item">
                        <a href="../../account.php"><i class="fa-solid fa-user"></i></a>
                    </li>

                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="" alt="">
                        <span>LANGUAGES</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    <li><a class="dropdown-item" href="#"><img class="flag-icon" src="../assets/imgs/en.gif" alt="English Flag"> English</a></li>
                        <li><a class="dropdown-item" href="#"><img class="flag-icon" src="../assets/imgs/hr.gif" alt="Croatian Flag"> Croatian</a></li>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


 <!--CONFIRMATION THANK YOU & PAYMENT-->

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
    <a href="../payment.php">PAY NOW</a>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <a href="../index.php">BACK TO MAIN PAGE</a> 
  </div>


<!-- Footer -->
<footer class="">
        <div class="row container mx-auto pt-5">
            <div class="footer.one col-lg-3 col-md-6 col-sm-12">
                <a href="../index.php"><img class="logo" src="../assets/imgs/Logo.png"></a>
                <p class="pt-3">CHRIS ROCCO BUTIQUE</p>
            </div>

            <div class="footer.one col-lg-3 col-md-6 col-sm-12">
                <p class="pb-2">FEATURED</p>
                <ul class="text-uppercase">
                    <li><a href="#">Men</a></li>
                    <li><a href="#">Women</a></li>
                    <li><a href="#">Boys</a></li>
                    <li><a href="#">Girls</a></li>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Clothes</a></li>
                </ul>
            </div>

            <div class="footer.one col-lg-3 col-md-6 col-sm-12">
                <p class="pb-2">CONTACT US</p>
                <div>
                    <p class="text-uppercase">Address </p>
                    <P>Via delle Terme di Tito, 72, 00184 Roma RM, Italia</P>
                </div>

                <div>
                    <p class="text-uppercase">Phone</p>
                    <P>+38509811111222</P>
                </div>

                <div>
                    <p class="text-uppercase">Email Address</p>
                    <P>user123@gmail.com</P>
                </div>
            </div>

            <div class="footer.one col-lg-3 col-md-6 col-sm-12">
                <p class="pb-2">SOCIAL MEDIA</p>
                <div class="row">

                    <div class>
                        <a href="https://www.facebook.com/"><img src="../assets/imgs/facebook.png" class="img-fluid w-auto h-auto m-2" alt="Facebook Link">Facebook &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.youtube.com/"><img src="../assets/imgs/youtube.png" class="img-fluid w-auto h-auto m-2" alt="Youtube Link">Youtube &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.instagram.com/"><img src="../assets/imgs/instagram.png" class="img-fluid w-auto h-auto m-2" alt="Instagram Link">Instagram &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.tiktok.com/"><img src="../assets/imgs/twitter.png" class="img-fluid w-auto h-auto m-2" alt="Tik-Tok Link">Tik Tok &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://twitter.com/"><img src="../assets/imgs/skype.png" class="img-fluid w-auto h-auto m-2" alt="Twitter Link">Twitter &#xae;</a>
                    </div>
                </div>
            </div>

            <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <p>eCommerce CHRIS ROCCO All Rights Reserved AUGUST 2023</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>