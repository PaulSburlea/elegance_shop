<?php
// Include fișierul de configurare a bazei de date (db.php)
session_start();
include 'db.php';

// Verifică dacă utilizatorul este autentificat
if (isset($_SESSION['user_id'])) {
    $userId = $con->real_escape_string($_SESSION['user_id']);
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
    <title>Checkout ES</title>

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
                                    <li><a href="contact.php">Contact</a></li>
                                </ul>
                            </li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="img/core-img/heart.svg" alt=""></a>
                </div>

            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->



    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Checkout</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>Billing Address</h5>
                        </div>

                        <form action="process_order.php" method="post">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name">First Name <span>*</span></label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="last_name">Last Name <span>*</span></label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="" required>
        </div>

        <div class="col-12 mb-3">
            <label for="country">Country <span>*</span></label>
            <select class="w-100" id="country" name="country">
    <option value="bgr">Bulgaria</option>
    <option value="fra">France</option>
    <option value="deu">Germany</option>
    <option value="hun">Hungary</option>
    <option value="pol">Poland</option>
    <option value="rou">Romania</option>
    <option value="rus">Russia</option>
    <option value="srb">Serbia</option>
    <option value="svk">Slovakia</option>
    <option value="svn">Slovenia</option>
    <option value="esp">Spain</option>
    <option value="swe">Sweden</option>
    <option value="gbr">United Kingdom</option>
</select>



        </div>
        <div class="col-12 mb-3">
            <label for="street_address">Address <span>*</span></label>
            <input type="text" class="form-control mb-3" id="street_address" name="street_address" value="">
        </div>
        <div class="col-12 mb-3">
            <label for="postcode">Postcode <span>*</span></label>
            <input type="text" class="form-control" id="postcode" name="postcode" value="">
        </div>
        <div class="col-12 mb-3">
            <label for="city">County <span>*</span></label>
            <input type="text" class="form-control" id="city" name="county" value="">
        </div>
        <div class="col-12 mb-3">
            <label for="city">City <span>*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="">
        </div>

        <div class="col-12 mb-3">
            <label for="phone_number">Phone No <span>*</span></label>
            <input type="number" class="form-control" id="phone_number" name="phone_number" min="0" value="">
        </div>
        <div class="col-12 mb-4">
            <label for="email_address">Email Address <span>*</span></label>
            <input type="email" class="form-control" id="email_address" name="email_address" value="">
        </div>

    </div>
    <button type="submit" class="btn essence-btn">Place Order</button>
</form>

                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Your Order</h5>
                            <p>The Details</p>
                        </div>

                        <ul id="order-details-list" class="order-details-form mb-4">
                        <?php

                        // Interogare pentru a obține produsele din coșul de cumpărături ale utilizatorului
                            $cartQuery = "SELECT * FROM shopping_cart WHERE user_id = '$userId'";
                            $cartResult = $con->query($cartQuery);

                            // Inițializează variabila pentru totalul comenzii
                            $totalPrice = 0;

                            if ($cartResult && $cartResult->num_rows > 0) {
                                // Afișează începutul listei
                                echo '<ul id="order-details-list" class="order-details-form mb-4">';

                                // Iterează prin produsele din coș
                                while ($cartItem = $cartResult->fetch_assoc()) {
                                    echo '<li>';
                                    echo '<span>' . $cartItem['product_name'] . '</span> <span>$' . $cartItem['product_price'] . '</span>';
                                    echo '</li>';

                                    // Adaugă prețul produsului la totalul comenzii
                                    $totalPrice += $cartItem['product_price'];
                                }

                                // Afișează subtotalul, taxa de transport și totalul comenzii
                                echo '<li><span>Subtotal</span> <span>$' . number_format($totalPrice, 2) . '</span></li>';
                                echo '<li><span>Shipping</span> <span>Free</span></li>';
                                echo '<li><span>Total</span> <span>$' . number_format($totalPrice, 2) . '</span></li>';

                                // Afișează sfârșitul listei
                                echo '</ul>';
                            } else {
                                // Afișează un mesaj dacă coșul de cumpărături este gol
                                echo '<p>Your cart is empty.</p>';
                            }


                        // Închide conexiunea la baza de date
                        if (isset($con) && $con) {
                            $con->close();
                        }


                        ?>
                        </ul>

                        

                        <div class="col-12">
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Checkout Area End ##### -->












    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <!-- <a href="#"><img src="img/core-img/logo2.png" alt=""></a> -->
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.php">Shop</a></li>
                                <li><a href="blog.php">Blog</a></li>
                                <li><a href="contact.php">Contact</a></li>
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