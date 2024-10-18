<?php
// Fonction pour charger le fichier .env et stocker les valeurs dans $_ENV
function loadEnv($path) {
    if (!file_exists($path)) {
        throw new \Exception(".env file not found.");
    }
    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($lines as $line) {
        // Ignorer les lignes de commentaire
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Séparer la clé et la valeur
        list($name, $value) = explode('=', $line, 2);

        // Enlever les guillemets et les espaces blancs autour de la valeur
        $name = trim($name);
        $value = trim($value);

        // Définir la variable dans $_ENV
        $_ENV[$name] = $value;
    }
}
