<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'authentification/config.php';
require_once 'class/ToastHandler.php';
require_once('authentification/db.php');
require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
loadEnv(__DIR__ . '/.env');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];

    // Vérification si le pseudo n'est pas vide
    if (!empty($pseudo)) {
        $conn = connectDB();

        // Préparer la requête pour éviter l'injection SQL
        $stmt = $conn->prepare("SELECT email FROM user WHERE pseudo = ?");
        $stmt->bind_param('s', $pseudo);  // 's' pour string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // PHPMailer pour l'envoi d'email sécurisé
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USERNAME'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Utilisation d'une constante sécurisée
                $mail->Port = $_ENV['SMTP_PORT'];

                $mail->setFrom('contact@zechifoumi.com', 'Support Chifoumi');
                $mail->addAddress($email);

                // Configuration du contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body = '
                    Hi,
                    
                    We received a request to reset your password for your account associated with this email address. 
                    If you made this request, please follow the instructions below to reset your password:
                    
                    <a href="https://zechifoumi.com/reset-password?token=UNIQUE_TOKEN">Click here to reset your password</a>
                    
                    For security reasons, the link will expire in 24 hours. If you did not request a password reset, 
                    please ignore this email or contact our support team if you have any concerns.
                    
                    Thank you,<br>
                    Zechifoumi Support Team
                ';

                $mail->AltBody = '
                    Hi,
                    
                    We received a request to reset your password for your account associated with this email address. 
                    If you made this request, please follow the instructions below to reset your password:
                    
                    Visit the following link to reset your password: https://zechifoumi.com/reset-password?token=UNIQUE_TOKEN
                    
                    For security reasons, the link will expire in 24 hours. If you did not request a password reset, 
                    please ignore this email or contact our support team if you have any concerns.
                    
                    Thank you, Zechifoumi Support Team
                ';

                $mail->send();
                $_SESSION['mail_sent'] = true;
            } catch (Exception $e) {
                $_SESSION['mail_no_sent'] = true;
                $message = "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['mail_sent'] = true;
        }

        $stmt->close();
    } else {
        $message = 'Veuillez entrer un pseudo valide.';
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
                <h2 class="title">Reset your password</h2>
                <form method="post" class="form">
                    <div class="input-container">
                        <div class="inputBox">
                            <input class="input-text" id="pseudo" type="text" name="pseudo" minlength="2" required>
                            <label for="pseudo">Your pseudo</label>
                        </div>
                        <?php if (!empty($message)) : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Send the reset email</button>
                </form>
                <a class="lien" id="icon-alternate" href="login.php">Back to login page</a>
            </div>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>