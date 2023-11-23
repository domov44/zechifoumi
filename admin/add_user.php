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
        $stmt->execute();

        $stmt->close();
        $conn->close();

        header("Location: datatable.php");
        exit();
    }
}
?>

<h2>Add User</h2>
<form class="form" action="add_user.php" method="post">
    <div class="input-container">
        <input class="input-text" type="text" name="pseudo" placeholder="pseudo" required>
        <input class="input-text" type="email" name="email" placeholder="email" required>
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
        <input class="input-text" type="password" name="password" placeholder="password" required>
    </div>
    <button class="button" type="submit">Add User</button>
    <button class="button-secondary" onclick="togglePopup()">Cancel</button>
</form>