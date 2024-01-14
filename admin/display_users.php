<?php
require_once('../authentification/db.php');
require_once('../authentification/session.php');

if (isAdmin()) {
    $conn = connectDB();

    $sql = "SELECT id, creation, pseudo, email, user_score, computer_score, role FROM user";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
?>
        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Creation</th>
                <th>Role</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>User Score</th>
                <th>Computer Score</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['creation'] ?></td>
                    <td>
                        <span class="<?= ($row['role'] === 'Admin') ? 'chip primary' : 'chip success' ?>">
                            <?= $row['role'] ?>
                        </span>
                    </td>
                    <td><?= $row['pseudo'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['user_score'] ?></td>
                    <td><?= $row['computer_score'] ?></td>
                    <td>
                        <div>
                            <button class='button' type='button' style='width:fit-content' onclick='toggleModifyPopup(<?= $row['id'] ?>)'><i class='fas fa-pencil-alt'></i></button>
                            <form action='delete_user' method='post' class='deleteForm'>
                                <input type='hidden' name='user_id' value='<?= $row['id'] ?>'>
                                <button class='button' type='button' onclick='confirmDelete(<?= $row['id'] ?>)'><i class='far fa-trash-alt'></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
<?php
    } else {
        echo "Aucun utilisateur trouvé.";
    }

    $conn->close();
}
?>