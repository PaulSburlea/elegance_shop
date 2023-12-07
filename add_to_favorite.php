<?php
session_start();

include 'db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// Verifică dacă primiți date prin metoda POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preiați datele din cerere
    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];

    if ($userId) {
        // Verificați dacă produsul există deja în favorite pentru același utilizator și același produs
        $checkQuery = "SELECT * FROM favorites WHERE user_id = $userId AND product_id = $productId";
        $checkResult = $con->query($checkQuery);

        if ($checkResult) {
            if ($checkResult->num_rows > 0) {
                // Produsul există deja în favorite, nu este nevoie de acțiuni suplimentare
                $response = array('success' => false, 'message' => 'Product already in favorites!');
                echo json_encode($response);
            } else {
                // Produsul nu există în favorite, adăugați-l
                $insertQuery = "INSERT INTO favorites (user_id, product_id, product_name, product_price, product_image_path)
                                VALUES ($userId, $productId, '$productName', $productPrice, '$productImage')";
                $con->query($insertQuery);

                $response = array('success' => true, 'message' => 'Product added to favorites successfully!');
                echo json_encode($response);
            }
        } else {
            $response = array('success' => false, 'message' => 'Error executing query: ' . $con->error);
            echo json_encode($response);
        }
    } else {
        $response = array('success' => false, 'message' => 'User not logged in!');
        echo json_encode($response);
    }
} else {
    // Răspuns pentru cererile care nu sunt de tip POST
    http_response_code(405);
    $response = array('success' => false, 'message' => 'Method Not Allowed');
    echo json_encode($response);
}

// Închideți conexiunea la baza de date
if (isset($con) && $con) {
    $con->close();
}
?>
