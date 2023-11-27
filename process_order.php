<?php
// Include configurația bazei de date
session_start();
if (isset($_SESSION['user_id'])) {
    // Setează variabila locală cu ID-ul utilizatorului
    $userId = $_SESSION['user_id'];
}
include_once 'db.php'; // Asigură-te că ai un fișier cu configurația bazei de date

// Verifică dacă s-au primit datele prin metoda POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preia datele din formular
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $country = $_POST['country'];
    $street_address = $_POST['street_address'];
    $postcode = $_POST['postcode'];
    $county = $_POST['county'];
    $city = $_POST['city'];
    $phone_number = $_POST['phone_number'];
    $email_address = $_POST['email_address'];

// Înserează datele în tabela "orderss"
// Verifică dacă $userId este setat și diferit de null
if (isset($userId) && !empty($userId)) {
    // Înserează datele în tabela "orderss"
    $insertQuery = "INSERT INTO orderss (user_id, first_name, last_name, country, street_address, postcode, county, city, phone_number, email_address)
                    VALUES ('$userId', '$first_name', '$last_name', '$country', '$street_address', '$postcode', '$county', '$city', '$phone_number', '$email_address')";

    if ($con->query($insertQuery) === TRUE) {
        // Șterge produsele din coșul de cumpărături după ce comanda a fost plasată
        $deleteCartQuery = "DELETE FROM shopping_cart WHERE user_id = '$userId'";
        $con->query($deleteCartQuery);

        // Redirectează către o pagină de succes sau afișează un mesaj de succes
        header("Location: index_autentificat.php");
        exit();
    } else {
        // Afișează un mesaj de eroare sau redirectează către o pagină de eroare
        echo "Error: " . $insertQuery . "<br>" . $con->error;
    }
} else {
    // Afiseaza un mesaj de eroare sau redirectează către o pagină de eroare
    echo "Error: User ID is not set.";
}



    // Închide conexiunea la baza de date
    $con->close();
} else {
    // Redirectează către o pagină de eroare (de ex. în cazul accesului direct la script)
    header("Location: error.php");
    exit();
}
?>
