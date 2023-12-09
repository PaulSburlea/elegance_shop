<?php
session_start();

include 'db.php';


// Adaugă produs în coș
if (isset($_POST['addtocart'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['addtocart']);

    // Verifică dacă produsul există deja în coș
    if (!isset($_SESSION['cart'][$product_id])) {
        // Adaugă produsul în coș cu o cantitate inițială de 1
        $_SESSION['cart'][$product_id] = 1;
    } else {
        // Dacă produsul există deja în coș, incrementează cantitatea
        $_SESSION['cart'][$product_id]++;
    }
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
    <title>Product Details ES</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon1.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="review.css">



    <style>
    .add-to-cart-btn {
        text-align: center;
    }

    .add-to-cart-btn button {
        background-color: #ff4f00;
        color: #fff;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        border-radius: 5px;
    }

    .add-to-cart-btn button:hover {
        background-color: #fff;
        color: #ff4f00;
        border: 1px solid #ff4f00;
    }









/* Stilizare pentru pop-up-ul de recenzii */
.reviews-popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.reviews-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    padding: 20px;
    max-width: 1000px;
    max-height: 900px;;
    width: 100%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
    font-size: 20px;
    color: #333;
}

/* Stilizare pentru containerul de recenzii */
.reviews-container {
    max-height: 300px;
    overflow-y: auto;
}

.review {
    border-bottom: 1px solid #ccc;
    padding: 10px 0;
}

.reviewer {
    font-weight: bold;
}

.review-text {
    margin-top: 5px;
}

.review-date {
    color: #888;
}





</style>

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
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="img/core-img/bag.svg" alt=""></a>
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


    <?php
// Verificați dacă a fost furnizat un ID valid în parametrul URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Includeți fișierul de conectare la baza de date
    // Înlocuiți "db_connection.php" cu numele real al fișierului
    require_once('db.php');

    // Evitați injecția SQL folosind prepared statements
    $product_id = mysqli_real_escape_string($con, $_GET['id']);
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $con->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Afișați detaliile produsului
            $product_name = $row['nume'];
            $product_description = $row['descriere'];
            $product_price = $row['pret'];
            $product_stock = $row['stoc'];
            $product_image = $row['imagine_cale'];
        } else {
            // Produsul nu a fost găsit în baza de date
            echo "Produsul nu a fost găsit.";
            exit;
        }
    } else {
        // Eroare la interogare
        echo "Eroare la interogare: " . $con->error;
        exit;
    }
} else {
    // ID invalid sau lipsă în parametrul URL
    echo "ID produs lipsă sau invalid.";
    exit;
}
?>

<!-- ##### Single Product Details Area Start ##### -->
<section class="single_product_details_area d-flex align-items-center">
        <!-- Single Product Thumb -->
        <div class="single_product_thumb clearfix">
        <!-- Verificați dacă variabila $product_image conține o valoare validă -->
        <?php if (!empty($product_image)): ?>
            <img src="<?php echo $product_image; ?>" alt="Product Image" style="max-width: 830px; max-height: 930px;">
        <?php else: ?>
            <!-- Imaginea nu este disponibilă -->
            <p>Imagine indisponibilă</p>
        <?php endif; ?>
    </div>

