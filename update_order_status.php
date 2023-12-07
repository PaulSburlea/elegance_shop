<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Title</title>
</head>
<body>



<?php
include_once 'db.php';

require 'PHPMailer.php';
require 'Exception.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifică dacă există un order_id și o nouă stare trimise prin POST
    if (isset($_POST['order_id'], $_POST['new_order_status'])) {
        $order_id = $_POST['order_id'];
        $new_order_status = $_POST['new_order_status'];

        // Actualizează starea comenzii în baza de date
        $updateQuery = "UPDATE orderss SET order_status = '$new_order_status' WHERE order_id = '$order_id'";
        $con->query($updateQuery);

        // Fetch order details
        $orderQuery = "SELECT * FROM orderss WHERE order_id = '$order_id'";
        $orderResult = $con->query($orderQuery);

        if ($orderResult && $orderResult->num_rows > 0) {
            $order = $orderResult->fetch_assoc();

            // Configurare și trimitere email
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";

            try {
                // Configurare server SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp-relay.brevo.com'; // Adresa serverului SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'paulsbrl7@gmail.com'; // Utilizatorul SMTP
                $mail->Password = ''; // Parola SMTP
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Configurare expeditor și destinatar
                $mail->setFrom('paulsbrl7@gmail.com', 'Elegance Shop'); // Adresa și numele expeditorului
                $mail->addAddress($order['email_address'], $order['first_name'] . ' ' . $order['last_name']);

                // Setare subiect și conținut
                $mail->Subject = 'Order Status Update';

                // Setare conținut în funcție de starea comenzii
                switch ($new_order_status) {
                    case 'Shipped':
                        echo "Total Price (in switch): {$order['total_price']} <br>";
                        $mail->Body = "
                            <p>Hello, <strong>{$order['first_name']}</strong>!</p>
                            <p>Your order (#{$order_id}) has been <strong>successfully shipped</strong>.</p>
                            <p>It should arrive within two days. Here are the details of your order:</p>
                            <ul>" . getOrderDetails($con, $order_id) . "</ul>
                            <p><strong>Total Price:</strong> {$order['total_price']} €</p>
                            <p>Thank you for shopping with us!</p>
                            <p>Thank you for choosing <strong>Elegance Shop</strong>!</p>
                        ";
                        break;
                    case 'Delivered':
                        echo "Total Price (in switch): {$order['total_price']} <br>";
                        $mail->Body = "
                            <p>Hello, <strong>{$order['first_name']}</strong>!</p>
                            <p>Your order (#{$order_id}) has been <strong>successfully delivered</strong>. Thank you for your purchase!</p>
                            <p>We hope you enjoy your products. If you have any questions or concerns, please contact us.</p>
                            <ul>" . getOrderDetails($con, $order_id) . "</ul>
                            <p><strong>Total Price:</strong> {$order['total_price']} €</p>
                            <p>Thank you for choosing <strong>Elegance Shop</strong>!</p>
                        ";
                        break;
                    case 'Cancelled':
                        echo "Total Price (in switch): {$order['total_price']} <br>";
                        $mail->Body = "
                            <p>Hello, <strong>{$order['first_name']}</strong>!</p>
                            <p>We regret to inform you that your order (#{$order_id}) has been <strong>cancelled</strong>.</p>
                            <p>Please contact us for further details or assistance. We apologize for any inconvenience.</p>
                            <ul>" . getOrderDetails($con, $order_id) . "</ul>
                            <p><strong>Total Price:</strong> {$order['total_price']} €</p>
                            <p>Thank you for choosing <strong>Elegance Shop</strong>!</p>
                        ";
                        break;
                    default:
                        // Pentru orice altă stare, inclusiv "Processing", nu face nimic
                        $mail->Body = '';
                        break;
                }

                // Setare format HTML
                $mail->isHTML(true);

                // Trimitere email
                $mail->send();
                echo 'Email trimis cu succes.';
            } catch (Exception $e) {
                echo 'Eroare la trimiterea emailului: ' . $mail->ErrorInfo;
            }
        }
    }
}

// Redirecționează înapoi la pagina de administrare a comenzilor
header('Location: admin_orders.php');
exit();

/**
 * Obține detalii despre produsele comenzii sub formă de HTML.
 *
 * @param mysqli $con Conexiunea la baza de date.
 * @param int $order_id ID-ul comenzii.
 * @return string HTML-ul cu detalii despre produsele comenzii.
 */
function getOrderDetails($con, $order_id) {
    $details = "";

    // Interogare pentru a obține detaliile comenzii
    $productsQuery = "SELECT * FROM order_items WHERE order_id = '$order_id'";
    $productsResult = $con->query($productsQuery);

    if ($productsResult && $productsResult->num_rows > 0) {
        while ($product = $productsResult->fetch_assoc()) {
            echo "Product Name: {$product['product_name']} | Price: {$product['product_price']} €<br>";
            $details .= "<li>{$product['product_name']} - Price: {$product['product_price']} €</li>";
        }
        
    } else {
        $details .= "<li>No products found for this order.</li>";
    }

    return $details;
}
?>
