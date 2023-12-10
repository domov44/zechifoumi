<?php
require_once('authentification/session.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Utiliser unset pour supprimer les variables de session
    unset($_SESSION['token']);
    unset($_SESSION['admin_token']);

    // Indiquer que la déconnexion a réussi
    $_SESSION['deconnexion_reussie'] = true;

    header("Location: login.php");
    exit();
}

// Rediriger vers la page d'accueil si l'utilisateur est connecté
header("Location: index.php");
exit();
?>
