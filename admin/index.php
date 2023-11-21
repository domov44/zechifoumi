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
    <h1 class="title">This is an admin page</h1>
    <a href="datatable.php" class="lien">Database</a>
</body>
</html>