<?php


session_start();

include('server/connection.php');

// Check if the user is already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
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
            $_SESSION['logged_in'] = true;

            header('location: account.php?login_success=logged in successfully');

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS LINK  -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- FONT AWSOME KIT LINK -->
    <script src="https://kit.fontawesome.com/2660aeb402.js" crossorigin="anonymous"></script>

</head>

<body>

    <!--NAVBAR -->

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
          <a class="nav-link" href="blog.php">BLOG</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="contact.php">CONTACT US</a>
        </li>

        <li class="nav-item">
          <a href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </li>

        <li class="nav-item">
          <a href="account.php"><i class="fa-solid fa-user"></i></a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="" alt="">
            <span>LANGUAGES</span>
          </a>
          <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" href="#"><img class="flag-icon" src="assets/imgs/en.gif" alt="English Flag"> English</a></li>
            <li><a class="dropdown-item" href="#"><img class="flag-icon" src="assets/imgs/hr.gif" alt="Croatian Flag"> Croatian</a></li>
          </ul>
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
            <h2 class="form-weight-bold">LOGIN HERE PLEASE</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">

              <p style="color:red;" class="text-center"><?php if(isset($_GET['error'])){ echo $_GET['error']; } ?></p>

                <div class="form-group">
                    <label>E-MAIL</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Enter Your Email Please..." required>
                </div>

                <div class="form-group">
                    <label>PASSWORD</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter Your Password Please..." required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login" />
                </div>

                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">DONT HAVE ACCOUNT? PLEASE REGISTER NOW!</a>
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
                <p class="pb-2 golden-underline-heading">FEATURED</p>
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
                <p class="pb-2 golden-underline-heading">CONTACT US</p>
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
                <p class="pb-2 golden-underline-heading">SOCIAL MEDIA</p>
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
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <p>eCommerce CHRIS ROCCO All Rights Reserved AUGUST 2023</p>
                </div>
            </div>
        </div>




        <div id="move-to-top" class="scrollToTop filling">
            <a href="login.php"><i class="fa fa-chevron-up"></i></a>
        </div>

    </footer>

    <!-- JS LINK  -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
</body>

</html>