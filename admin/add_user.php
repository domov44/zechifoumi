<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pseudo = $_POST['pseudo'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Add other fields as needed

        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO user (pseudo, email, role, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $pseudo, $email, $role, $password);
        $result = $stmt->execute(); 

        $stmt->close();
        $conn->close();

        if ($result) {
            $_SESSION['ajout_reussie'] = true;
        }

        else {
            $_SESSION['ajout_echoue'] = true;
        }

        header("Location: datatable.php");
        exit();
    }
}
?>

<h2>Add User</h2>
<form class="form" action="" method="post"  onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'add_user.php' : 'add_user'; return true;">
    <div class="input-container">
        <div class="inputBox">
            <input class="input-text" type="text" name="pseudo" required>
            <label for="pseudo">Pseudo</label>
        </div>
        <div class="inputBox">
            <input class="input-text" type="email" name="email" required>
            <label for="pseudo">Email</label>
        </div>
    </div>
    <div style="display: flex; gap:15px;">
        <div class="avatar-choice">Choose a role
            <input type="radio" id="player" name="role" value="Player" checked />
            <label class="avatar-label" for="player">
                <img src="https://zechifoumi.com/uploads/avatar/samourai.svg">
                <div>Player</div>
            </label>
        </div>
        <div class="avatar-choice">
            <input type="radio" id="admin" name="role" value="Admin" />
            <label class="avatar-label" for="admin">
                <img src="https://zechifoumi.com/uploads/avatar/samourai-2.svg">
                <div>Admin</div>
            </label>
        </div>
    </div>
    <div class="input-container">
        <div class="inputBox">
            <input class="input-text" type="password" name="password" required>
            <label for="pseudo">Password</label>
        </div>
    </div>
    <button class="button" type="submit">Add User</button>
    <button class="button-secondary" onclick="togglePopup()">Cancel</button>
</form>