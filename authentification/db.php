<?php
function connectDB() {
    $conn = new mysqli("localhost", "root", "", "zechifoumi");

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué: " . $conn->connect_error);
    }

    return $conn;
}
?>
