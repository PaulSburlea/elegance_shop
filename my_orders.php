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
$ordersQuery = "SELECT * FROM orderss WHERE user_id = '$userId' ORDER BY order_id DESC";
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
        font-family: 'Montserrat', sans-serif; /* Adaugă fonta Montserrat */
        line-height: 1.6;
        background-color: white;
        padding: 20px;
        margin: 0;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .order-container {
        max-width: 800px;
        margin: 0 auto;
        margin-top: 30px;
    }

    .order {
        margin-bottom: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .product-list {
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 15px;
        border-top: 1px solid #ddd;
    }

    .product {
        display: block;
        margin-bottom: 8px;
    }

    .order-status {
        font-weight: bold;
        margin-top: 10px;
        padding: 15px;
        background-color: #f2f2f2;
    }

    .page-title {
        font-family: 'Montserrat', sans-serif; /* Adaugă fonta Montserrat */
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin: 20px 0;
    }

    .order-container {
        max-width: 800px;
        margin: 0 auto;
        margin-top: 30px;
    }

.processing {
    color: blue; /* culoarea textului pentru starea 'Processing' */
}

.shipped {
    color: blueviolet; /* culoarea textului pentru starea 'Shipped' */
}

.delivered {
    color: green; /* culoarea textului pentru starea 'Delivered' */
}

.cancelled {
    color: red; /* culoarea textului pentru starea 'Cancelled' */
}

</style>

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
</head>
<body>

<header class="header_area">
    <div>
        <a href="index.php">Home</a>
        <a href="contact.php">Contact</a>
    </div>
</header>
<h1 class="page-title">My Orders</h1>

<div class="order-container">
    <?php
    if ($ordersResult && $ordersResult->num_rows > 0) {
        echo '<div class="table-title">My Orders</div>';
        echo '<table>';
        echo '<tr>';
        echo '<th>Order ID</th>';
        echo '<th>Products</th>';
        echo '<th>Total Price</th>';
        echo '<th>Order Date</th>';
        echo '<th>Order Status</th>';
        echo '</tr>';

        while ($order = $ordersResult->fetch_assoc()) {
            echo '<tr class="order">';
            
            // Informații despre comandă
            echo '<td>#' . $order['order_id'] . '</td>';

            // Lista de produse
            echo '<td class="product-list">';
            $orderId = $order['order_id'];
            $productsQuery = "SELECT * FROM order_items WHERE order_id = '$orderId'";
            $productsResult = $con->query($productsQuery);

            if ($productsResult && $productsResult->num_rows > 0) {
                while ($product = $productsResult->fetch_assoc()) {
                    echo '<p class="product">' . $product['product_name'] . ' - $' . $product['product_price'] . '</p>';
                }
            } else {
                echo '<p>No products found for this order.</p>';
            }
            echo '</td>';

            // Total Price
            echo '<td>$' . $order['total_price'] . '</td>';

            // Order Date - utilizează funcția DATE() pentru a afișa doar data
            echo '<td>' . date('Y-m-d', strtotime($order['order_date'])) . '</td>';

// Starea comenzii
$orderStatusClass = '';
switch ($order['order_status']) {
    case 'Processing':
        $orderStatusClass = 'processing';
        break;
    case 'Shipped':
        $orderStatusClass = 'shipped';
        break;
    case 'Delivered':
        $orderStatusClass = 'delivered';
        break;
    case 'Cancelled':
        $orderStatusClass = 'cancelled';
        break;
    default:
        $orderStatusClass = '';
}

echo '<td class="order-status ' . $orderStatusClass . '">' . $order['order_status'] . '</td>';

        }

        echo '</table>';
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
