<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/footer.css" rel="stylesheet" />
    <link href="style/style.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <title>Result</title>
</head>

<body>

    <?php
    session_start();
    require_once 'class/GameInstance.php';
    $game = new GameInstance();
    $game->play($_POST["submit"]);
    $game->register($_POST["pseudo"]);
    ?>
    <main class="contenu">
        <section class="container">
            <div class="title-section">
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
            <div class="chifoumi-container">
                <div class="ia-choice">
                    <h2 class="title">You have chosen..</h2>
                    <p class="paragraph">
                        <?php
                        echo $_POST["submit"];
                        ?>
                    </p>
                    <h2 class="title">The AI have chosen..</h2>
                    <p class="paragraph">
                        <?php
                        echo $game->valueComputerChoice;
                        ?>
                    </p>
                    <button onclick="window.location.href='index.php';" class="button full-width">Restart</button>
                </div>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
    <?php
    include('includes/score.php');
    ?>
</body>

</html>