<?php
include('server/connection.php');

// Behold the magnificent search section
if (isset($_POST['search'])) {
    $category = $_POST['category'];
    $price = $_POST['price'];
    $color = $_POST['color'];

    // Prepare the SQL statement with color filtering
    if ($color === 'all') {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=?");
        $stmt->bind_param('si', $category, $price);
    } else {
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price=? AND product_color=?");
        $stmt->bind_param('sis', $category, $price, $color);
    }

    $stmt->execute();
    $products = $stmt->get_result();

    // Fear not, for I shall return all the products!
} else {
    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- FONT AWSOME CDN LINK -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <!-- CSS LINK  -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- JQUERY  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
     <!-- JS code for filtering functionality  -->
     <script>
        function searchFunction() {
            var category = document.getElementById("category").value;
            var price = document.getElementById("price").value;
            var color = document.getElementById("color").value;
            var formData = {
                category: category,
                price: price,
                color: color,
            };

            // Use AJAX to fetch filtered products
            $.ajax({
                type: "POST",
                url: "server/get_filtered_products.php", // Update the URL accordingly
                data: formData,
                success: function(response) {
                    // Update the product container with the new product listings
                    $("#products-container").html(response);
                },
                error: function(error) {
                    console.error("Error fetching products: " + error);
                }
            });
        }

        // Reset filters function
        function resetFilters() {
            // Reset filter inputs and fetch all products
            document.getElementById("category").value = "all";
            document.getElementById("price").value = 0;
            document.getElementById("color").value = "all";

            // Use AJAX to fetch all products
            $.ajax({
                type: "POST",
                url: "server/get_filtered_products.php", // Update the URL accordingly
                data: {
                    category: "all",
                    price: 0,
                    color: "all",
                },
                success: function(response) {
                    // Update the product container with all products
                    $("#products-container").html(response);
                },
                error: function(error) {
                    console.error("Error fetching products: " + error);
                }
            });
        }

        // Add an event listener to the "Reset All Filters" button
        document.getElementById("reset-filters-btn").addEventListener("click", resetFilters);
    </script>
    

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
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
 <!-- SEARCH FILTER -->
<section id="featured" class="my-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="search-container">
                    <input type="text" id="search-input" placeholder="Search for products..." oninput="searchFunction()" />
                    <br>
                    <label for="discount">ON DISCOUNT (select a percentage):</label>
                    <input type="range" id="discount" name="discount" min="0" max="100" step="1" value="0">
                    <span id="discount-label">0 %</span>
                    <br>
                    <label for="newArrivals">NEW ARRIVALS :</label>
                    <div class="new-arrivals-options">
                        <input type="checkbox" id="last30Days" name="last30Days">
                        <label for="last30Days">Last 30 Days</label>

                        <input type="checkbox" id="last90Days" name="last90Days">
                        <label for="last90Days">Last 90 Days</label>
                    </div>
                    <br>
                    <label for="sort-by">SORT BY :</label>
                    <select id="sort-by" name="sort-by">
                        <option value="featured">Featured</option>
                        <option value="newest">Newest</option>
                        <option value="highest-rated">Highest rated</option>
                        <option value="most-reviewed">Most reviewed</option>
                        <option value="price-low">Price Low to High</option>
                        <option value="price-high">Price High to Low</option>
                        <!-- Add more sorting options as needed -->
                    </select>
                    <br>
                    <label for="price">PRICES :</label>
                    <br>
                    <input type="range" name="price" id="price" min="0" max="10000" value="0" step="1" oninput="updatePriceRange(this.value)" />
                    <span id="price-range">0 - 10000 Euros</span>
                    <br>
                    <select name="category" id="category">
                        <option value="all">All Categories</option>
                        <option value="coats" id="coats">Coats</option>
                        <option value="shoes">Shoes</option>
                        <option value="watches">Watches</option>
                        <option value="perfumes">Perfumes</option>
                        <option value="bags">Bags</option>
                        <option value="gloves">Gloves</option>
                    </select>
                    <br>
                    <label for="stock-items">In Stock Items</label>
                    <input type="checkbox" id="stock-items" name="stock-items">
                    <label for="sale-items">On Sale Items</label>
                    <input type="checkbox" id="sale-items" name="sale-items">
                    <br>
                    <label for="rating">RATING PRODUCTS :</label>
                    <div class="rating-stars">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5" title="5 stars">5 stars rating</label>

                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4" title="4 stars">4 stars rating</label>

                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3" title="3 stars">3 stars rating</label>

                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2" title="2 stars">2 stars rating</label>

                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1" title="1 star">1 star rating</label>
                    </div>
                    <br>
                    <label for="color">COLORS :</label>
                    <select name="color" id="color">
                        <option value="all">All Colors</option>
                        <option value="red">Red</option>
                        <option value="blue">Blue</option>
                        <option value="green">Green</option>
                        <option value="black">Black</option>
                        <option value="white">White</option>
                         <option value="yellow">Yellow</option>
                        <option value="gray">Gray</option>
                        <option value="brown">Brown</option>
                        <option value="rose">Rose</option>
                        <option value="golden">Golden</option>
                        <option value="silver">Silver</option>
                        <option value="purple">Purple</option>
                    </select>
                    <br>
                    <label for="size">ALL SIZES :</label>
                    <select name="size" id="size">
                        <option value="All">All Sizes</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="XL">XL</option>
                        <option value="2XL">2XL</option>
                        <option value="3XL">3XL</option>
                        <option value="4XL">4XL</option>
                        <option value="XXL">XXL</option>
                        <option value="XS-S">XS-S</option>
                        <option value="M-L">M-L</option>
                    </select>
                    <br>
                    <label for="tags">TAGS :</label>
                    <form>          
                        <label for="coats">Coats</label>
                        <input type="checkbox" id="coats" name="tags" value="coats">

                        <label for="shoes">Shoes</label>
                        <input type="checkbox" id="shoes" name="tags" value="shoes">

                        <label for="watch">Watches</label>
                        <input type="checkbox" id="watches" name="tags" value="watches">

                        <label for="parfumes">Parfumes</label>
                        <input type="checkbox" id="parfumes" name="tags" value="parfumes">

                        <label for="bags">Bags</label>
                        <input type="checkbox" id="bags" name="tags" value="bags">

                        <label for="gloves">Gloves</label>
                        <input type="checkbox" id="gloves" name="tags" value="gloves">

                        <label for="men">Men</label>
                        <input type="checkbox" id="men" name="tags" value="men">

                        <label for="women">Women</label>
                        <input type="checkbox" id="women" name="tags" value="women">

                        <label for="children">Children</label>
                        <input type="checkbox" id="children" name="tags" value="children">

                        <label for="kids">Kids</label>
                        <input type="checkbox" id="kids" name="tags" value="kids">

                        <label for="boys">Boys</label>
                        <input type="checkbox" id="boys" name="tags" value="boys">

                        <label for="girls">Girls</label>
                        <input type="checkbox" id="girls" name="tags" value="girls">

                        <label for="retro">Retro</label>
                        <input type="checkbox" id="retro" name="tags" value="retro">

                        <label for="modern">Modern</label>
                        <input type="checkbox" id="modern" name="tags" value="modern">

                        <label for="formal">Formal</label>
                        <input type="checkbox" id="formal" name="tags" value="formal">

                        <label for="non-formal">Non Formal</label>
                        <input type="checkbox" id="non-formal" name="tags" value="non-formal">

                        <label for="casual">Casual</label>
                        <input type="checkbox" id="casual" name="tags" value="casual">

                        <label for="sport">Sport</label>
                        <input type="checkbox" id="sport" name="tags" value="sport">
                        <!-- Add other checkbox options here -->
                        <br>
                        <br>
                         <!-- Shop by Theme -->
                        <label for="theme">SHOP BY THEME :</label>
                        <select name="theme" id="theme">
                            <option value="all">All Themes</option>
                            <option value="spring">Spring</option>
                            <option value="modern">Modern</option>
                            <option value="summer">Summer</option>
                            <option value="minimalist">Minimalist</option>
                            <option value="winter">Winter</option>
                            <option value="retro">Retro</option>
                            <option value="autumn">Autumn</option>
                            <option value="holiday">Holiday</option>
                            <!-- Add more theme options as needed -->
                        </select>
                        <br>
                        <button type="submit" name="search" value="search" class="btn btn-primary">Search</button>
                    </form>
                    <!--  Reset Filters button -->
                <button type="button" id="reset-filters-btn" class="btn btn-secondary">Reset All Filters</button>
                </div>
            </div>

            <div class="col-lg-9">
                <hr class="horizontal-line">
                <p id="center-text">HERE YOU CAN CHECK THE PRODUCTS :</p> 
                <hr class="horizontal-line">
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="row" id="products-container">
                    <?php include('server/get_featured_products.php'); ?>
                    <?php while ($row = $featured_products->fetch_assoc()) { ?>
                        <!-- Loop for displaying products -->
                        <div class="product text-center col-lg-4 col-md-6 col-sm-12">
                            <!-- Product content goes here -->
                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                            <div class="star">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                            <h4 class="p-price">$ <?php echo $row['product_price']; ?></h4>
                            <a href="<?php echo "single_product.php?product_id=" . $row['product_id']; ?>"><button class="text-uppercase buy-btn">Buy Now</button></a>
                        </div>
                    <?php } ?>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination mt-5">
                        <!-- Pagination links go here -->
                        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>








    <!-- FOOTER -->
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
            <a href="shop.php"><i class="fa fa-chevron-up"></i></a>
        </div>

            <div class="whatsapp-chat">
            <a href="https://api.whatsapp.com/send?phone=%2B385989200322" target="_blank">
            <img src="assets/imgs/WhatsApp.png" alt="WhatsApp Chat" class="whatsapp-icon">
            <span class="tooltip">Chat with us on WhatsApp<span class="tooltip-arrow"></span></span>
            </a>
            </div>

    </footer>

  
     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


        
</body>

</html>