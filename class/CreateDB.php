<?php
require_once('authentification/db.php');

class CreateDB
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function UpdateMysql($pseudo)
    {
        // Récupérer la valeur actuelle de bestwinstreak
        $selectSql = "SELECT id, bestwinstreak FROM user WHERE pseudo = ?";
        $selectStmt = mysqli_prepare($this->conn, $selectSql);
        mysqli_stmt_bind_param($selectStmt, "s", $pseudo);
        mysqli_stmt_execute($selectStmt);
        mysqli_stmt_bind_result($selectStmt, $userId, $currentBestWinstreak);
        mysqli_stmt_fetch($selectStmt);
        mysqli_stmt_close($selectStmt);

        // Mettre à jour bestwinstreak si le nouveau winstreak est plus élevé
        $newWinstreak = $_SESSION['winstreak'];
        $bestwinstreak = max($currentBestWinstreak, $newWinstreak);

        if ($userId) {
            // Mettre à jour les informations pour l'utilisateur existant
            $updateSql = "UPDATE user SET user_score = ?, computer_score = ?, winstreak = ?, bestwinstreak = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($this->conn, $updateSql);
            $userscore = $_SESSION['user_score'];
            $computerscore = $_SESSION['computer_score'];
            $winstreak = $_SESSION['winstreak'];
            mysqli_stmt_bind_param($updateStmt, "ssssd", $userscore, $computerscore, $winstreak, $bestwinstreak, $userId);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        }
    }

    public function writeData($pseudo)
    {
        $this->UpdateMysql($pseudo);
    }
}
