<?php 

Class Player
{
    public $username;

    public function register($pseudo)
    {
        $this->username = $pseudo;
    }
}