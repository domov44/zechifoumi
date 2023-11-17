<?php
session_start();
require_once('db.php');

function authenticateUser($pseudo, $password) {
    $conn = connectDB();
    $result = $conn->query("SELECT id, password FROM user WHERE pseudo = '$pseudo'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $row['id'];  // Si vous souhaitez stocker d'autres informations de l'utilisateur
            $conn->close();
            return true;
        }
    }

    $conn->close();
    return false;
}
?>