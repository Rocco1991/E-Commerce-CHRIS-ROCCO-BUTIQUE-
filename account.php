<?php

session_start();
include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('Location: login.php');
    exit; 
}

if(isset($_GET['logout'])){


    if (isset($_GET['logout'])) {
        // Remove user data from $_SESSION
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page
    header('Location: login.php');
    exit;
}

}

if(isset($_POST['change_password'])){
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];
            
    // IF PASSWORDS DON'T MATCH
    if ($password !== $confirmPassword) {
        header('location: account.php?error=passwords dont match');
    // IF PASSWORD IS LESS THAN 6 CHARACTERS
    } else if(strlen($password) < 6) {
        header('location: account.php?error=password must be at least 6 characters');
    } else {
        $hashed_password = md5($password);
        $stmt = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
        $stmt->bind_param('ss', $hashed_password, $user_email);

        if($stmt->execute()){
            header('location: account.php?message=password has been updated successfully');
        }else{
            header('location: account.php?message=couldnt update password');
        }
    }
}

// GET ORDERS

if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id=? ");

    $stmt->bind_param('i',$user_id);

    $stmt->execute();

    $orders = $stmt->get_result();

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOUR ORDERS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- CSS LINK  -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <!--Navbar -->

    <nav class="navbar navbar-expand-lg py-3 fixed-top navbar-light">
        <div class="container">
            <a href="index.php"><img class="logo" src="assets/imgs/Logo.png"></a>
            <h2 class="brand">CHRIS ROCCO BUTIQUE</h2>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">HOME</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="shop.php">SHOP</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="blog.html">BLOG</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">CONTACT US</a>
                    </li>


                    <li class="nav-item">
                        <a href="cart.php"> <i class="fa-solid fa-cart-shopping"></i></a>
                    </li>

                    <li class="nav-item">
                        <a href="account.php"><i class="fa-solid fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Account -->

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
    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style="color:green"> <?php if(isset($_GET['register_success'])){ echo $_GET['register_success'];} ?> </p>
            <p class="text-center" style="color:green"> <?php if(isset($_GET['login_success'])){ echo $_GET['login_success'];} ?> </p>
                <h3 class="font-weight-bold">ACCOUNT INFO</h3>
                <hr class="mx-auto">

                <div class="account-info">
                    <p> NAME:<span> <?php if(isset($_SESSION['user_name'])){ echo $_SESSION['user_name'];}?> </span> </p>
                    <br>
                    <p> E-MAIL:<span> <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email'];}?>  </span> </p>
                    <br>
                    <p> <a href="#orders" id="orders-btn">YOUR ORDERS</a> </p>
                    <br>
                    <p> <a href="account.php?logout=1" id="logout-btn">Logout</a> </p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 ">
                <form id="account-form" method="POST" action="account.php">
                    <p class="text-center" style="color:red"> <?php if(isset($_GET['error'])){ echo $_GET['error'];} ?> </p>
                    <p class="text-center" style="color:green"> <?php if(isset($_GET['message'])){ echo $_GET['message'];} ?> </p>
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required/>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Confirm Password" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Confirm Password" name="change_password" class="btn" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>

    </section>


    <!-- Orders -->

    <section id="orders" class="orders container my-5 py-3">
        <div class="container mt-2">
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
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">

            <tr>
                <th>ORDER ID</th>
                <th>ORDER COST</th>
                <th>ORDER STATUS</th>
                <th>ORDER DATE</th>
                <th>ORDER DETAILS</th>
            </tr>

            <?php while($row = $orders->fetch_assoc() ) { ?>

                        <tr>
                            <td>
                                <div class="product-info">
                                    <!-- <img src="assets/imgs/Black-Male-Jacket.jpg"> -->
                                    <div class="mx-auto"> <?php echo $row['order_id']; ?> </div>
                                </div>
                            </td>

                            <td>
                               <span> $ <?php echo $row['order_cost']; ?></span>
                            </td>

                            <td>
                               <span><?php echo $row['order_status']; ?></span>
                            </td>

                            <td>
                               <span><?php echo $row['order_date']; ?></span>
                            </td>

                            <td>
                              <form method="POST" action="order_details.php">
                                <input type="hidden" value=" <?php echo $row['order_status']; ?>" name= "order_status"/>
                                <input type="hidden" value=" <?php echo $row['order_id']; ?>" name= "order_id"/>
                                <input class="btn order-details-btn" name="order_details_btn" type="submit" value="details"/>
                              </form>
                            </td>

                        </tr> 
            <?php }  ?>     

        </table>
    </section>



    <!-- Footer -->
    <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
            <div class="footer.one col-lg-3 col-md-6 col-sm-12">
                <a href="index.php"><img class="logo" src="assets/imgs/Logo.png"></a>
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
                    <P>+3850981111222</P>
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
                        <a href="https://www.facebook.com/"><img src="assets/imgs/facebook.png" class="img-fluid w-auto h-auto m-2" alt="Facebook Link">Facebook &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.youtube.com/"><img src="assets/imgs/youtube.png" class="img-fluid w-auto h-auto m-2" alt="Youtube Link">Youtube &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.instagram.com/"><img src="assets/imgs/instagram.png" class="img-fluid w-auto h-auto m-2" alt="Instagram Link">Instagram &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://www.tiktok.com/"><img src="assets/imgs/twitter.png" class="img-fluid w-auto h-auto m-2" alt="Tik-Tok Link">Tik Tok &#xae;</a>
                    </div>

                    <div class>
                        <a href="https://twitter.com/"><img src="assets/imgs/skype.png" class="img-fluid w-auto h-auto m-2" alt="Twitter Link">Twitter &#xae;</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright mt-5">
            <div class="row container mx-auto">
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                    <img src="assets/imgs/paymentVisa.png" alt="">
                </div>

                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <p>eCommerce CHRIS ROCCO All Rights Reserved January 2023</p>
                </div>
            </div>
        </div>




        <div id="move-to-top" class="scrollToTop filling">
            <a href="index.php"><i class="fa fa-chevron-up"></i></a>
        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>


</html>