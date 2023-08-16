<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form input
    $card_number = $_POST['card_number'];
    $card_holder = $_POST['card_holder'];
    $expiration_month = $_POST['expiration_month'];
    $expiration_year = $_POST['expiration_year'];

    // Check if the "cvv" key exists in the $_POST array
    if (isset($_POST['cvv'])) {
        $cvv = $_POST['cvv'];
    } else {
        $cvv = ''; // Assign an empty value if "cvv" key is not present
    }

    // Validate input (you can add more validation rules as needed)
    if (empty($card_number) || empty($card_holder) || empty($expiration_month) || empty($expiration_year) || empty($cvv)) {
        $error_message = 'Please fill in all the required fields.';
        // You can display the error message or redirect the user back to the payment form with an error notification.
    } else {
        // Process the payment (using a payment gateway or API)
        // ...

        // Set session variable to indicate payment was successful
        $_SESSION['paid'] = true;

        // Redirect to a confirmation page or any desired page indicating successful payment
        header("Location: confirmation.php");
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAYMENT METHOD FORM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- CSS LINK  -->
    <link rel="stylesheet" href="assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


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
          <a class="nav-link" href="blog.html">BLOG</a>
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
            <li><a class="dropdown-item" href="#"><img src="assets/imgs/en.gif" alt="English Flag"> English</a></li>
            <li><a class="dropdown-item" href="#"><img src="assets/imgs/hr.gif" alt="Croatian Flag"> Croatian</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <!--PAYMENT -->




    <div class="container3">
        <!-- FRONT OF THE CARD -->
        <div class="card-container3">
            <div class="front">

                <div class="imagepayment">
                    <img src="assets/imgs/chip.png" class="chip-icon">
                    <img src="assets/imgs/visa.png" class="visa-logo">

                    <div class="card-number-box">################</div>

                    <div class="flexbox2">
                        <div class="box1">
                            <span>Card Holder</span>
                            <div class="card-holder-name">Full Name</div>
                        </div>

                        <div class="box2">
                            <span>Expires</span>
                            <div class="expiration">
                                <span class="exp-month">MM</span>
                                <span class="exp-year">YY</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BACK OF THE CARD -->
            <div class="back">
                <div class="stripe">
                    <div class="box">
                        <span>CVV</span>
                        <div class="cvv-box">
                            <img src="assets/imgs/visa.png" class="visa-logo-back">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <form action="payment.php" method="POST">
            <div class="inputBox2">
                <span>Card Number</span>
                <input type="text" name="card_number" maxlength="16" class="card-number-input">
            </div>

            <div class="inputBox2">
                <span>Card Holder</span>
                <input type="text" name="card_holder" maxlength="16" class="card-holder-input">
            </div>

            <div class="flexbox2">
                <div class="inputBox2">
                    <span>Expiration mm</span>
                    <select name="expiration_month" id="" class="month-input">
                        <option value="month" selected disabled>month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>

                <div class="inputBox2">
                    <span>Expiration yy</span>
                    <select name="expiration_year" id="" class="year-input">
                        <option value="year" selected disabled>year</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                        <option value="2036">2036</option>
                        <option value="2037">2037</option>
                        <option value="2038">2038</option>
                        <option value="2039">2039</option>
                        <option value="2040">2040</option>
                        <option value="2041">2041</option>
                        <option value="2042">2042</option>
                        <option value="2043">2043</option>
                        <option value="2044">2044</option>
                        <option value="2045">2045</option>
                        <option value="2046">2046</option>
                        <option value="2047">2047</option>
                        <option value="2048">2048</option>
                        <option value="2049">2049</option>
                        <option value="2050">2050</option>
                        <option value="2051">2051</option>
                        <option value="2052">2052</option>
                        <option value="2053">2053</option>
                        <option value="2054">2054</option>
                        <option value="2055">2055</option>
                        <option value="2056">2056</option>
                        <option value="2057">2057</option>
                        <option value="2058">2058</option>
                        <option value="2059">2059</option>
                        <option value="2060">2060</option>
                        <option value="2061">2061</option>
                        <option value="2062">2062</option>
                        <option value="2063">2063</option>
                        <option value="2064">2064</option>
                        <option value="2065">2065</option>
                        <option value="2066">2066</option>
                        <option value="2067">2067</option>
                        <option value="2068">2068</option>
                        <option value="2069">2069</option>
                        <option value="2070">2070</option>
                    </select>
                </div>

            </div>
            <!-- YOUR CVV -->
            <div class="inputBox2">
                <br>
                <span>CVV</span>
                <input type="text" name="cvv" maxlength="4" class="cvv-input">
            </div>

            <input type="submit" value="submit" class="submit-btn">
        </form>
    </div>





    <!-- Footer -->
    <footer>
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
                    <P>+385098111112222</P>
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
                <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                    <p>eCommerce CHRIS ROCCO All Rights Reserved AUGUST 2023</p>
                </div>
            </div>
        </div>

        <div id="move-to-top" class="scrollToTop filling">
            <a href="payment.php"><i class="fa fa-chevron-up"></i></a>
        </div>

    </footer>
   

</body>

</html>