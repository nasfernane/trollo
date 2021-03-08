<?php 
require 'php/functions.php'; 
require 'php/database.php'; 

require 'components/_header.php';

$path = substr($_SERVER['REQUEST_URI'], 7);
switch ($path) {
    case 'login':
        require 'views/login.php';
        break;
    case 'signup': 
        require 'views/signup.php';
        break;
    default: 
        require 'views/home.php';
}


