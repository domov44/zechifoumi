<?php
require_once('authentification/db.php');
require_once('authentification/auth.php');
require_once('authentification/session.php');
require_once 'class/ToastHandler.php';

$message = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $avatar = $_POST['avatar'];

    if (!empty($password) && $password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conn = connectDB();

            $stmt = $conn->prepare("UPDATE user SET pseudo=?, avatar=?, email=?, password=? WHERE id=?");

            $user_id = $_SESSION['user_id'];

            $stmt->bind_param("ssssi", $pseudo, $avatar, $email, $passwordHash, $user_id);

            if ($stmt->execute()) {
                $_SESSION['modification_reussie'] = true;
                $_SESSION['pseudo'] = $pseudo;
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['modification_echoue'] = true;
                $message = "Error modifying the account. Please try again later.";
                error_log("Error modifying the account: " . $stmt->error);
                $class = "loose";
            }

            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['modification_echoue'] = true;
            $message = "Invalid email address. Please provide a valid email address.";
            $class = "loose";
        }
    } elseif (empty($password)) {
        $conn = connectDB();

        $stmt = $conn->prepare("UPDATE user SET pseudo=?, avatar=?, email=? WHERE id=?");

        $user_id = $_SESSION['user_id'];

        $stmt->bind_param("sssi", $pseudo, $avatar, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['modification_reussie'] = true;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $email;
            $_SESSION['avatar'] = $avatar;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['modification_echoue'] = true;
            $message = "Error modifying the account. Please try again later.";
            error_log("Error modifying the account: " . $stmt->error);
            $class = "loose";
        }

        $stmt->close();
        $conn->close();
    } else {
        $_SESSION['modification_echoue'] = true;
        $message = "Passwords do not match. Please enter them again.";
        $class = "loose";
    }
}

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit you account</title>
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="javascript/functions.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.3/lottie.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>

    <?php
    require_once 'class/GameInstance.php';
    require_once 'class/Player.php';
    require_once 'class/CreateDB.php';
    require_once('authentification/session.php');

    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }

    $game = new GameInstance();
    $player = new Player();
    $pseudo = $player->username;


    ?>
    <?php
    include('includes/header.php');
    ?>
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
            <h2 class="title"><?php echo $_SESSION['pseudo']; ?>, edit your account</h2>
            <form action="" method="post" class="form" onsubmit="this.action = (location.hostname === 'localhost' || location.hostname === '127.0.0.1') ? 'edit.php' : 'edit'; return true;">
                <div style="display: flex; gap:15px;">
                    <div class="avatar-choice">Choose your avatar
                        <input type="radio" id="samourai" name="avatar" value="https://zechifoumi.com/uploads/avatar/samourai.svg" checked />
                        <label class="avatar-label" for="samourai">
                            <img src="https://zechifoumi.com/uploads/avatar/samourai.svg">
                            <div>Samourai</div>
                        </label>
                    </div>
                    <div class="avatar-choice">
                        <input type="radio" id="samourai-2" name="avatar" value="https://zechifoumi.com/uploads/avatar/samourai-2.svg" />
                        <label class="avatar-label" for="samourai-2">
                            <img src="https://zechifoumi.com/uploads/avatar/samourai-2.svg">
                            <div>Samourai 2</div>
                        </label>
                    </div>
                </div>
                <div class="input-container">
                    <div class="inputBox">
                        <input class="input-text" id="pseudo" type="text" name="pseudo" value="<?php echo $_SESSION['pseudo']; ?>" minlength="2" maxlength="10" required>
                        <label for="pseudo">Pseudo</label>
                    </div>
                    <div class="inputBox">
                        <input class="input-text" id="email" type="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <label for="pseudo">Email</label>
                    </div>
                    <div class="inputBox">
                        <input class="input-text" type="password" id="password" name="password" placeholder="New password">
                        <label for="pseudo">Password</label>
                        <button type="button" class="field-button" onclick="showPassword('password', 'eye-icon')">
                            <i id="eye-icon" class="fa-regular fa-eye-slash"></i>
                        </button>
                    </div>
                    <div class="inputBox">
                        <input class="input-text" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
                        <label for="pseudo">Confirm password</label>
                        <button type="button" class="field-button" onclick="showPassword('confirm_password', 'eye-icon-confirm')">
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
                <button type="submit" class="button">Update change</button>
            </form>
            <form action="delete_account" method="post" class="loose deleteForm">
                <h4 class="font-bold">Danger zone</h4>
                <input type="hidden" name="user_id" value='<?= $_SESSION['user_id'] ?>'>
                <button type="button" class="button" onclick="confirmDelete(<?= $_SESSION['user_id'] ?>, 'Do you really want to delete your account?')">Delete my account</button>
            </form>
        </div>
    </section>
    <?php
    include('includes/footer.php');
    ?>