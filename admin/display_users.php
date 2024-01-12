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
                <th>User score</th>
                <th>Computer score</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><span><?= $row['id'] ?></span></td>
                    <td><span><?= $row['creation'] ?></span></td>
                    <td>
                        <span class="<?= ($row['role'] === 'Admin') ? 'chip primary' : 'chip success' ?>">
                            <?= $row['role'] ?>
                        </span>
                    </td>
                    <td><span><?= $row['pseudo'] ?></span></td>
                    <td><span><?= $row['email'] ?></span></td>
                    <td><span><?= $row['user_score'] ?></span></td>
                    <td><span><?= $row['computer_score'] ?></span></td>
                    <td>
                        <div>
                            <button class='button-secondary' type='button' style='width:fit-content' onclick='toggleModifyPopup(<?= $row['id'] ?>)'><i class='fas fa-pencil-alt'></i></button>
                            <form action='' method='post' onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'delete_user.php' : 'delete_user'; return true;">
                                <input type='hidden' name='user_id' value='<?= $row['id'] ?>'>
                                <button class='button' type='submit'><i class='far fa-trash-alt'></i></button>
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