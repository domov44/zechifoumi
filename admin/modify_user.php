<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        // Fetch user data from the database based on the user_id
        // Update the user information as needed

        $conn = connectDB();

        // Example: Update pseudo
        $stmt = $conn->prepare("UPDATE user SET pseudo = ? WHERE id = ?");
        $stmt->bind_param("si", $new_pseudo, $user_id);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header("Location: datatable.php");
        exit();
    }
}
