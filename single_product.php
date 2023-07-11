<?php

include('server/connection.php');

if(isset($_GET['product_id'])){

$product_id =  $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

  $stmt->execute();

  $product = $stmt->get_result();     

  //no product id was given
}else{
    header('location: index.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINGLE PRODUCTS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- CSS LINK  -->
    <link rel="stylesheet" href="assets/css/style.css">

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
          <a class="nav-link" href="contact.html">CONTACT US</a>
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

    <!-- Single Product -->
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
    <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

        <?php while($row = $product->fetch_assoc()){ ?>

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg">
                <div class="small-img-group">
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image']; ?>" width="100" class="small-img" />
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image2']; ?>" width="100" class="small-img" />
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image3']; ?>" width="100" class="small-img" />
                    </div>
                    <div class="small-img-col">
                        <img src="assets/imgs/<?php echo $row['product_image4']; ?>" width="100" class="small-img" />
                    </div>
                </div>
            </div>

           


            <div class="col-lg-6 col-md-12 col-12">
               
                <h3 class="py-4"> <?php echo $row['product_name']; ?> </h3>
                <h2>$<?php echo $row['product_price'];?></h2>

                <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>

                <input type="number" name="product_quantity" value="1"/>
                <button class="buy-btn" type="submit" name="add_to_cart" >ADD TO CART</button>
                </form>

                 
                <h4 class="mt-5 mb-5">PRODUCT DETAILS</h4>
                <span>  <?php echo $row['product_description']; ?>  </span>
            </div> 
            
            <a href="index.php"><img src="" class="img-fluid w-auto h-auto m-5"><button>BACK TO MAIN PAGE</button></a>
         <?php } ?>

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
                        </ddiv>
                    </div>
                </div>
            </div>

            <div class="copyright mt-5">
                <div class="row container mx-auto">
                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                        <img src="assets/imgs/paymentVisa.png" alt="">
                    </div>

                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                        <p>eCommerce CHRIS ROCCO All Rights Reserved JUNE 2023</p>
                    </div>

                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-skype"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div id="move-to-top" class="scrollToTop filling">
                <a href="single_product.html"><i class="fa fa-chevron-up"></i></a>
            </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <script>
        var mainImg = document.getElementById("mainImg");
        var smallImg = document.getElementsByClassName("small-img");
        for (let i = 0; i < 4; i++) {
            smallImg[i].onclick = function() {
                mainImg.src = smallImg[i].src;
            }
        }
    </script>

</body>

</html>