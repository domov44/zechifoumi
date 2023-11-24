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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script>
        function togglePopup() {
            var popup = document.getElementById("addUserPopup");
            popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";

            if (popup.style.display === "block") {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("popupContent").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "add_user.php", true);
                xmlhttp.send();
            }
        }
    </script>

</head>

<?php
require_once('../authentification/session.php');

if (!isAdmin()) {
    header("Location: ../login.php");
    exit();
}

?>

<body>
    <main class="contenu">
        <section class="container">
            <div class="title-section">
                <h1>User Management</h1>
            </div>
            <div class="table-container">
                <h2>User List</h2>
                <button class="button" style="width:fit-content" onclick="togglePopup()">+ Add</button>
                <div class="popup" id="addUserPopup" style="display: none;">
                    <div id="popupContent"></div>
                </div>

                <?php include('display_users.php'); ?>
            </div>
        </section>
        <!-- Form for Modifying a User -->
        <h2>Modify User</h2>
        <form action="modify_user.php" method="post">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" required>
            <button type="submit">Modify User</button>
        </form>
    </main>
</body>

</html>