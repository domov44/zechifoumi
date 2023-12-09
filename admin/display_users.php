<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    $conn = connectDB();

    $sql = "SELECT id, creation, pseudo, email, user_score, computer_score, role FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Creation</th><th>Pseudo</th><th>Email</th><th>User Score</th><th>Computer Score</th><th>Role</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['creation']}</td>";
            echo "<td>{$row['pseudo']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['user_score']}</td>";
            echo "<td>{$row['computer_score']}</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td><div>";
            echo "<button class='button' type='button' style='width:fit-content' onclick='toggleModifyPopup({$row['id']})'><i class='fas fa-pencil-alt'></i></button>";
            echo "<form action='delete_user.php' method='post'>";
            echo "<input type='hidden' name='user_id' value='{$row['id']}'>";
            echo "<button class='button' type='submit'><i class='far fa-trash-alt'></i></button>";
            echo "</form></div></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }

    $conn->close();
}
?>
