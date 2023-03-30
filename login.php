<?php

session_start();

include('server/connection.php');

// Check if the user is already logged in
if (isset($_SESSION['Logged_in']) && $_SESSION['Logged_in']) {
    header('Location: account.php');
    exit;
}

if(isset($_POST['login_btn'])){
 
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id,user_name,user_email,user_password FROM users WHERE user_email=? AND user_password = ? LIMIT 1");

    $stmt->bind_param('ss',$email, $password);

    if($stmt->execute()){
        $stmt->bind_result( $user_id, $user_name, $user_email, $user_password );
        $stmt->store_result();
    
        if($stmt->num_rows == 1){
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['Logged_in'] = true;

            header('location: account.php?message=logged in successfully');

        }else{
            header('location: login.php?error=could not verify your account');
        }

    }else{

        //error
        header('location: login.php?error=something went wrong');
    }
}

?>










<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>

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
                        <a href="account.html"><i class="fa-solid fa-user"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Login -->

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
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">

              <p style="color:red;" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; } ?></p>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter Your Email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter Your Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
                </div>

                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">Dont have account? Register Now!</a>
                </div>
            </form>
        </div>
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