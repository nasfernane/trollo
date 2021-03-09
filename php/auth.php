<?php

// création de la session
session_start();
$id_session = session_id();
// variables par défault pour alerter l'utilisateur s'il entre des informations incorrectes
$_SESSION['wrongPwCreate'] = false;
$_SESSION['wrongLogin'] = false;


// Connexion à la BDD et récupération des exceptions
// $host = 'mysql:host=mysql-nasfernane.alwaysdata.net;dbname=nasfernane_trollodb';
try {
    $tododb = new PDO(getenv('DATABASE'), getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
    $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
// récupération des exceptions
} catch (PDOException $err) {
    echo "Erreur : " . $err->getMessage();
}