<!-- Single Product Description -->
<div class="single_product_desc clearfix">
    <span><?php echo $product_name; ?></span>
    <h2><?php echo $product_name; ?></h2>
    <p class="product-price">$<?php echo $product_price; ?></p>
    <p class="product-desc"><?php echo nl2br($product_description); ?></p>

    <?php
    // Afișați dacă produsul este sau nu în stoc
    if ($product_stock > 0) {
        echo "<p class='product-stock'>Available in stock</p>";
    } else {
        echo "<p class='product-stock out-of-stock'></p>";
    }

    // Calculați și afișați ratingul mediu pentru produs
    $averageRating = getProductAverageRating($product_id);
    if ($averageRating !== null) {
        echo '<p>Rating: ' . number_format($averageRating, 2, '.', '') . '★' . '</p>';
    } else {
        echo '<p>This product has no reviews yet.</p>';
    }
    ?>

    <!-- Form -->
    <form class="cart-form clearfix" method="post">
        <!-- Cart & Favourite Box -->
        <div class="cart-fav-box d-flex align-items-center">
            <?php if ($product_stock > 0) : ?>
                <!-- Cart -->
                <div class="add-to-cart-btn">
                    <button onclick="addToCart(this)"
                            data-product-id="<?php echo $row['id']; ?>"
                            data-product-name="<?php echo $row['nume']; ?>"
                            data-product-price="<?php echo $row['pret']; ?>"
                            data-product-image="<?php echo $row['imagine_cale']; ?>">
                            Add to cart
                    </button>
                </div>
            <?php else : ?>
                <!-- Not in Stock -->
                <p class="product-stock out-of-stock">Not available in stock</p>
            <?php endif; ?>

            <!-- Reviews Button -->
            <div class="reviews-button ml-4">
                <button onclick="openReviewsPopup();return false">Reviews</button>
            </div>
        </div>
    </form>

    <!-- Right Side Reviews Popup Area -->
    <div id="reviewsPopup" class="reviews-popup" style="display: none;">
        <div class="reviews-content">
            <span class="close" onclick="closeReviewsPopup()">&times;</span>
            <h2>Reviews for <?php echo $product_name; ?></h2>
            <div id="reviewsContainer" class="reviews-container">
                <!-- Aici vor fi afișate recenziile -->
            </div>

            <!-- Formular pentru adăugarea de recenzii -->
            <?php if (isset($_SESSION['user_id'])) : ?>
                <form id="addReviewForm">
                    <div class="rating-container">
                        <label for="rating">Rating:</label>
                        <!-- Adăugare container pentru rating sub formă de stele -->
                        <div id="starRating" class="star-rating">
                            <input type="radio" id="star5" name="rating" value="5" />
                            <label for="star5" title="5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" />
                            <label for="star4" title="4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" />
                            <label for="star3" title="3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" />
                            <label for="star2" title="2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" />
                            <label for="star1" title="1 star"></label>
                        </div>
                        <!-- Sfârșitul containerului pentru rating sub formă de stele -->
                    </div>

                    <!-- Caseta pentru comentariu -->
                    <div class="comment-container">
                        <label for="comment">Comment:</label>
                        <textarea id="comment" name="comment" required></textarea>
                    </div>

                    <!-- Buton pentru adăugarea review-ului -->
                    <button type="button" onclick="addReview()">Add Review</button>
                </form>
            <?php else : ?>
                <p>Autentifică-te pentru a adăuga un review.</p>
            <?php endif; ?>
        </div>
    </div>
</div>





    </div>
</section>




<?php

// Funcția primește un id de produs și realizează o interogare pentru a obține ratingurile recenziilor respective
function getProductAverageRating($productId) {
    global $con;

    // Realizați o interogare a bazei de date pentru a obține ratingurile recenziilor pentru produsul dat
    $query = "SELECT AVG(rating) AS averageRating FROM reviews WHERE id_producs = $productId";
    $result = $con->query($query);

    // Verificați dacă interogarea a avut succes
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['averageRating'];
    } else {
        // Tratați cazul în care interogarea a eșuat
        return null;
    }
}

?>




<script>
function addToCart(button) {
    var productId = button.getAttribute('data-product-id');
    var productName = button.getAttribute('data-product-name');
    var productPrice = button.getAttribute('data-product-price');
    var productImage = button.getAttribute('data-product-image');

    // Trimite datele la server utilizând AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Răspunsul de la server
                console.log(xhr.responseText);

                // Actualizează conținutul coșului sau alte elemente pe care dorești să le actualizezi
                // Poți implementa această parte în funcție de cum sunt gestionate datele în coș și în pagină

                // Reîncarcă pagina după adăugarea produsului în coș
                window.location.reload();
            } else {
                console.error('Eroare la comunicarea cu serverul.');
            }
        }
    };

    // Definiți metoda și URL-ul pentru cerere
    xhr.open('POST', 'add_to_cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Trimite datele către server
    xhr.send('product_id=' + encodeURIComponent(productId) +
             '&product_name=' + encodeURIComponent(productName) +
             '&product_price=' + encodeURIComponent(productPrice) +
             '&product_image=' + encodeURIComponent(productImage));
}
</script>




