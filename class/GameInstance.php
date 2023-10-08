<?php
require_once 'choice.php';

class GameInstance
{
    public $GameName = 'chifoumi';
    public $choices;
    public $result;
    public $username;
    public $valueComputerChoice;

    public function startChifoumi()
    {
        $choice1 = new Choice('Rocks', 'pierre', 'Paper');
        $choice2 = new Choice('Paper', 'feuille', 'Scissors');
        $choice3 = new Choice('Scissors', 'ciseau', 'Rocks');

        $this->choices = array($choice1, $choice2, $choice3);
    }

    
    public function register($pseudo)
    {
        $_SESSION['pseudo'] = $pseudo;
        $this->username = $pseudo;
    }

    public function play($userchoice)
    {
        $this->startChifoumi();
        $computerIndex = array_rand($this->choices, 1);
        $computerChoice = $this->choices[$computerIndex];
        $this->valueComputerChoice = $computerChoice->value;
        $nemesisComputer = $computerChoice->nemesisValue;

        $this->result = $this->compareChoice($this->valueComputerChoice, $userchoice, $nemesisComputer);

        if (!file_exists("storage")) {
            mkdir("storage", 0777, true);
        }

        $filename = "storage/data.json";
        $pseudo = $_SESSION["pseudo"];

        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $contentd = json_decode($content, true);
        } else {
            $contentd = array();
        }

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


        file_put_contents($filename, json_encode($contentd));
    }

    public function getLeaderboard() {
        $filename = "storage/data.json";

        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $data = json_decode($content, true);
        } else {
            $data = array();
        }

        $leaderboard = array();

        foreach ($data as $key => $value) {
            if (isset($value['bestWinstreak'])) {
                $leaderboard[] = array(
                    'rank' => 0, 
                    'pseudo' => $value['pseudo'],
                    'bestWinstreak' => $value['bestWinstreak']
                );
            }
        }

        usort($leaderboard, function ($a, $b) {
            return $b['bestWinstreak'] - $a['bestWinstreak'];
        });

        $rank = 1;
        foreach ($leaderboard as &$rankedPlayer) {
            $rankedPlayer['rank'] = $rank;
            $rank++;
        }

        return $leaderboard;
    }

    public function getPlayerRank($pseudo) {
        $leaderboard = $this->getLeaderboard();
        
        foreach ($leaderboard as $rankedPlayer) {
            if ($rankedPlayer['pseudo'] === $pseudo) {
                return $rankedPlayer['rank'];
            }
        }
        
        return null;
    }

    function compareChoice($valueComputerChoice, $userchoice, $nemesisComputer)
    {
        if ($valueComputerChoice == $userchoice) {
            $_SESSION['winStreak'] = 0;
            return "Egality";
        } elseif ($userchoice == $nemesisComputer) {
            $_SESSION['score']['user']++;
            $_SESSION['winStreak']++;
            return "You won !";
        } else {
            $_SESSION['score']['ia']++;
            $_SESSION['winStreak'] = 0;
            return "You lost..";
        }
    }
}
