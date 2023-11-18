<?php
require_once 'choice.php';
require_once 'Player.php';
require_once 'CreateDB.php';

class GameInstance
{
    public $GameName = 'chifoumi';
    public $choices;
    public $result;
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
    }

    public function getLeaderboard()
    {
        $filename = "storage/data.json";

        if (file_exists($filename)) {
            $content = file_get_contents($filename);
            $data = json_decode($content, true);
        } else {
            $data = array();
            var_dump('tets');
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

    public function getPlayerRank($pseudo)
    {
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
            $_SESSION['winstreak'] = 0;
            return "Egality";
        } elseif ($userchoice == $nemesisComputer) {
            $_SESSION['user_score']++;
            $_SESSION['winstreak']++;
            $_SESSION['bestwinstreak'] = max($_SESSION['bestwinstreak'], $_SESSION['winstreak']);
            return "You won !";
        } else {
            $_SESSION['computer_score']++;
            $_SESSION['winstreak'] = 0;
            return "You lost..";
        }
    }
}
