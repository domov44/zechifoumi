<?php
require_once('authentification/db.php');
require_once('authentification/auth.php');
require_once('authentification/session.php');

$message = "";
$class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $conn = connectDB();

        $stmt = $conn->prepare("INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $pseudo, $email, $password);

        if ($stmt->execute()) {
            if (authenticateUser($pseudo, $_POST['password'])) {
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
                        <input class="input-text" id="pseudo" type="text" name="pseudo" placeholder="Pseudo" minlength="2" maxlength="10" required>
                        <input class="input-text" id="email" type="email" name="email" placeholder="Email" required>
                        <input class="input-text" type="password" id="password" name="password" placeholder="Password" required>
                        <?php if (!empty($message) && $class === "loose") : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error !</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Signup</button>
                    <p>You have already an account ? <a class="lien" id="icon-alternate" href="https://www.zechifoumi.com/login.php">Login</a></p>
                </form>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
</body>

</html>