<?php
require_once 'choice.php';
require_once 'Player.php';
require_once 'authentification/db.php';

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

        $this->updateLeaderboard($_SESSION['pseudo'], $_SESSION['bestwinstreak']);
    }

    public function getLeaderboard()
    {
        $conn = connectDB();

        $sql = "SELECT pseudo, bestwinstreak FROM user WHERE bestwinstreak > 0 ORDER BY bestwinstreak DESC";

        $result = $conn->query($sql);

        $leaderboard = array();
        $rank = 1;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $leaderboard[] = array(
                    'rank' => $rank, 
                    'pseudo' => $row['pseudo'],
                    'bestwinstreak' => $row['bestwinstreak']
                );
                $rank++; 
            }
        }

        $conn->close();

        return $leaderboard;
    }

    public function updateLeaderboard($pseudo, $bestwinstreak)
    {
        $conn = connectDB();
        $sql = "UPDATE user SET bestwinstreak = $bestwinstreak WHERE pseudo = '$pseudo'";
        $conn->query($sql);

        $conn->close();
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
