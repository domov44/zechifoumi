<?php
require_once 'config.php';
loadEnv(__DIR__ . '/../.env');

function connectDB()
{
    $conn = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué: " . $conn->connect_error);
    }

    return $conn;
}

$conn = connectDB();
