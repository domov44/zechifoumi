<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'authentification/config.php';
require_once 'class/ToastHandler.php';
require_once('authentification/db.php');

if (isLoggedIn()) {
    header("Location: index.php");
    exit();
}

$message = '';
$class = "";
$showForm = false;
$conn = connectDB();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT * FROM user WHERE reset_token = ? AND expire_reset_token > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $showForm = true;
    } else {
        $message = "Token invalide ou expiré.";
    }
    $stmt->close();
} else {
    $message = "Aucun token fourni.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $showForm) {
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    if ($new_password === $confirm_new_password) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_stmt = $conn->prepare("UPDATE user SET password = ?, reset_token = NULL, expire_reset_token = NULL WHERE id = ?");
        $update_stmt->bind_param("si", $hashed_password, $user['id']);
        $update_stmt->execute();

        header("Location: login.php");
        $_SESSION['reset_password_success'] = true;
        exit();
    } else {
        $_SESSION['reset_password_fail'] = true;
        $message = "Les mots de passe ne correspondent pas.";
        $class = "loose";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation/ventilateur.svg" />
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
                <h1 class="title">Reset your password</h1>
            </div>
            <div class="chifoumi-container">
                <?php if ($showForm): ?>
                    <form method="post" class="form">
                        <div class="input-container">
                            <div class="inputBox">
                                <input class="input-text" type="password" id="new_password" name="new_password" autocomplete="new_password" required value="<?php echo isset($new_password) ? htmlspecialchars($new_password) : ''; ?>">
                                <label for="new_password">New password</label>
                                <button type="button" class="field-button" onclick="showPassword('new_password', 'eye-icon')">
                                    <i id="eye-icon" class="fa-regular fa-eye-slash"></i>
                                </button>
                            </div>
                            <div class="inputBox">
                                <input class="input-text" type="password" id="confirm_new_password" name="confirm_new_password" autocomplete="confirm_new_password" required value="<?php echo isset($confirm_new_password) ? htmlspecialchars($confirm_new_password) : ''; ?>">
                                <label for="confirm_new_password">Confirm new password</label>
                                <button type="button" class="field-button" onclick="showPassword('confirm_new_password', 'eye-icon-confirm')">
                                    <i id="eye-icon-confirm" class="fa-regular fa-eye-slash"></i>
                                </button>
                            </div>
                            <?php if (!empty($message) && $class === "loose") : ?>
                                <div class="loose" role="alert">
                                    <strong class="font-bold">Error !</strong>
                                    <span><?php echo $message; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="button">Reset Password</button>
                    </form>
                <?php else: ?>
                    <div class="loose" role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span><?php echo $message; ?></span>
                    </div>
                <?php endif; ?>
                <a class="lien" href="login.php">Back to login page</a>
            </div>
        </section>
        <?php include('includes/footer.php'); ?>