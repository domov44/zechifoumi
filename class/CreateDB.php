<?php
class CreateDB
{
    private $conn;

    public function __construct()
    {
        $this->connectMySQL(); // Établir la connexion MySQL
    }

    public function connectMySQL()
    {
        $servername = "localhost";
        $database = "zechifoumi";
        $username = "root";
        $password = "";

        // Créer la connexion
        $this->conn = mysqli_connect($servername, $username, $password, $database);

        // Vérifier la connexion
        if (!$this->conn) {
            die("Échec de la connexion : " . mysqli_connect_error());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConnection()
    {
        mysqli_close($this->conn);
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


    private function updateJsonFile($pseudo, &$contentd)
    {
        $found = false;

        foreach ($contentd as &$value) {
            if ($value["pseudo"] === $pseudo) {
                $value['user_score'] = $_SESSION['user_score'];
                $value['computer_score'] = $_SESSION['computer_score'];
                $value['winstreak'] = $_SESSION['winstreak'];
                $value['bestwinstreak'] = max($value['bestwinstreak'], $_SESSION['winstreak']);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $newData = array(
                "pseudo" => $pseudo,
                "user_score" => $_SESSION['user_score'],
                "computer_score" => $_SESSION['computer_score'],
                "winstreak" => $_SESSION['winstreak'],
                "bestwinstreak" => 0
            );
            $contentd[] = $newData;
        }

        $filename = "storage/data.json";
        file_put_contents($filename, json_encode($contentd));
    }

    public function writeData($pseudo)
    {
        $contentd = $this->createJsonFile();

        $this->UpdateMysql($pseudo);

        $this->updateJsonFile($pseudo, $contentd);
    }

    public function createJsonFile()
    {
        if (!file_exists("storage")) {
            mkdir("storage", 0777, true);
        }

        $filename = "storage/data.json";

        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $contentd = json_decode($content, true);
        } else {
            $contentd = array();
        }

        return $contentd;
    }
}