<script>
  function openReviewsPopup() {
    // Deschide pop-up-ul
    var reviewsPopup = document.getElementById("reviewsPopup");
    reviewsPopup.style.display = "block";

    // Apelează funcția pentru încărcarea recenziilor dinamic
    loadReviews();
  }

  function closeReviewsPopup() {
    // Închide pop-up-ul
    var reviewsPopup = document.getElementById("reviewsPopup");
    reviewsPopup.style.display = "none";
  }

  function loadReviews() {
    // Obține id-ul produsului și al utilizatorului (înlocuiește cu logica ta pentru a obține aceste id-uri)
    var productId = <?php echo $product_id; ?>;
    var userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

    if (!userId || !productId) {
        console.error('Id-urile utilizatorului și/sau produsului lipsesc.');
        return;
    }

    // Trimite id-urile utilizatorului și produsului la server utilizând AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Răspunsul de la server
                console.log(xhr.responseText);

                // Actualizează conținutul pop-up-ului cu recenzii
                var reviewsContainer = document.getElementById("reviewsContainer");
                reviewsContainer.innerHTML = xhr.responseText;
            } else {
                console.error('Eroare la comunicarea cu serverul.');
            }
        }
    };

    // Definiți metoda și URL-ul pentru cerere (înlocuiți 'load_reviews.php' cu numele real al scriptului PHP)
    xhr.open('POST', 'load_reviews.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Trimite datele către server
    xhr.send('user_id=' + encodeURIComponent(userId) +
        '&product_id=' + encodeURIComponent(productId));
  }

  function addReview() {
    console.log('Funcția addReview() este apelată.');

    // Verifică dacă elementele există
    var ratingElement = document.getElementById('starRating');
    var commentElement = document.getElementById('comment');

    if (!ratingElement || !commentElement) {
        console.error('Elemente inexistente: ratingElement', ratingElement, 'commentElement', commentElement);
        return;
    }

    // Obține valoarea ratingului
    var ratingElement = document.querySelector('input[name="rating"]:checked');
    var rating = ratingElement ? ratingElement.value : null;

    // Obține valoarea comentariului și resetează caseta de comentarii
    var commentElement = document.getElementById('comment');
    var comment = commentElement ? commentElement.value : null;
    commentElement.value = '';  // Resetează conținutul casetei de comentarii

    // Verifică dacă valorile sunt valide
    if (!rating || rating < 1 || rating > 5 || !comment || comment.trim() === '') {
        alert('Te rog completează ratingul și comentariul.');
        return;
    }

    // Trimite datele la server utilizând AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Răspunsul de la server
                console.log(xhr.responseText);

                // Reîncarcă recenziile pentru a afișa și noul review
                loadReviews();
            } else {
                console.error('Eroare la comunicarea cu serverul. Status:', xhr.status, 'Răspuns:', xhr.responseText);
            }
        }
    };

    // Definiți metoda și URL-ul pentru cerere (înlocuiți 'add_review.php' cu numele real al scriptului PHP)
    xhr.open('POST', 'add_review.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Trimite datele către server
    xhr.send(
        'user_id=' + encodeURIComponent(<?php echo $_SESSION['user_id']; ?>) +
        '&product_id=' + encodeURIComponent(<?php echo $product_id; ?>) +
        '&rating=' + encodeURIComponent(rating) +
        '&comment=' + encodeURIComponent(comment)
    );

    // Resetează stelele selectate
    var starInputs = document.querySelectorAll('input[name="rating"]');
    starInputs.forEach(function(input) {
        input.checked = false;
    });
}



</script>












<!-- ##### Single Product Details Area End ##### -->



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
                            <a href="https://twitter.com/home" data-toggle="tooltip" data-placement="top" title="X"><i class="fa fa-twitter" aria-hidden="true"></i></a>
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