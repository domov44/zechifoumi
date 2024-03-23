<?php
class Score
{
    public $userScore;
    public $computerScore;

    public function __construct()
    {
        if (isset($_SESSION['user_score']) && isset($_SESSION['computer_score'])) {
            $this->userScore = $_SESSION['user_score'];
            $this->computerScore = $_SESSION['computer_score'];
        } else {
            $this->userScore = 0;
            $this->computerScore = 0;
        }
    }
}
?>
