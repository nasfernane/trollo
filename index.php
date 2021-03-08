<?php 
require 'php/auth.php'; 
require 'php/functions.php'; 
require 'php/databasecontroller.php'; 

require 'php/layout/_header.php';

$path = substr($_SERVER['REQUEST_URI'], 7);
switch ($path) {
    case 'login':
        require 'php/views/login.php';
        break;
    case 'signup': 
        require 'php/views/signup.php';
        break;
    default: 
        require 'php/views/home.php';
}

require 'php/layout/_footer.php';


