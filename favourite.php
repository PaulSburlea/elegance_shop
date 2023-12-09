<!-- favourite.php -->
<?php
session_start();
include_once 'db.php';

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    // Redirectează către pagina de autentificare sau afișează un mesaj
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Obține produsele favorite ale utilizatorului
$favoriteQuery = "SELECT p.* FROM products p
                INNER JOIN favorites f ON p.id = f.product_id
                WHERE f.user_id = '$userId'";
$favoriteResult = $con->query($favoriteQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/core-style.css">
    <title>My Favourites</title>
    <link rel="icon" href="img/core-img/favicon1.ico">

<style>
    /* core-style.css sau adaugă aceste stiluri în interiorul paginii în secțiunea <style> */
body {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.shop_grid_product_area {
    max-width: 800px; /* sau ajustează la dimensiunea dorită */
    margin-top: 20px; /* sau ajustează la distanța dorită între produse */
}

.single-product-area {
    text-align: center;
    margin-bottom: 20px; /* sau ajustează la distanța dorită între produse */
}

.product-img {
    position: relative;
}

.favourite-area {
    position: absolute;
    top: 10px;
    right: 10px;
}




/* Stiluri CSS existente */

.favourite-area {
    position: absolute;
    top: 10px;
    right: 10px;
}

/* Stilizare buton X */
.remove-from-favorite-x {
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
    color: #999; /* Culoarea textului */
    background-color: transparent; /* Fundal transparent */
    border: none;
    padding: 5px;
    font-size: 14px;
    line-height: 1;
    transition: color 0.3s ease;
}

.remove-from-favorite-x:hover {
    color: #333; /* Culoarea textului la hover */
}



</style>
    <!-- Adaugă link-uri către stilurile CSS sau alte fișiere relevante -->
</head>
<body>


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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <!-- Nav End -->
            </div>
        </nav>
    </div>

</header>
    <!-- Adaugă antetul paginii, meniul de navigare, sau alte elemente comune -->
    <!-- Adaugă un titlu pentru produsele favorite -->
    <h2 class="text-center mt-4 mb-4">Favorite Products</h2>

    <!-- Adaugă mesajul de informare -->
    <p class="text-center">Here are your favorite products. Enjoy shopping!</p>
<!-- Afișează produsele favorite -->
<div class="shop_grid_product_area">
    <div class="row">
        <?php
        // Verifică dacă există produse favorite
        if ($favoriteResult && $favoriteResult->num_rows > 0) {
            while ($product = $favoriteResult->fetch_assoc()) {
                // Afisează produsul similar cu shop.php
                ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="single-product-area mb-50">
                        <!-- Adaugă structura HTML pentru un singur produs -->
                        <a href="single-product-details.php?id=<?php echo $product['id']; ?>">
                            <div class="product-img">
                                    <img src="<?php echo $product['imagine_cale']; ?>" alt="">
                                <!-- Adaugă butonul de eliminare din favorite -->
                                <div class="favourite-area">
                                    <a href="#" class="remove-from-favorite" data-product-id="<?php echo $product['id']; ?>">
                                        <img src="img/core-img/heart-filled.svg" alt="">
                                    </a>
                                    <!-- Adaugă simbolul "X" pentru ștergere -->
                                    <a href="#" class="remove-from-favorite-x" data-product-id="<?php echo $product['id']; ?>">
                                        ✖
                                    </a>
                                </div>
                            </div>
                        </a>
                        <div class="product-info mt-15 text-center">
                            <p><?php echo $product['nume']; ?></p>
                            <h6>$<?php echo $product['pret']; ?></h6>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            // Afișează un mesaj dacă nu există produse favorite
            echo '<p class="text-center">No favorite products found.</p>';
        }
        ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selectează toate elementele "X" pentru ștergere din favorite
        var removeButtons = document.querySelectorAll('.remove-from-favorite-x');

        // Adaugă un ascultător de evenimente pentru fiecare buton "X"
        removeButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                // Obține ID-ul produsului din atributul data-product-id
                var productId = button.getAttribute('data-product-id');

                // Trimite solicitarea AJAX pentru ștergerea produsului din favorite
                removeProductFromFavorites(productId);
            });
        });

        // Funcție pentru a trimite solicitarea AJAX pentru ștergerea produsului din favorite
        function removeProductFromFavorites(productId) {
            // Creează un obiect XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configurează solicitarea
            xhr.open('POST', 'remove_from_favorites.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Adaugă un ascultător pentru evenimentul onload (când solicitarea este finalizată)
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Dacă solicitarea a fost reușită, reîncarcă pagina
                    location.reload();
                } else {
                    // Dacă solicitarea a eșuat, afișează un mesaj de eroare
                    console.error('Eroare la ștergerea produsului din favorite.');
                }
            };

            // Adaugă datele pentru a fi trimise cu solicitarea
            var data = 'product_id=' + encodeURIComponent(productId);
            xhr.send(data);
        }
    });
</script>





    <!-- Adaugă subsolul paginii, link-uri către scripturi JavaScript sau alte fișiere relevante -->
</body>

</html>
