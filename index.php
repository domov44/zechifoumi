<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <script src="javascript/functions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <title>Chifoumi</title>

</head>

<?php
require_once 'class/GameInstance.php';
require_once 'class/Player.php';
require_once 'class/CreateDB.php';
require_once('authentification/session.php');
require_once 'class/ToastHandler.php';

$connexion = new CreateDB();
$game = new GameInstance();
$player = new Player();
$pseudo = $player->username;

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = ['user' => 0, 'ia' => 0];
}

if (!isset($_SESSION['winStreak'])) {
    $_SESSION['winStreak'] = 0;
}

$game->startChifoumi();
$_SESSION["game"] = $game;

?>
<?php
include('includes/header.php');
?>

<body>
    <?php
    $toastHandler = new ToastHandler();
    $toastHandler->afficherToasts();
    ?>
    <section class="section">
        <div class="title-section">
            <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            <h1 class="title">The chifoumi game</h1>
            <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
        </div>
        <div class="chifoumi-container">
            <div class="user-choice">
                <form class="form" onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'result.php' : 'result'; return true;" method="post">
                    <div class="input-container">
                        <?php
                        echo '<input class="input-text" type="hidden" value="' . $pseudo . '" name="pseudo" placeholder="Your pseudo" minlength="2" maxlength="10" required>';
                        ?>
                    </div>
                    <div class="button-container">
                        <?php
                        foreach ($game->choices as $choice) {
                            echo '<input type="submit" name="submit" value="' . $choice->value . '" class="button">';
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="illustration">
                <div id="lottie"></div>
            </div>
        </div>
    </section>
    <?php
    include('includes/footer.php');
    ?>