<?php
session_start();


require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifică dacă utilizatorul este autentificat
    if (!isset($_SESSION['user_id'])) {
        echo 'Utilizatorul nu este autentificat.';
        exit;
    }

    // Obține datele trimise prin POST
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validare rating
    if ($rating < 1 || $rating > 5) {
        echo 'Rating invalid.';
        exit;
    }

    // Adaugă review în baza de date
    $query = "INSERT INTO reviews (id_producs, id_user, rating, comentariu) VALUES ($productId, $userId, $rating, '$comment')";
    $result = $con->query($query);

    if ($result) {
        echo 'Review adăugat cu succes.';
    } else {
        echo 'Eroare la adăugarea review-ului.';
    }
} else {
    echo 'Metoda de acces nepermisă.';
}
?>
