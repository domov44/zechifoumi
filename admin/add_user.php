<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Add other fields as needed

        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO user (pseudo, email, role, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $pseudo, $email, $role, $password);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header("Location: datatable.php");
        exit();
    }
}
