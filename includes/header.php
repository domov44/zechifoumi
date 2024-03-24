<?php
require_once(__DIR__ . '/../class/GameInstance.php');
require_once(__DIR__ . '/../class/Player.php');
require_once(__DIR__ . '/../class/Score.php');
?>
<aside class="aside">
    <div class="logo" id="logo-container"></div>
    <div class="interaction">
        <?php

        if (!isset($_SESSION["bestwinstreak"])) {
            $_SESSION["bestwinstreak"] = 0;
        }

        $player = new Player();
        $pseudo = $player->username;

        $score = new Score();
        $userScore = $score->userScore;
        $computerScore = $score->computerScore;

        if ($userScore > $computerScore) {
            $classeCSS = 'win';
        } elseif ($userScore < $computerScore) {
            $classeCSS = 'loose';
        } else {
            $classeCSS = 'egalite';
        }
        ?>
        <ul class="menu">
            <li>
                <a class="nav-item" href="index.php"><i class="fa-solid fa-hand-scissors"></i>PLay</a>
            </li>
            <li>
                <a class="nav-item" href="leaderboard.php"><i class="fa-solid fa-trophy"></i>Leaderboard</a>
            </li>
            <li>
                <a class="nav-item" href="edit.php"><i class='fas fa-user-alt'></i>My account</a>
            </li>
            <li>
                <form method="post" action="" onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'logout.php' : 'logout'; return true;">
                    <button class="nav-item" type="submit" name="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i>Logout</button>
                </form>
            </li>
        </ul>
        <p class="scoring <?php echo isset($classeCSS) ? $classeCSS : 'egalite'; ?>">Score : <?php echo $userScore ?> - <?php echo $computerScore ?></p>
        <p>Bestwinstreak : <?php echo '🔥' . $_SESSION["bestwinstreak"] . '🔥'; ?> </p>
        <p>Your rank : <?php
                        $playerRank = $game->getPlayerRank($_SESSION["pseudo"]);
                        if ($playerRank !== null) {
                            echo  "#" . $playerRank;
                        }
                        ?> </p>
        </p>
    </div>
</aside>
<main class="content w-aside">
    <header class="header">
        <button class="button fit-content pointer-events-fill" id="toggle">menu</button>
        <div class="user-info-container">
            <img class="user-avatar" src=<?php echo $_SESSION["avatar"] ?>>
            <h5 class="title">
                <?php echo $pseudo ?>
            </h5>
        </div>
    </header>