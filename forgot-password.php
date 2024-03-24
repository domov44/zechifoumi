<?php
require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'class/ToastHandler.php';
require_once('authentification/db.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $email = $_POST['email'];
    // $conn = connectDB(); 

    // if ($conn) {
    //     $query = "SELECT * FROM user WHERE email = '$email'";
    //     $result = $conn->query($query);

    //     if ($result && $result->num_rows > 0) {
    //         ini_set('SMTP', 'smtp.example.com');
    //         ini_set('smtp_port', 587);

    //         $resetLink = 'https://example.com/reset-password.php?email=' . urlencode($email);
    //         $subject = 'Réinitialisation du mot de passe';
    //         $body = 'Pour réinitialiser votre mot de passe, cliquez sur le lien suivant : ' . $resetLink;
    //         $headers = 'From: your@example.com';
    //         if (mail($email, $subject, $body, $headers)) {
    //             $message = 'Un e-mail de réinitialisation du mot de passe a été envoyé à votre adresse e-mail.';
    //         } else {
    //             $message = 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer plus tard.';
    //         }
    //     } else {
    //         $message = 'Cette adresse e-mail n\'existe pas dans notre système.';
    //     }

    //     $conn->close();
    // } else {
    //     $message = 'La connexion à la base de données a échoué. Veuillez réessayer plus tard.';
    // }
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
    <main class="contenu">
        <?php
        $toastHandler = new ToastHandler();
        $toastHandler->afficherToasts();
        ?>
        <section class="container">
            <div class="title-section">
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
                <h1 class="title">The chifoumi game</h1>
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            </div>
            <div class="chifoumi-container">
                <h2 class="title">Reset your password</h2>
                <form method="post" class="form">
                    <div class="input-container">
                        <div class="inputBox">
                            <input class="input-text" id="email" type="email" name="email" minlength="2" required>
                            <label for="pseudo">Email</label>
                        </div>
                        <?php if (!empty($message)) : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Send the email</button>
                </form>
                <a class="lien" id="icon-alternate" href="login.php">Back to login page</a>
            </div>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
</body>

</html>