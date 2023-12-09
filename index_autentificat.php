<?php
session_start();


include 'db.php';

// Verifică dacă utilizatorul nu este autentificat
if (!isset($_SESSION['user_id']) || !isset($_SESSION['authenticated'])) {
    // Dacă nu este autentificat, redirecționează către pagina pentru utilizatori neautentificați
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$query = "SELECT * FROM users WHERE username = '$username'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $is_admin = $user['is_admin'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Elegance Shop</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon1.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">


</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.php"><img src="img/core-img/logo_alb.png" alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                                                <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                        <li><a href="#">Shop</a>
                            <div class="megamenu">
                                <ul class="single-mega cn-col-4">
                                    <li class="title">Women's Collection</li>
                                    <li><a href="shop.php?subcategory=dresses">Dresses</a></li>
                                    <li><a href="shop.php?subcategory=tops_blouses">Tops &amp; Blouses</a></li>
                                    <li><a href="shop.php?subcategory=jeans">Jeans</a></li>
                                </ul>
                                <ul class="single-mega cn-col-4">
                                    <li class="title">Men's Collection</li>
                                    <li><a href="shop.php?subcategory=t-shirts">T-Shirts</a></li>
                                    <li><a href="shop.php?subcategory=hoodies">Hoodies</a></li>
                                    <li><a href="shop.php?subcategory=pants">Pants</a></li>
                                </ul>
                                <div class="single-mega cn-col-4">
                                    <img src="img/bg-img/bg-6.jpg" alt="">
                                </div>
                            </div>
                        </li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="shop.php">Shop</a></li>
                                </ul>
                            </li>
                            <?php if (isset($username)): ?>
                                <span style="border-left: 1px solid #ccc; height: 20px; margin: 0 10px;"></span> <!-- Separator vertical -->
                                <li>
                                    <a href="#"><?php echo "Hello, $username!"; ?></a>
                                    <ul class="dropdown">
                                        <li><a href="settings.php">Settings</a></li>
                                        <li><a href="my_orders.php">My Orders</a></li>
                                    </ul>
                                </li>
                                <?php if ($is_admin): ?>
                                    <span style="border-left: 1px solid #ccc; height: 20px; margin: 0 10px;"></span> <!-- Separator vertical -->
                                    <li>
                                        <a href="#">Dashboard</a>
                                        <ul class="dropdown">
                                            <li><a href="dashboard.php">Add Products</a></li>
                                            <li><a href="admin_orders.php">Manage Orders</a></li>
                                    </ul>

                                    </li>
                                <?php endif; ?>


                            <?php endif; ?>

                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">

                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="favourite.php"><img src="img/core-img/heart.svg" alt=""></a>
                </div>
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="img/core-img/bag.svg" alt=""> </a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<div class="right-side-cart-area">

    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart"><img src="img/core-img/bag.svg" alt=""></a>
    </div>

    <div class="cart-content d-flex">

        <!-- Cart List Area -->
        <div class="cart-list">
            <?php
            // Înlocuiți acest cod cu interogarea reală pentru a obține produsele din tabela shopping_cart
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $query = "SELECT * FROM shopping_cart WHERE user_id = $userId";
            } else {
                // Poți gestiona altfel situația în care nu ești sigur că utilizatorul este autentificat
                // De exemplu, poți redirecționa utilizatorul la pagina de autentificare sau afișa un mesaj
                echo "User not authenticated.";
                exit(); // Ieși din script pentru a evita afișarea coșului pentru un utilizator neautentificat
            }
                        $result = $con->query($query);

            $totalPrice = 0;

            // Afișare produse în coșul de cumpărături și calculul sumei totale
            while ($row = $result->fetch_assoc()) {
                echo '<div class="single-cart-item" id="cart-item-' . $row["id"] . '">';
                echo '<a href="#" class="product-image">';
                // Afișează imaginea produsului
                echo '<img src="' . $row["imagine"] . '" class="cart-thumb" alt="">';
                echo '<div class="cart-item-desc">';
                echo '<span class="product-remove" onclick="removeCartItem(' . $row["id"] . ')"><i class="fa fa-close" aria-hidden="true"></i></span>';
                echo '<h6>' . $row["product_name"] . '</h6>';
                echo '<p class="price">$' . $row["product_price"] . '</p>';
                echo '</div></a></div>';
            
                // Adaugă prețul produsului la suma totală
                $totalPrice += $row["product_price"];
            }
            ?>
        </div>

