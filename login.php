<?php
require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'class/ToastHandler.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    if (authenticateUser($pseudo, $password)) {
        $_SESSION['connexion_reussie'] = true;

        header("Location: index.php");
        exit();
    } else {
        $message = "Incorrect username or password. Please check your login credentials and try again.";
    }
}

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>
    <main class="contenu">
        <?php
        $toastHandler = new ToastHandler();
        $toastHandler->afficherToasts();
        var_dump($_SESSION['deconnexion_reussie']);
        ?>
        <section class="container">
            <div class="title-section">
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
                <h1 class="title">The chifoumi game</h1>
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            </div>
            <div class="chifoumi-container">
                <h2 class="title">Login</h2>
                <form method="post" class="form">
                    <div class="input-container">
                        <div class="inputBox">
                            <input class="input-text" id="pseudo" type="text" name="pseudo" minlength="2" maxlength="10" required>
                            <label for="pseudo">Pseudo</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" id="password" type="password" name="password" required>
                            <label for="password">Password</label>
                        </div>
                        <?php if (!empty($message)) : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Login</button>
                    <a class="button-secondary" href="signup.php">Create account</a>
                </form>
            </div>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
    <script src="javascript/functions.js"></script>
</body>

</html>