<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
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
    <main class="contenu">
        <section class="container">
            <div class="title-section">
                <h1 class="title">Admin page</h1>
            </div>
            <div class="chifoumi-container">
                <a href="datatable.php" class="lien">Database Panel</a>
            </div>
        </section>
    </main>
</body>

</html>