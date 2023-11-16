<?php
session_start();
require_once 'class/Authenticator.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];

    $error_message = Authenticator::authenticate($pseudo, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <title>Login chifoumi</title>
</head>

<body>
    <main class="contenu">
        <section class="container">
            <div class="title-section">
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
                <h1 class="title">Welcome you need to login</h1>
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            </div>
            <div class="chifoumi-container">
            <?php
                if ($error_message != "") {
                    echo '<div class="error-message">' . $error_message . '</div>';
                }
                ?>
                <form class="form" method="post" action="login.php">
                    <div class="input-container">
                        <input name="pseudo" class="input-text" type="text" placeholder="Pseudo" minlength="2" maxlength="10" required>
                        <input name="password" class="input-text" type="password" placeholder="Password" minlength="2" required>
                    </div>
                    <button type="submit" class="submit-button">Login</button>
                </form>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
    <script src="animation/logo/logo.js"></script>
</body>

</html>