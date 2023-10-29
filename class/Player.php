<?php 
class Player
{
    public $username;

    public function register($pseudo)
    {
        $this->username = $pseudo;
        $_SESSION['pseudo'] = $pseudo;
    }
}
