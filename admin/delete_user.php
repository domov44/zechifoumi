<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];

        $conn = connectDB();

        $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute(); 

        $stmt->close();
        $conn->close();

        if ($result) {
            $_SESSION['supp_reussie'] = true;
        }

        else {
            $_SESSION['supp_echoue'] = true;
        }

        header("Location: datatable.php");
        exit();
    }
}
