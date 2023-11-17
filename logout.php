<?php
require_once('authentification/session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Supprimer la session (déconnexion)
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Rediriger vers la page d'accueil si l'utilisateur n'est pas déconnecté
header("Location: index.php");
exit();
?>
