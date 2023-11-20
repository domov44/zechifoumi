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

    if (!empty($password) && $password === $confirmPassword) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $conn = connectDB();

            $stmt = $conn->prepare("UPDATE user SET pseudo=?, email=?, password=? WHERE id=?");

            $user_id = $_SESSION['user_id'];

            $stmt->bind_param("sssi", $pseudo, $email, $passwordHash, $user_id);

            if ($stmt->execute()) {
                $_SESSION['pseudo'] = $pseudo;
                header("Location: index.php");
                exit();
            } else {
                $message = "Error modifying the account. Please try again later.";
                error_log("Error modifying the account: " . $stmt->error);
                $class = "loose";
            }

            $stmt->close();
            $conn->close();
        } else {
            $message = "Invalid email address. Please provide a valid email address.";
            $class = "loose";
        }
    } elseif (empty($password)) {
        $conn = connectDB();

        $stmt = $conn->prepare("UPDATE user SET pseudo=?, email=? WHERE id=?");

        $user_id = $_SESSION['user_id'];

        $stmt->bind_param("ssi", $pseudo, $email, $user_id);

        if ($stmt->execute()) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $message = "Error modifying the account. Please try again later.";
            error_log("Error modifying the account: " . $stmt->error);
            $class = "loose";
        }

        $stmt->close();
        $conn->close();
    } else {
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
                <h2 class="title"><?php echo $_SESSION['pseudo']; ?>, edit your account</h2>
                <form action="edit.php" method="post" class="form">
                    <div class="input-container">
                        <input class="input-text" id="pseudo" type="text" name="pseudo" placeholder="Pseudo" value="<?php echo $_SESSION['pseudo']; ?>" minlength="2" maxlength="10" required>
                        <input class="input-text" id="email" type="email" name="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>" required>
                        <input class="input-text" type="password" id="password" name="password" placeholder="New password">
                        <input class="input-text" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
                        <?php if (!empty($message) && $class === "loose") : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error !</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Update change</button>
                    <a class="lien" href="index.php">Cancel</a>
                </form>
            </div>
        </section>
        <?php
        include('includes/footer.php');
        ?>
    </main>
</body>

</html>