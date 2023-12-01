<?php
session_start();
include_once 'db.php'; // Asigură-te că ai un fișier cu configurația bazei de date


$countryAbbreviations = array(
    'bgr' => 'Bulgaria',
    'fra' => 'France',
    'deu' => 'Germany',
    'hun' => 'Hungary',
    'pol' => 'Poland',
    'rou' => 'Romania',
    'rus' => 'Russia',
    'srb' => 'Serbia',
    'svk' => 'Slovakia',
    'svn' => 'Slovenia',
    'esp' => 'Spain',
    'swe' => 'Sweden',
    'gbr' => 'United Kingdom',
);


// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirecționează către pagina de autentificare dacă utilizatorul nu este autentificat
    exit();
}

// Obține ID-ul utilizatorului autentificat
$userId = $_SESSION['user_id'];

// Interogare pentru a obține toate comenzile utilizatorului
$ordersQuery = "SELECT * FROM orderss WHERE user_id = '$userId'";
$ordersResult = $con->query($ordersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/core-img/favicon1.ico">
    <link rel="stylesheet" href="css/core-style.css">
    <title>My Orders</title>


<style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        background-color: #f4f4f4;
        display: grid;
        gap: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .user-container,
    .products-container,
    .status-container {
        padding: 20px;
        border-bottom: 1px solid #ddd;
    }

    .user-container {
        grid-column: 1; /* Afișează în prima coloană */
    }

    .products-container {
        grid-column: 2; /* Afișează în a doua coloană */
    }

    .card-title {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>

</head>
<body>

<div class="container">
    <?php
    if ($ordersResult && $ordersResult->num_rows > 0) {
        while ($order = $ordersResult->fetch_assoc()) {
            // Afișează detalii despre comandă
            echo '<div class="card">';
            
            // Container pentru informații despre utilizator
            echo '<div class="user-container">';
            echo '<p class="card-title">Order ID: ' . $order['order_id'] . '</p>';
            echo '<p class="card-text">Name: ' . $order['first_name'] . ' ' . $order['last_name'] . '</p>';
            echo '<p class="card-text">Email: ' . $order['email_address'] . '</p>';
            $countryAbbreviation = strtolower($order['country']);
            $countryFullName = isset($countryAbbreviations[$countryAbbreviation]) ? $countryAbbreviations[$countryAbbreviation] : $order['country'];
            echo '<p class="card-text">Address: ' . $countryFullName . ', ' . $order['street_address'] . ', ' . $order['postcode'] . ', ' . $order['city'] . ', ' . $order['county'] . '</p>';
            echo '<p class="card-text">Phone Number: ' . $order['phone_number'] . '</p>';
            echo '<p class="card-text">Total Price: $' . $order['total_price'] . '</p>';
            echo '</div>';

            
            // Container pentru lista de produse
            // Container pentru lista de produse
            echo '<div class="products-container">';
            echo '<p class="card-title">Product List</p>';

            // Obține lista de produse pentru comanda curentă
            $orderId = $order['order_id'];
            $productsQuery = "SELECT * FROM order_items WHERE order_id = '$orderId'";
            $productsResult = $con->query($productsQuery);

            if ($productsResult && $productsResult->num_rows > 0) {
                while ($product = $productsResult->fetch_assoc()) {
                    echo '<p class="card-text">' . $product['product_name'] . ' - $' . $product['product_price'] . '</p>';
                }
            } else {
                echo '<p>No products found for this order.</p>';
            }

            echo '</div>';
            
            // Container pentru Order Status
            echo '<div class="status-container">';
            echo '<p class="card-title">Order Status</p>';
            echo '<p><strong>' . $order['order_status'] . '</strong></p>';
            echo '</div>';

            echo '</div>'; // .card
        }
    } else {
        echo '<p>No orders found.</p>';
    }
    ?>
</div>





<!-- Adaugă codul pentru subsol, așa cum este în fișierul original -->


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



</body>
</html>
