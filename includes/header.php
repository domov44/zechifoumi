<?php
require_once 'class/GameInstance.php';
require_once 'class/Player.php';
require_once 'class/Score.php';
?>
<header>
    <div class="logo" id="logo-container"></div>
    <div class="interaction">
        <?php
        $player = new Player();
        $pseudo = $player->username;

        $score = new Score();
        $userScore = $score->userScore;
        $computerScore = $score->computerScore;
        echo '<p>Connected as : ' . $pseudo . '</p>';
        echo '<p>Your score : ' . $userScore . '-' . $computerScore . '</p>';
        echo '<p>Bestwinstreak : ' . ($_SESSION["bestwinstreak"]) . '</p>';
        ?>
        <p class="<?php echo isset($_SESSION['winstreak']) && $_SESSION['winstreak'] > 1 ? 'winstreak visible' : 'winstreak'; ?>">🔥<?php echo isset($_SESSION['winstreak']) ? $_SESSION['winstreak'] : 0; ?> winstreak🔥
        </p>
        <form method="post" action="logout.php">
            <button class="button" type="submit" name="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">Logout</button>
        </form>
    </div>
</header>