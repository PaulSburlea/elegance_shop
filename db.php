<?php
    global $con;
    $con = mysqli_connect("localhost", "root", "", "elegance_shop");

    // Verificare conexiune
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>
