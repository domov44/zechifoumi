<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/footer.css" rel="stylesheet" />
    <link href="style/style.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Result</title>
</head>

<body>
    <?php
    require_once 'class/GameInstance.php';
    require_once 'class/Player.php';
    require_once 'class/CreateDB.php';
    require_once('authentification/session.php');

    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }

    $game = new GameInstance();
    $player = new Player();
    $pseudo = $player->username;

    // Process game result and update session variables
    $game->play($_POST["submit"]);

    // Update database and JSON file
    $connexion = new CreateDB();
    $connexion->WriteData($pseudo);


    ?>
    <?php
    include('includes/header.php');
    ?>
    <section class="section">
        <p class="<?php echo isset($_SESSION['winstreak']) && $_SESSION['winstreak'] > 1 ? 'winstreak visible' : 'winstreak'; ?>">🔥<?php echo isset($_SESSION['winstreak']) ? $_SESSION['winstreak'] : 0; ?> winstreak🔥
        </p>
        <div class="result">
            <div class="<?php
                        if ($game->result == "You won !") {
                            echo 'win';
                        } elseif ($game->result == "Egality") {
                            echo 'egalite';
                        } else {
                            echo 'loose';
                        }
                        ?>">
                <h1 class="title">
                    <?php
                    echo $game->result;
                    ?>
                </h1>
            </div>
        </div>
        <p class="scoring <?php echo isset($classeCSS) ? $classeCSS : 'egalite'; ?>">Score : <?php echo $userScore ?> - <?php echo $computerScore ?></p>
        <div class="chifoumi-container">
            <div class="ia-choice">
                <h2 class="title">You have chosen..</h2>
                <p class="paragraph">
                    <?php
                    echo $_POST["submit"];
                    ?>
                </p>
                <h2 class="title">The AI has chosen..</h2>
                <p class="paragraph">
                    <?php
                    echo $game->valueComputerChoice;
                    ?>
                </p>
                <form class="form" method="post">
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
        </div>
    </section>
    <?php
    include('includes/footer.php');
    ?>