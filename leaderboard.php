<?php
session_start();
require_once 'class/GameInstance.php';
$game = new GameInstance();
$game->register($_SESSION["pseudo"]);
$_SESSION["game"] = $game;

// Obtenez le leaderboard à partir de la méthode getLeaderboard()
$leaderboard = $game->getLeaderboard();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <title>Leaderboard</title>
</head>

<body>
    <main class="contenu">
        <section class="container">
            <div class="title-section">
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
                <h1 class="title">Winstreak leaderboard</h1>
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            </div>
            <div class="chifoumi-container">
                <div class="leaderboard">
                    <?php
                    $leaderboard = $game->getLeaderboard();

                    foreach ($leaderboard as $rankedPlayer) {
                        $rank = $rankedPlayer['rank'];
                        $pseudo = $rankedPlayer['pseudo'];
                        $bestWinstreak = $rankedPlayer['bestWinstreak'];

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
        <?php
        include('includes/header.php');
        ?>
    </main>
    <script src="animation/logo/logo.js"></script>
</body>

</html>