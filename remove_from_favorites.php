<?php
session_start();
include_once 'db.php';

// Verifică dacă utilizatorul este autentificat
if (!isset($_SESSION['user_id'])) {
    // Returnează un cod de eroare
    http_response_code(401);
    exit;
}

$userId = $_SESSION['user_id'];

// Verifică dacă este setat parametrul product_id în solicitare
if (!isset($_POST['product_id'])) {
    // Returnează un cod de eroare
    http_response_code(400);
    exit;
}

$productId = $_POST['product_id'];

// Înlătură produsul din lista de favorite a utilizatorului
$removeQuery = "DELETE FROM favorites WHERE user_id = '$userId' AND product_id = '$productId'";
$result = $con->query($removeQuery);

if ($result) {
    // Returnează un cod de succes
    http_response_code(200);
} else {
    // Returnează un cod de eroare
    http_response_code(500);
}

?>
