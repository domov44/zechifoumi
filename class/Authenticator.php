<?php
require_once 'CreateDB.php';
class Authenticator
{
    public static function authenticate($pseudo, $password)
    {
        $db = new CreateDB();
        $conn = $db->getConnection();

        $pseudo = mysqli_real_escape_string($conn, $pseudo);

        $query = "SELECT * FROM user WHERE pseudo=?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $pseudo);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                $user = mysqli_fetch_assoc($result);

                // Comparaison du mot de passe non haché
                if ($user && $password == $user['password']) {
                    $_SESSION["pseudo"] = $pseudo;
                    header("Location: index.php");
                    exit();
                }
                // Comparaison du mot de passe haché
                elseif ($user && password_verify($password, $user['password'])) {
                    $_SESSION["pseudo"] = $pseudo;
                    header("Location: index.php");
                    exit();
                } else {
                    return "Pseudo ou mot de passe incorrect.";
                }
            } else {
                return "Erreur de requête.";
            }

            mysqli_stmt_close($stmt);
        } else {
            return "Erreur de préparation de la requête.";
        }

        $db->closeConnection();
    }
}
