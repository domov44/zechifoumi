<?php
session_start();
require_once('db.php');

function authenticateUser($pseudo, $password) {
    $conn = connectDB();
    $result = $conn->query("SELECT id, pseudo, user_score, computer_score, winstreak, bestwinstreak, password FROM user WHERE pseudo = '$pseudo'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $token = bin2hex(random_bytes(16));
            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['pseudo'] = $row['pseudo']; 
            $_SESSION['user_score'] = $row['user_score'];
            $_SESSION['computer_score'] = $row['computer_score'];
            $_SESSION['winstreak'] = $row['winstreak'];
            $_SESSION['bestwinstreak'] = $row['bestwinstreak'];
            $conn->close();
            return true;
        }
    }

    $conn->close();
    return false;
}
?>