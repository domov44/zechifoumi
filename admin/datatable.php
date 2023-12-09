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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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
                <div class="overlay" id="addUserPopup" style="display: none;">
                    <div class="popup" id="addUserPopup">
                        <div id="popupContent"></div>
                    </div>
                </div>
                <?php include('display_users.php'); ?>
            </div>
            <button class="button" onclick="afficherAlerte()">Afficher Alerte</button>
        </section>
        <div class="overlay" id="modifyUserPopup" style="display: none;">
            <div class="popup" id="modifyUserPopup">
                <div id="EditContent"></div>
            </div>
        </div>
    </main>
</body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="../javascript/functions.js"></script>
</html>