<?php 

// contient la session et la connexion à la BDD
require 'php/auth.php';
// contient toutes les fonctions
require 'php/functions.php'; 
// contrôle la BDD en appelant les fonctions selon les requêtes utilisateur
require 'php/databasecontroller.php'; 

// Début du layout : header
require 'php/layout/_header.php';

// Contenu principal, importé dynamiquement selon la requête URI
$path = substr($_SERVER['REQUEST_URI'], 7);
switch ($path) {
    case 'login':
        require 'php/views/login.php';
        break;
    case 'signup': 
        require 'php/views/signup.php';
        break;
    case 'logout':
        require 'php/views/logout.php';
        break;
    default: 
        require 'php/views/home.php';
}

// Fin du layout : Footer
require 'php/layout/_footer.php';


