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

        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $contentd = json_decode($content, true);
        } else {
            $contentd = array();
        }

        $pseudo = $_SESSION["pseudo"];
        $found = false;

        foreach ($contentd as &$value) {
            if ($value["pseudo"] === $pseudo) {
                $value['score'] = $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'];
                $value['winstreak'] = $_SESSION['winStreak'];
                $found = true;
                break; 
            }
        }

        if (!$found) {
            $newData = array(
                "pseudo" => $pseudo,
                "score" => $_SESSION['score']['user'] . "-" . $_SESSION['score']['ia'],
                "winstreak" => $_SESSION['winStreak']
            );
            $contentd[] = $newData;
        }

        file_put_contents($filename, json_encode($contentd));
    }

    public function register($pseudo)
    {
        $_SESSION['pseudo'] = $pseudo;
        $this->username = $pseudo;
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
