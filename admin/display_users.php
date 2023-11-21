<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    $conn = connectDB();

    $sql = "SELECT id, pseudo, email, role FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>User List</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Pseudo</th><th>Email</th><th>Role</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['pseudo']}</td><td>{$row['email']}</td><td>{$row['role']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }

    $conn->close();
}
