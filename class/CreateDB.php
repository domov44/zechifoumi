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

    private function insertOrUpdateMySQL($pseudo)
    {
        // Récupérer la valeur actuelle de bestwinstreak
        $selectSql = "SELECT bestwinstreak FROM user WHERE pseudo = ?";
        $selectStmt = mysqli_prepare($this->conn, $selectSql);
        mysqli_stmt_bind_param($selectStmt, "s", $pseudo);
        mysqli_stmt_execute($selectStmt);
        mysqli_stmt_bind_result($selectStmt, $currentBestWinstreak);
        mysqli_stmt_fetch($selectStmt);
        mysqli_stmt_close($selectStmt);

        // Mettre à jour bestwinstreak si le nouveau winstreak est plus élevé
        $newWinstreak = $_SESSION['winStreak'];
        $bestwinstreak = max($currentBestWinstreak, $newWinstreak);

        $sql = "INSERT INTO user (pseudo, email, score, winstreak, bestwinstreak) 
                VALUES (?, 'Testing@tesing.com', ?, ?, ?)
                ON DUPLICATE KEY UPDATE score = VALUES(score), winstreak = VALUES(winstreak), bestwinstreak = ?";
        
        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            die("Erreur de préparation : " . mysqli_error($this->conn));
        }

        $score = $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'];
        $winstreak = $_SESSION['winStreak'];

        mysqli_stmt_bind_param($stmt, "ssssd", $pseudo, $score, $winstreak, $bestwinstreak, $bestwinstreak);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
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
