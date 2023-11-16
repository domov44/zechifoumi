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
    
    private function insertOrUpdateMySQL($pseudo)
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
    $newWinstreak = $_SESSION['winStreak'];
    $bestwinstreak = max($currentBestWinstreak, $newWinstreak);

    if ($userId) {
        // Mettre à jour les informations pour l'utilisateur existant
        $updateSql = "UPDATE user SET score = ?, winstreak = ?, bestwinstreak = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($this->conn, $updateSql);
        $score = $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'];
        $winstreak = $_SESSION['winStreak'];
        mysqli_stmt_bind_param($updateStmt, "sssd", $score, $winstreak, $bestwinstreak, $userId);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    } else {
        // Créer une nouvelle entrée pour l'utilisateur
        $insertSql = "INSERT INTO user (pseudo, email, score, winstreak, bestwinstreak) VALUES (?, 'Testing@tesing.com', ?, ?, ?)";
        $insertStmt = mysqli_prepare($this->conn, $insertSql);
        $score = $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'];
        $winstreak = $_SESSION['winStreak'];
        mysqli_stmt_bind_param($insertStmt, "sssd", $pseudo, $score, $winstreak, $bestwinstreak);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);
    }
}

    private function updateJsonFile($pseudo, &$contentd)
    {
        $found = false;

        foreach ($contentd as &$value) {
            if ($value["pseudo"] === $pseudo) {
                $value['score'] = $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'];
                $value['winstreak'] = $_SESSION['winStreak'];
                $value['bestWinstreak'] = max($value['bestWinstreak'], $_SESSION['winStreak']);
                $found = true;
                break;
            }
        }

        if (!$found) {
            $newData = array(
                "pseudo" => $pseudo,
                "score" => $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'],
                "winstreak" => $_SESSION['winStreak'],
                "bestWinstreak" => 0
            );
            $contentd[] = $newData;
        }

        $filename = "storage/data.json";
        file_put_contents($filename, json_encode($contentd));
    }

    public function writeData($pseudo)
    {
        $contentd = $this->createJsonFile();

        $this->insertOrUpdateMySQL($pseudo);

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
?>
