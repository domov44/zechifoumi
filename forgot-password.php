<?php
require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'class/ToastHandler.php';
require_once('authentification/db.php');
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $email = $_POST['email'];

    // if (!empty($email)) {
    //     $mail = new PHPMailer(true);

    //     try {
    //         $mail->isSMTP();
    //         $mail->Host = 'smtp.gmail.com';
    //         $mail->SMTPAuth = true;
    //         $mail->Username = 'ronanscotet467@gmail.com';
    //         $mail->Password = 'dubl fpze yuxh wbto';
    //         $mail->SMTPSecure = 'tls';
    //         $mail->Port = 587;

    //         $mail->setFrom('ronanscotet467@gmail.com', 'Support Chifoumi');
    //         $mail->addAddress($email);

    //         $mail->isHTML(true);
    //         $mail->Subject = 'Reset your password';
    //         $mail->Body = 'Cliquez <a href="https://yourwebsite.com/reset-password?email=' . urlencode($email) . '">ici</a> pour réinitialiser votre mot de passe.';
    //         $mail->AltBody = 'Cliquez sur le lien suivant pour réinitialiser votre mot de passe : https://yourwebsite.com/reset-password?email=' . urlencode($email);

    //         $mail->send();
    //         $_SESSION['mail_sent'] = true;
    //     } catch (Exception $e) {
    //         $_SESSION['mail_no_sent'] = true;
    //         $message = "L'e-mail n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
    //     }
    // } else {
    //     $message = 'Veuillez entrer une adresse e-mail valide.';
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