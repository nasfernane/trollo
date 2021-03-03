<?php
    $host = 'mysql:host=localhost;dbname=trollo';

    // connexion à la bdd et récupération des exceptions
    try {
        $tododb = new PDO($host, 'root', '');
        $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST)) {
            foreach ($_POST as $field => $value) {
                // vérifie si le champ contient 'delete"
                $delete = isset(explode('_', $field)[1]) && explode('_', $field)[1] === 'delete'  ? true : false;
                
                if ($delete) {
                    $deleteField = explode('_', $field)[0];
                    removeTask($tododb, $deleteField);
                } else if ($value !== '') {
                    addTask($tododb, $field);
                }
            }
        }
        
    // récupération des exceptions
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }

?>