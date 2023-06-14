<?php
include('server/connection.php');

// Behold the magnificent search section
if (isset($_POST['search'])) {

    $category = $_POST['category'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_category=? AND product_price<=");

    $stmt->bind_param('si', $category, $price);

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

    
   



    <!-- Featured products / SHOP -->

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    

    <section id="featured" class="my-5 py-5">
    <div class="container mt-5 py-5">
        <h2>OUR PRODUCTS & SHOP </h2>
         <!-- SEARCH BAR -->
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Search for clothes, shoes, perfumes..." oninput="searchFunction()" />
            <span class="search-icon">&#128269;</span>
            <div id="search-results" class="search-results"></div>
        </div>
        <br>
        <br>
        <!-- FILTERS -->
        <div class="filter-container">

            <!-- Price Filter -->
            <label for="price-range">Price range:</label>
            <input type="range" id="price-range" name="price-range" min="0" max="10000" value="0">
            <span id="price-output">0</span> €

            <!-- Color Filter -->
            <label for="color-filter">Color:</label>
            <select id="color-filter" onchange="searchFunction()">
                <option value="">All Colors</option>
                <option value="red">Red</option>
                <option value="blue">Blue</option>
                <option value="green">Green</option>
                <option value="yellow">Yellow</option>
                <option value="orange">Orange</option>
                <option value="purple">Purple</option>
                <option value="pink">Pink</option>
                <option value="brown">Brown</option>
                <option value="gray">Gray</option>
                <option value="black">Black</option>
                <option value="white">White</option>
                <!-- Add more colors as needed -->
            </select>

            <!-- Stock Filter -->
            <label for="stock-filter">Availability:</label>
            <select id="stock-filter" onchange="searchFunction()">
                <option value="">All</option>
                <option value="in-stock">In Stock</option>
                <option value="out-of-stock">Out of Stock</option>
            </select>

            <!-- Category Filter -->
            <label for="category-filter">Category:</label>
            <select id="category-filter" onchange="searchFunction()">
                <option value="">All Categories</option>
                <option value="watches">Watches</option>
                <option value="bags">Bags</option>
                <option value="gloves">Gloves</option>
                <option value="vintage-suits">Vintage Suits</option>
                <option value="perfumes">Perfumes</option>
                <option value="shoes">Shoes</option>
            </select>
        </div>
        <br>
        <br>
        <button type="submit" onclick="searchFunction()">Search</button>  <!-- Search Button -->
    </div>
</section>


        <hr class="horizontal-line">
        <p id="center-text">HERE YOU CAN CHECK THE PRODUCTS...</p>
       
        <div class="row mx-auto container-fluid">

        <div class="row mx-auto container-fluid">

        

            <?php include('server/get_featured_products.php');  ?>
            

            <?php while ($row = $featured_products->fetch_assoc()) { ?>       

                

            <!-- Loop za sve proizvode -->
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                <div class="star">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
                <h5 class="p-name">  <?php echo $row['product_name']; ?>  </h5>
                <h4 class="p-price">$  <?php echo $row['product_price']; ?>   </h4>
                <a href="<?php echo "single_product.php?product_id=". $row['product_id'];?> "><button class="text-uppercase buy-btn">Buy Now</button></a>
            </div>
            
           <?php } ?>
            
        </div>
            


            <nav aria-label="Page navigation example">

                <ul class="pagination mt-5">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>


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
                    </div>
                </div>
            </div>

            <div class="copyright mt-5">
                <div class="row container mx-auto">
                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
                        <img src="assets/imgs/paymentVisa.png" alt="">
                    </div>

                    <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
                        <p>eCommerce CHRIS ROCCO All Rights Reserved MAY 2023</p>
                    </div>
                </div>
            </div>
            <div id="move-to-top" class="scrollToTop filling">
                <a href="shop.php"><i class="fa fa-chevron-up"></i></a>
            </div>

    </footer>

    <!--JS FOR FILTERING PRODUCTS-->
    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            var query = this.value.toLowerCase();
            var items = document.getElementsByClassName('product');

            for (var i = 0; i < items.length; i++) {
                var item = items[i];
                var title = item.getElementsByTagName('h5')[0].innerText.toLowerCase();

                if (title.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    </script>

    <!--JS FOR FILTERING PRODUCTS 2-->
    <script>
    // Function to filter products based on selected criteria
    function searchFunction() {
        var searchInput = document.getElementById("search-input").value.toLowerCase();
        var priceRange = document.getElementById("price-range").value;
        var colorFilter = document.getElementById("color-filter").value;
        var stockFilter = document.getElementById("stock-filter").value;
        var categoryFilter = document.getElementById("category-filter").value;

        // Now, let's dive into the magnificent world of filtering logic!

        // First, let's gather all the products
        var products = document.getElementsByClassName("product");

        // Next, we'll iterate over each product to determine if it matches the selected criteria
        for (var i = 0; i < products.length; i++) {
            var product = products[i];

            // Extract the relevant information from the product
            var productName = product.getElementsByClassName("p-name")[0].innerText.toLowerCase();
            var productPrice = parseFloat(product.getElementsByClassName("p-price")[0].innerText.replace("$", ""));

            // Let's apply the filters and see if the product deserves to be displayed
            var showProduct =
                productName.includes(searchInput) &&
                productPrice <= priceRange;

            // Time for the color filter! We shall reveal only products of the chosen color.
            if (colorFilter !== "") {
                var productColor = product.dataset.color;
                showProduct = showProduct && productColor === colorFilter;
            }

            // The stock filter demands our attention. We will show products based on their availability.
            if (stockFilter !== "") {
                var productStock = product.dataset.stock;
                showProduct = showProduct && productStock === stockFilter;
            }

            // Lastly, the category filter must not be ignored. Let's unveil products from the desired category.
            if (categoryFilter !== "") {
                var productCategory = product.dataset.category;
                showProduct = showProduct && productCategory === categoryFilter;
            }

            // With all the filters applied, it's time to decide the fate of the product.
            // Shall we display it or shall we hide it? The choice is ours.
            if (showProduct) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        }
    }
</script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>