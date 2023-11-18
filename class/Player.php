<?php
class Player
{
    public $username;

    public function __construct()
    {
        if (isset($_SESSION['pseudo'])) {
            $this->username = $_SESSION['pseudo'];
        } else {
            $this->username = "";
        }
    }
}
