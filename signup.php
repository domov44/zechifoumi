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

    // Vérifier si l'email existe déjà
    $conn = connectDB();
    $stmt_email = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt_email->bind_param("s", $email);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();
    if ($result_email->num_rows > 0) {
        $message = "Email already exists. Please choose a different one.";
        $class = "loose";
    }

    // Vérifier si le pseudo existe déjà
    $stmt_pseudo = $conn->prepare("SELECT id FROM user WHERE pseudo = ?");
    $stmt_pseudo->bind_param("s", $pseudo);
    $stmt_pseudo->execute();
    $result_pseudo = $stmt_pseudo->get_result();
    if ($result_pseudo->num_rows > 0) {
        $message = "Pseudo already exists. Please choose a different one.";
        $class = "loose";
    }

    // Fermer les requêtes préparées
    $stmt_email->close();
    $stmt_pseudo->close();

    if ($message === "") {
        // Si ni l'email ni le pseudo n'existe, alors procéder à l'insertion
        if ($password === $confirmPassword) {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $stmt_insert = $conn->prepare("INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)");
                $stmt_insert->bind_param("sss", $pseudo, $email, $passwordHash);

                if ($stmt_insert->execute()) {
                    if (authenticateUser($pseudo, $password)) {
                        session_start();
                        $_SESSION['creation_compte_reussie'] = true;
                        $_SESSION['pseudo'] = $pseudo;
                        header("Location: index.php");
                        exit();
                    } else {
                        $message = "Error during login after registration.";
                        $class = "loose";
                    }
                } else {
                    $message = "Error during registration. Please try again later.";
                    $_SESSION['creation_compte_echoue'] = true;
                    error_log("Error during registration: " . $stmt_insert->error);
                    $class = "loose";
                }

                $stmt_insert->close();
            } else {
                $message = "Invalid email address. Please provide a valid email address.";
                $_SESSION['creation_compte_echoue'] = true;
                $class = "loose";
            }
        } else {
            $message = "Passwords do not match. Please enter them again.";
            $_SESSION['creation_compte_echoue'] = true;
            $class = "loose";
        }
    }

    $conn->close();
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
    <title>Signup</title>
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
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
                <h2 class="title">Sign up</h2>
                <form method="post" class="form">
                    <div class="input-container">
                        <div class="inputBox">
                            <input class="input-text" id="pseudo" type="text" name="pseudo" minlength="2" maxlength="10" required value="<?php echo isset($pseudo) ? htmlspecialchars($pseudo) : ''; ?>">
                            <label for="pseudo">Pseudo</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" id="email" type="email" name="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                            <label for="pseudo">Email</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" type="password" id="password" name="password" required value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
                            <label for="pseudo">Password</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" type="password" id="confirm_password" name="confirm_password" required value="<?php echo isset($confirmPassword) ? htmlspecialchars($confirmPassword) : ''; ?>">
                            <label for="pseudo">Confirm password</label>
                        </div>
                        <?php if (!empty($message) && $class === "loose") : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error !</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Sign up</button>
                    <a class="button-secondary" href="login.php">I already have an account</a>
                </form>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
</body>

</html>