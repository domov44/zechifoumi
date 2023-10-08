<?php
require_once 'class/GameInstance.php';

$UserScore = $_SESSION['score']['user'];
$IAscore = $_SESSION['score']['ia'];

if ($UserScore > $IAscore) {
    $classeCSS = 'win';
} elseif ($UserScore < $IAscore) {
    $classeCSS = 'loose';
} else {
    $classeCSS = 'egalite';
}

$game = new GameInstance();
?>

<div class="interaction">
    <a class="lien" href="leaderboard.php">
        <?php
        $playerRank = $game->getPlayerRank($_SESSION["pseudo"]);
        if ($playerRank !== null) {
            echo  $_SESSION["pseudo"]. " " . "#" . $playerRank ;
        }
        ?>
    </a>
    <p class="scoring <?php echo isset($classeCSS) ? $classeCSS : 'egalite'; ?>">Score : <?php echo $_SESSION['score']['user'] ?> - <?php echo $_SESSION['score']['ia'] ?></p>
    </p>
    <p class="<?php echo isset($_SESSION['winStreak']) && $_SESSION['winStreak'] > 1 ? 'winstreak visible' : 'winstreak'; ?>">🔥<?php echo isset($_SESSION['winStreak']) ? $_SESSION['winStreak'] : 0; ?> winstreak🔥
    </p>

    <!-- <select class="selectmode" name="selector" id="selectmode">
        <option value="Easy">Easy</option>
        <option value="Hard">Hard 👿</option>
    </select> -->
</div>