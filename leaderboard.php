<?php
require_once 'class/GameInstance.php';
require_once('authentification/session.php');

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$game = new GameInstance();
$player = new Player();
$_SESSION["game"] = $game;

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <title>Leaderboard</title>
</head>

<body>
    <?php
    $game = new GameInstance();
    $player = new Player();
    $pseudo = $player->username;
    include('includes/header.php');
    ?>
    <section class="section">
        <div class="title-section">
            <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            <h1 class="title">Winstreak leaderboard</h1>
            <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
        </div>
        <div class="chifoumi-container">
            <div class="leaderboard">
                <?php
                // Obtenez le leaderboard à partir de la méthode getLeaderboardFromDB() au lieu de getLeaderboard()
                $leaderboard = $game->getLeaderboard();

                foreach ($leaderboard as $rankedPlayer) {
                    $rank = $rankedPlayer['rank'];
                    $pseudo = $rankedPlayer['pseudo'];
                    $bestWinstreak = $rankedPlayer['bestwinstreak'];

                    if ($rank <= 5) {
                        $headerTag = "h" . ($rank + 1);
                    } else {
                        $headerTag = "p";
                    }

                    echo "<$headerTag class='title leaderboard'>#" . $rank . " " . $pseudo . " " . "🔥" . $bestWinstreak . "🔥</$headerTag>";
                }
                ?>
            </div>
            <button onclick="window.location.href='index.php';" class="button full-width">Play</button>
        </div>
    </section>
    <?php
    include('includes/footer.php');
    ?>