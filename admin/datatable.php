<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database panel</title>
    <link href="../style/style.css" rel="stylesheet" />
    <link href="../style/footer.css" rel="stylesheet" />
    <link href="../font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
</head>

<?php
require_once('../authentification/session.php');

if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

?>

<body>
    <h1>User Management</h1>

    <!-- Display Table with User Data -->
    <?php include('display_users.php'); ?>

    <!-- Form for Adding a New User -->
    <h2>Add User</h2>
    <form action="add_user.php" method="post">
        <label for="pseudo">Pseudo:</label>
        <input type="text" name="pseudo" required>
        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="role">Choose a role:</label>
        <select name="role" id="role">
            <option value="">--Please choose a role--</option>
            <option value="Player">Player</option>
            <option value="Admin">Admin</option>
        </select>

        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Add User</button>
    </form>

    <!-- Form for Modifying a User -->
    <h2>Modify User</h2>
    <form action="modify_user.php" method="post">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required>
        <!-- Add other fields as needed -->
        <button type="submit">Modify User</button>
    </form>

    <!-- Form for Deleting a User -->
    <h2>Delete User</h2>
    <form action="delete_user.php" method="post">
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" required>
        <button type="submit">Delete User</button>
    </form>
</body>

</html>