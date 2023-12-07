<?php
session_start();
include_once 'db.php';



$ordersQuery = "SELECT * FROM orderss ORDER BY order_id DESC";
$ordersResult = $con->query($ordersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/core-img/favicon1.ico">
    <link rel="stylesheet" href="css/core-style.css">
    <title>Admin Orders</title>

    <style>
body {
    font-family: 'Montserrat', sans-serif;
    line-height: 1.6;
    background-color: white;
    margin: 0;
    text-align: center;
    padding: 20px;
    box-sizing: border-box; /* Adaugat pentru a include padding-ul în lățimea totală */
}

.container {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 20px; /* Adaugat un padding global */
    box-sizing: border-box; /* Adaugat pentru a include padding-ul în lățimea totală */
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    overflow-x: auto;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
    white-space: nowrap;
}

th {
    background-color: #f2f2f2;
}

.order-container {
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
}

.page-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin: 20px 0;
}

/* CSS pentru formularul de actualizare a stării comenzii */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

select {
    margin-bottom: 10px;
    padding: 8px;
    font-size: 16px;
}

button {
    background-color: #4caf50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45a049;
}
    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
</head>
<body>
    <div class="container">
<h1>Manage Orders</h1>
<div class="order-container">
    <?php
    if ($ordersResult && $ordersResult->num_rows > 0) {
        echo '<div class="table-title">All Orders</div>';
        echo '<table>';
        echo '<tr>';
        echo '<th>Order ID</th>';
        echo '<th>Client Name</th>';
        echo '<th>Client Email</th>';
        echo '<th>Client Address</th>'; // Adăugat pentru afișarea adresei
        echo '<th>Client Phone</th>';    // Adăugat pentru afișarea numărului de telefon
        echo '<th>Products</th>';
        echo '<th>Total Price</th>';
        echo '<th>Order Date</th>';
        echo '<th>Order Status</th>';
        echo '</tr>';

        while ($order = $ordersResult->fetch_assoc()) {
            echo '<tr class="order">';
            
            // Informații despre comandă și client
            echo '<td>#' . $order['order_id'] . '</td>';
            echo '<td>' . $order['first_name'] . ' ' . $order['last_name'] . '</td>';

            // Verifică dacă cheia există înainte de a o accesa
            $email = isset($order['email_address']) ? $order['email_address'] : 'N/A';
            echo '<td>' . $email . '</td>';

            // Adresa clientului
            echo '<td>' . $order['street_address'] . ', ' . $order['city'] . ', ' . $order['county'] . ', ' . $order['postcode'] . '</td>';

            // Numărul de telefon al clientului
            echo '<td>' . $order['phone_number'] . '</td>';

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

            // Order Date
            echo '<td>' . date('Y-m-d', strtotime($order['order_date'])) . '</td>';

            // Starea comenzii
            echo '<td class="order-status">';
            echo '<form action="update_order_status.php" method="post">'; // Adaugat un formular pentru a actualiza starea comenzii
            echo '<input type="hidden" name="order_id" value="' . $order['order_id'] . '">'; // Adaugat un câmp ascuns pentru a transmite order_id
            echo '<select name="new_order_status">';
            echo '<option value="Processing" ' . ($order['order_status'] == 'Processing' ? 'selected' : '') . '>Processing</option>';
            echo '<option value="Shipped" ' . ($order['order_status'] == 'Shipped' ? 'selected' : '') . '>Shipped</option>';
            echo '<option value="Delivered" ' . ($order['order_status'] == 'Delivered' ? 'selected' : '') . '>Delivered</option>';
            echo '<option value="Cancelled" ' . ($order['order_status'] == 'Cancelled' ? 'selected' : '') . '>Cancelled</option>';
            echo '</select>';
            echo '<button type="submit">Update</button>';
            echo '</form>';
            echo '</td>';
        }

        echo '</table>';
    } else {
        echo '<p>No orders found.</p>';
    }
    ?>
</div>
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
