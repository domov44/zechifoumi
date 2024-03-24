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
        $_SESSION['connexion_echoue'] = true;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="javascript/functions.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>
    <main class="content">
        <?php
        $toastHandler = new ToastHandler();
        $toastHandler->afficherToasts();
        ?>
        <section class="section">
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
                            <input class="input-text" id="pseudo" type="text" name="pseudo" minlength="2" maxlength="10" autocomplete="pseudo" required value="<?php echo isset($pseudo) ? htmlspecialchars($pseudo) : ''; ?>">
                            <label for="pseudo">Pseudo</label>
                        </div>

                        <div class="inputBox">
                            <input class="input-text" id="password" type="password" name="password" autocomplete="password" required value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
                            <label for="password">Password</label>
                            <button type="button" id="show-password" class="field-button" onclick="showPassword('password', 'eye-icon')">
                                <i id="eye-icon" class="fa-regular fa-eye-slash"></i>
                            </button>
                        </div>
                        <a class="lien" id="icon-alternate" href="forgot-password.php">Forgot you password?</a>
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
</body>

</html>