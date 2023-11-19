<?php
require_once('authentification/auth.php');
require_once('authentification/session.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    if (authenticateUser($pseudo, $password)) {
        header("Location: index.php");
        exit();
    } else {
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
                <h2 class="title">Login</h2>
                <form method="post" class="form">
                    <div class="input-container">
                        <input class="input-text" id="pseudo" type="text" name="pseudo" placeholder="Pseudo" minlength="2" maxlength="10" required>
                        <input class="input-text" id="password" type="password" name="password" placeholder="Password" required>
                        <?php if (!empty($message)) : ?>
                            <div class="loose" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span><?php echo $message; ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="button">Login</button>
                    <p>You don't have an account ? <a class="lien" id="icon-alternate" href="https://www.zechifoumi.com/signup.php">Signup</a></p>
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