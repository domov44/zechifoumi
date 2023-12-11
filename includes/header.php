<?php
require_once 'class/GameInstance.php';
require_once 'class/Player.php';
require_once 'class/Score.php';
?>
<header>
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
        <div class="user-info-container">
            <img class="user-avatar" src=<?php echo $_SESSION["avatar"] ?>>
            <h5 class="title">
                <?php echo $pseudo ?>
            </h5>
        </div>
        <a class="lien" href="edit.php">Edit account</a>
        <form method="post" action="" onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'logout.php' : 'logout'; return true;">
            <button class="lien" type="submit" name="logout">Logout ?</button>
        </form>
        <p class="scoring <?php echo isset($classeCSS) ? $classeCSS : 'egalite'; ?>">Score : <?php echo $userScore ?> - <?php echo $computerScore ?></p>
        <p>Bestwinstreak : <?php echo '🔥' . $_SESSION["bestwinstreak"] . '🔥'; ?> </p>
        <p>Your rank : <?php
                        $playerRank = $game->getPlayerRank($_SESSION["pseudo"]);
                        if ($playerRank !== null) {
                            echo  "#" . $playerRank;
                        }
                        ?> </p>
        </p>
        <button class="button" onclick="window.location='leaderboard.php'">Leaderboard 🏆</button>
        <p class="<?php echo isset($_SESSION['winstreak']) && $_SESSION['winstreak'] > 1 ? 'winstreak visible' : 'winstreak'; ?>">🔥<?php echo isset($_SESSION['winstreak']) ? $_SESSION['winstreak'] : 0; ?> winstreak🔥
        </p>
    </div>
</header>