<!-- Cart Summary -->
<div class="cart-amount-summary">
    <h2>Summary</h2>
    <ul class="summary-table">
        <li><span>subtotal:</span> <span>$<?php echo number_format($totalPrice, 2); ?></span></li>
        <li><span>delivery:</span> <span>Free</span></li>
        <li><span>total:</span> <span>$<?php echo number_format($totalPrice, 2); ?></span></li>
    </ul>
    <div class="checkout-btn mt-100">
        <a href="checkout.php" class="btn essence-btn">check out</a>
    </div>
</div>

    </div>
</div>
<!-- ##### Right Side Cart End ##### -->


<script>
function removeCartItem(productId) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Răspunsul de la server
                console.log(xhr.responseText);

                // Elimină elementul din DOM
                var cartItem = document.getElementById('cart-item-' + productId);
                cartItem.parentNode.removeChild(cartItem);
            } else {
                console.error('Eroare la comunicarea cu serverul.');
            }
        }
    };

    // Definiți metoda și URL-ul pentru cerere (înlocuiți 'remove_from_cart.php' cu numele real al scriptului PHP)
    xhr.open('POST', 'remove_from_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Trimiteți datele către server
    xhr.send('product_id=' + encodeURIComponent(productId));
}
</script>

    <!-- ##### Welcome Area Start ##### -->
    <section class="welcome_area bg-img background-overlay" style="background-image: url(img/bg-img/bg-1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="hero-content">
                        <h2>New Collection</h2>
                        <a href="shop.php" class="btn essence-btn">view collection</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(img/bg-img/bg-2.jpg);">
                        <div class="catagory-content">
                            <a href="shop.php">Clothing</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(img/bg-img/bg-3.jpg);">
                        <div class="catagory-content">
                            <a href="shop.php">Shoes</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img" style="background-image: url(img/bg-img/bg-4.jpg);">
                        <div class="catagory-content">
                            <a href="shop.php">Accessories</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### CTA Area Start ##### -->
    <div class="cta-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content bg-img background-overlay" style="background-image: url(img/bg-img/bg-5.jpg);">
                        <div class="h-100 d-flex align-items-center justify-content-end">
                            <div class="cta--text">
                                <h6>-60%</h6>
                                <h2>Global Sale</h2>
                                <a href="shop.php" class="btn essence-btn">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### CTA Area End ##### -->

<!-- ##### New Arrivals Area Start ##### -->
<section class="new_arrivals_area section-padding-80 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Popular Products</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="popular-products-slides owl-carousel">

                    <?php
                    // Loop pentru a obține produsele din baza de date și a le afișa
                    $sql = "SELECT * FROM products LIMIT 4"; // Modificați această interogare pentru a se potrivi cu structura dvs. de baza de date

                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Afiseaza produsele
                            ?>
                            <div class="single-product-wrapper">
                                <div class="product-img">
                                    <img src="<?php echo $row['imagine_cale']; ?>" alt="">
                                    <div class="product-favourite">
                                        <a href="#" class="favme fa fa-heart"></a>
                                    </div>
                                </div>
                                <div class="product-description">
                                        <h6><?php echo $row['nume']; ?></h6>
                                    </a>
                                    <p class="product-price">$<?php echo $row['pret']; ?></p>
                                    <div class="hover-content">
                                        <div class="add-to-cart-btn">
                                            <a href="#" class="btn essence-btn">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Nu există produse în baza de date.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### New Arrivals Area End ##### -->


    <!-- ##### Brands Area Start ##### -->
    <div class="brands-area d-flex align-items-center justify-content-between">
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand1.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand2.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand3.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand4.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand5.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="img/core-img/brand6.png" alt="">
        </div>
    </div>
    <!-- ##### Brands Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="img/core-img/logo_negru.png" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.php">Shop</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="https://www.facebook.com/" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="https://www.instagram.com/" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="https://twitter.com/home" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="https://www.pinterest.com/" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="https://www.youtube.com/" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

<div class="row mt-5">
                <div class="col-md-12 text-center">
                    
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>