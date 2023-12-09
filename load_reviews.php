<?php
session_start();

// Încarcați configurația bazei de date și inițiați conexiunea
require_once('db.php');

// Verificați dacă au fost furnizate id-uri valide pentru produs
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    // Folosiți instrucțiunile preparate pentru a preveni SQL injection
    $query = "SELECT r.*, u.username
              FROM reviews r
              JOIN users u ON r.id_user = u.id
              WHERE r.id_producs = ?";

    $stmt = $con->prepare($query);

    // Verificați dacă instrucțiunea preparată a fost creată cu succes
    if ($stmt) {
        // Legați parametrii și executați interogarea
        $stmt->bind_param('i', $productId);
        $stmt->execute();

        // Obțineți rezultatele
        $result = $stmt->get_result();

        // Verificați dacă există recenzii
        if ($result) {
            // Afișează recenziile într-un format potrivit
            while ($row = $result->fetch_assoc()) {
                echo '<div class="review">';
                echo '<p class="reviewer">' . $row['username'] . '</p>';
                echo '<p class="review-text">' . $row['comentariu'] . '</p>';
                echo '<p class="review-date">Rating: ' . $row['rating'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>Eroare la obținerea recenziilor din baza de date.</p>';
        }

        // Închideți instrucțiunea preparată și rezultatul
        $stmt->close();
        $result->close();
    } else {
        echo '<p>Eroare la crearea instrucțiunii preparate.</p>';
    }
} else {
    // Id-uri invalide sau lipsă
    echo '<p>Eroare: Id-uri invalide sau lipsă.</p>';
}

// Închideți conexiunea la baza de date
$con->close();
?>
