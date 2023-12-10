<?php
class ToastHandler {
    private $events;

    public function __construct() {
        $this->events = array(
            'modification_reussie' => array('success', 'Le compte a bien été modifié'),
            'modification_echoue' => array('error', 'Le compte n\'a pas été sauvegardé'),
            'ajout_reussie' => array('success', 'Le compte a bien été ajouté'),
            'ajout_echoue' => array('error', 'Le compte n\'a pas été ajouté'),
            'supp_reussie' => array('success', 'Le compte a bien été supprimé'),
            'supp_echoue' => array('error', 'Le compte n\'a pas été supprimé'),
            'connexion_reussie' => array('success', 'Connexion établie, bienvenue'),
            'deconnexion_reussie' => array('success', 'Vous avez été déconnecté, à bientôt'),
        );
    }

    public function afficherToasts() {
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