<?php
require_once 'class/GameInstance.php';
require_once 'class/Player.php';

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
$player = new Player();
?>

<header>
    <div class="logo" id="logo-container"></div>
    <div class="interaction">
        <a class="lien" href="leaderboard.php">
            <?php
            $playerRank = $game->getPlayerRank($player->username);
            if ($playerRank !== null) {
                echo  $player->username . " " . "#" . $playerRank;
            }
            ?>
        </a>
        <p class="scoring <?php echo isset($classeCSS) ? $classeCSS : 'egalite'; ?>">Score : <?php echo $_SESSION['score']['user'] ?> - <?php echo $_SESSION['score']['ia'] ?></p>
        </p>
        <p class="<?php echo isset($_SESSION['winStreak']) && $_SESSION['winStreak'] > 1 ? 'winstreak visible' : 'winstreak'; ?>">🔥<?php echo isset($_SESSION['winStreak']) ? $_SESSION['winStreak'] : 0; ?> winstreak🔥
        </p>
        <form method="post" action="logout.php">
            <button class="button" type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Déconnexion</button>
        </form>

        <!-- <select class="selectmode" name="selector" id="selectmode">
        <option value="Easy">Easy</option>
        <option value="Hard">Hard 👿</option>
    </select> -->
    </div>
</header>