<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $product_quantity = $_POST['product_quantity'];

    // Check if the quantity is a valid number and not negative
    if (!is_numeric($product_quantity) || $product_quantity <= 0) {
        echo '<script>alert("Invalid quantity. Please enter a positive number.");</script>';
        echo '<script>window.location="index.php";</script>';
        exit; // Prevent adding the product
    }

    // If the user has already added a product to the cart
    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");
        
        // Check if the product has already been added to the cart or not
        if (!in_array($_POST['product_id'], $products_array_ids)) {
            $product_id = $_POST['product_id'];

            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );

            $_SESSION['cart'][$product_id] = $product_array;

            // Product has already been added
        } else {
            echo '<script>alert("Product was already added to cart");</script>';
            echo '<script>window.location="index.php";</script>';
        }

    // If this is the first product
    } else {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];

        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'product_quantity' => $product_quantity
        );

        $_SESSION['cart'][$product_id] = $product_array;
    }

    // Calculate total
    calculateTotalCart();

} else if (isset($_POST['remove_product'])) {

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);

    // Calculate total
    calculateTotalCart();

} else if (isset($_POST['edit_quantity'])) {

    // Get id and quantity from the product
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    // Check if the quantity is a valid non-negative number
    if (!is_numeric($product_quantity) || $product_quantity < 1) {
        echo '<script>alert("Invalid quantity. Please enter a positive number.");</script>';
        echo '<script>window.location="cart.php";</script>';
        exit; // Prevent updating the quantity to 0 or a negative number
    }

    // Get the product array from the session
    $product_array = $_SESSION['cart'][$product_id];

    // Update the product quantity
    $product_array['product_quantity'] = $product_quantity;

    // Return the array back to its place
    $_SESSION['cart'][$product_id] = $product_array;

    // Calculate total
    calculateTotalCart();

} else {
    // header('location: index.php'); // User can now enter cart.php
}

function calculateTotalCart() {

    $total = 0;

    foreach ($_SESSION['cart'] as $key => $value) {

        $product = $_SESSION['cart'][$key];

        $price = $product['product_price'];
        $quantity = $product['product_quantity'];

        $total = $total + ($price * $quantity);
    }

    $_SESSION['total'] = $total;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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

    <!-- CART -->

    <section class="cart container my-5 py-5">
        <div class="container mt-5">
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
            <h2 class="font-weight-bold">YOUR CART</h2>
            <hr>
        </div>
        <table class="mt-5 pt-5">

            <tr>
                <th>PRODUCT</th>
                <th>QUANTITY</th>
                <th>SUBTOTAL</th>
            </tr>
         
       
        
            <?php if(isset($_SESSION['cart']) && is_array($_SESSION['cart'])): ?>
                <?php foreach ($_SESSION['cart'] as $key => $value): ?>
                    <?php if(!empty($value['product_name']) && !empty($value['product_price']) && !empty($value['product_image'])){ ?>
                        <tr>
                            <td>
                                <div class="product-info">
                                    <img src="assets/imgs/<?php echo $value['product_image'];?>"/>
                                        <div>
                                            <p> <?php echo $value['product_name'];?> </p>
                                            <small> <span>$</span><?php echo $value['product_price'];?></small>
                                            <br>
                                            <br>
                                            <form method="POST" action="cart.php">
                                                <input type="hidden" name="product_id"  value="<?php echo $value['product_id'];?>"/>
                                                <input type="submit" name="remove_product" class="remove-btn" value="REMOVE"/>
                                            </form>   
                                        </div>
                                    </div>
                                </td>

                                    <td>
                                        
                                        <form method="POST" action="cart.php">
                                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'];?>"/>
                                            <input type="number"  name="product_quantity"  value="<?php echo $value['product_quantity'];?>"/>
                                            <input type="submit" class="edit-btn" value="EDIT" name="edit_quantity"/>
                                        </form>
                                        
                                </td>

                                    <td>
                                        <span class="product-price">$ <?php echo $value['product_quantity']* $value ['product_price'];?></span>
                                    </td>
                        </tr>
                        <?php } ?>
                <?php endforeach; ?>
            <?php endif; ?>

        
        </table>

        <div class="cart-total">
            <table>
              <?php if(isset($_SESSION['cart'])): ?>
                <tr>
                    <td>TOTAL</td>
                    <td>$ <?php echo $_SESSION['total'];?></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>



        <div class="checkout-container">
               <?php if(isset($_SESSION['total']) && $_SESSION['total'] != null): ?>                            <!--tu se nalazila 3. greška -->
                    <form method="GET" action="checkout.php">
                    <input type="submit" class="btn checkout-btn" value="checkout" name="checkout-btn">  
                    </form> 
                <?php else: ?>
                    <?php header("Location: index.php"); ?>
                    
               <?php endif; ?>           
           </div>

           <a href="shop.php"><img src="" class="img-fluid w-auto h-auto m-5"><button>BACK TO SHOP</button></a>
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
            <a href="cart.php"><i class="fa fa-chevron-up"></i></a>
        </div>


    </footer>

    <!-- JS LINK  -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>    
</body>

</html>