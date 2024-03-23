<?php
class ToastHandler
{
    private $events;

    public function __construct()
    {
        $this->events = array(
            'modification_reussie' => array('success', 'The account has been successfully modified'),
            'modification_echoue' => array('error', 'The account could not be saved'),
            'ajout_reussie' => array('success', 'The account has been successfully added'),
            'ajout_echoue' => array('error', 'The account could not be added'),
            'supp_reussie' => array('success', 'The account has been successfully deleted'),
            'supp_echoue' => array('error', 'The account could not be deleted'),
            'connexion_reussie' => array('success', 'Connection established, welcome'),
            'connexion_echoue' => array('error', 'You have not been logged in'),
            'creation_compte_reussie' => array('success', 'Account created, welcome'),
            'creation_compte_echoue' => array('error', 'Your account has not been created'),
            'deconnexion_reussie' => array('success', 'You have been logged out, see you soon'),
            'deconnexion_echoue' => array('error', 'You have not been logged out'),
        );
    }

    public function afficherToasts()
    {
        foreach ($this->events as $cle => $valeur) {
            $type = $valeur[0];
            $message = $valeur[1];

            if (isset($_SESSION[$cle]) && $_SESSION[$cle]) {
                echo '<script>afficherToast("' . $message . '", "' . $type . '");</script>';
                unset($_SESSION[$cle]);
            }
        }
    }
}
