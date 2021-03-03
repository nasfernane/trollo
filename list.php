<?php
    $host = 'mysql:host=localhost;dbname=trollo';

    // connexion à la bdd et récupération des exceptions
    try {
        $tododb = new PDO($host, 'root', '');
        $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // si une requête post 'task' est définie et non nulle
        if (isset($_POST['hometask']) && ($_POST['hometask']) !== '') {
            $task = htmlentities($_POST['hometask'], ENT_QUOTES);
            addTask($tododb, 'home', $task);
        }

        if (isset($_POST['delete'])) {
            $deletingTask = htmlentities($_POST['delete'], ENT_QUOTES);
            removeTask($tododb, 'home', $deletingTask);
        }
        
    // récupération des exceptions
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }


?>