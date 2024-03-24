<?php
require_once('authentification/db.php');
require_once('authentification/session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isLoggedIn()) {
        $user_id = $_SESSION['user_id'];
        $conn = connectDB();
        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            unset($_SESSION['token']);
            unset($_SESSION['admin_token']);
            $_SESSION['current_account_delete_success'] = true;

            header("Location: login.php");
            exit();
        } else {
            $_SESSION['current_account_delete_fail'] = true;
            header("Location: edit.php");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: login.php");
        exit();
    }
} else {
    header("Location: edit.php");
    $_SESSION['current_account_delete_fail'] = true;
    exit();
}
