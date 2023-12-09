<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $user_score = $_POST['user_score'];
        $computer_score = $_POST['computer_score'];
        $winstreak = $_POST['winstreak'];
        $bestwinstreak = $_POST['bestwinstreak'];

        $conn = connectDB();
        $stmt = $conn->prepare("UPDATE user SET pseudo = ?, email = ?, user_score = ?, computer_score = ?, winstreak = ?, bestwinstreak = ? WHERE id = ?");
        $stmt->bind_param("ssiiiii", $pseudo, $email, $user_score, $computer_score, $winstreak, $bestwinstreak, $user_id);
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header("Location: datatable.php");
        exit();
    }
    
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];

        $conn = connectDB();
        $stmt = $conn->prepare("SELECT pseudo, email, user_score, computer_score, winstreak, bestwinstreak FROM user WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_info = $result->fetch_assoc();
        }

        $stmt->close();
        $conn->close();
    }

    if (isset($user_info)) {
?>

<h2>Modify User</h2>
<form class="form" action="modify_user.php" method="post">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <div class="input-container">
        <div class="inputBox">
        <input class="input-text" id="pseudo" type="text" name="pseudo" required value="<?php echo $user_info['pseudo']; ?>">
            <label for="pseudo">Pseudo</label>
        </div>
        <div class="inputBox">
            <input class="input-text" id="email" type="email" name="email" required value="<?php echo $user_info['email']; ?>">
            <label for="email">Email</label>
        </div>

        <div class="inputBox">
            <input class="input-text" id="user_score" type="text" name="user_score" value="<?php echo $user_info['user_score']; ?>">
            <label for="user_score">User Score</label>
        </div>

        <div class="inputBox">
            <input class="input-text" id="computer_score" type="text" name="computer_score" value="<?php echo $user_info['computer_score']; ?>">
            <label for="computer_score">Computer Score</label>
        </div>

        <div class="inputBox">
            <input class="input-text" id="winstreak" type="text" name="winstreak" value="<?php echo $user_info['winstreak']; ?>">
            <label for="winstreak">Win Streak</label>
        </div>

        <div class="inputBox">
            <input class="input-text" id="bestwinstreak" type="text" name="bestwinstreak" value="<?php echo $user_info['bestwinstreak']; ?>">
            <label for="bestwinstreak">Best Win Streak</label>
        </div>
        <?php if (!empty($message)) : ?>
            <div class="loose" role="alert">
                <strong class="font-bold">Error!</strong>
                <span><?php echo $message; ?></span>
            </div>
        <?php endif; ?>
        <button type="submit" class="button">Update</button>
        <button type="button" class="button-secondary" onclick="toggleModifyPopup()">Cancel</button>
    </div>
</form>

<?php
    } else {
        echo "User not found.";
    }
}
?>
