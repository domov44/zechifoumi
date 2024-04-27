<?php
define("DB_HOST", "localhost");
define("DB_USER", "bfxr3414_adminsupreme");
define("DB_PASSWORD", "AIo(Nw,*L=k,");
define("DB_NAME", "bfxr3414_zechifoumi");

function connectDB()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué: " . $conn->connect_error);
    }

    return $conn;
}

// local
// <?php
// define("DB_HOST", "localhost");
// define("DB_USER", "root");
// define("DB_PASSWORD", "");
// define("DB_NAME", "zechifoumi");

// function connectDB()
// {
//     $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//     if ($conn->connect_error) {
//         die("La connexion à la base de données a échoué: " . $conn->connect_error);
//     }

//     return $conn;
// }

