<?php
require_once('authentification/db.php');
require_once('authentification/auth.php');
require_once('authentification/session.php');

$message = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conn = connectDB();

            $stmt = $conn->prepare("INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $pseudo, $email, $passwordHash);

            if ($stmt->execute()) {
                if (authenticateUser($pseudo, $password)) {
                    session_start();
                    $_SESSION['pseudo'] = $pseudo;
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "Error during login after registration.";
                    $class = "loose";
                }
            } else {
                $message = "Error during registration. Please try again later.";
                error_log("Error during registration: " . $stmt->error);
                $class = "loose";
            }

            $stmt->close();
            $conn->close();
        } else {
            $message = "Invalid email address. Please provide a valid email address.";
            $class = "loose";
        }
    } else {
        $message = "Passwords do not match. Please enter them again.";
        $class = "loose";
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
    <title>Signup</title>
    <link href="style/style.css" rel="stylesheet" />
    <link href="style/footer.css" rel="stylesheet" />
    <link href="font/font.css" rel="stylesheet" />
    <link rel="icon" type="image/svg" href="animation\ventilateur.svg" />
</head>

<body>
    <main class="contenu">
        <section class="container">
            <div class="title-section">
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
                <h1 class="title">The chifoumi game</h1>
                <img src="animation/ventilateur.svg" alt="ventilator" class="icon">
            </div>
            <div class="chifoumi-container">
                <h2 class="title">Signup</h2>
                <form action="signup.php" method="post" class="form">
                    <div class="input-container">
                        <div class="inputBox">
                            <input class="input-text" id="pseudo" type="text" name="pseudo" minlength="2" maxlength="10" required>
                            <label for="pseudo">Pseudo</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" id="email" type="email" name="email" required>
                            <label for="pseudo">Email</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" type="password" id="password" name="password" required>
                            <label for="pseudo">Password</label>
                        </div>
                        <div class="inputBox">
                            <input class="input-text" type="password" id="confirm_password" name="confirm_password" required>
                            <label for="pseudo">Confirm password</label>
                        </div>
                        <?php if (!empty($message) && $class === "loose") : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error !</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Signup</button>
                    <button class="button-secondary" onclick="window.location='login.php'">I have an account</button>
                </form>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
</body>

</html>