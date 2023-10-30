<?php
// data json
class CreateDB
{
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

        return $contentd; // Retourne le tableau contentd
    }

    public function writeToJsonFile($pseudo)
    {
        $contentd = $this->createJsonFile();
        
        $found = false;
        $bestwinstreak = 0;

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
                "bestWinstreak" => $bestwinstreak
            );
            $contentd[] = $newData;
        }

        $filename = "storage/data.json";
        file_put_contents($filename, json_encode($contentd));
    }
}
