<?php

session_start();
$id_session = session_id();
$_SESSION['wrongPwCreate'] = false;

$host = 'mysql:host=localhost;dbname=trollo';
// connexion à la bdd et récupération des exceptions
try {
    $tododb = new PDO($host, 'root', '');
    $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
// récupération des exceptions
} catch (PDOException $err) {
    echo "Erreur : " . $err->getMessage();
}

