<?php
    $host = 'mysql:host=localhost;dbname=trollo';

    // connexion à la bdd et récupération des exceptions
    try {
        $tododb = new PDO($host, 'root', '');
        $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // si une requête post 'task' est définie et non nulle
        if (isset($_POST['hometask']) && ($_POST['hometask']) !== '') {
            $hometask = htmlentities($_POST['hometask'], ENT_QUOTES);
            addTask($tododb, 'hometask', $hometask);
        }

        // si une requête post 'task' est définie et non nulle
        if (isset($_POST['worktask']) && ($_POST['worktask']) !== '') {
            $worktask = htmlentities($_POST['worktask'], ENT_QUOTES);
            addTask($tododb, 'worktask', $worktask);
        }

        if (isset($_POST['hometask-delete'])) {
            $delHomeTask = htmlentities($_POST['hometask-delete'], ENT_QUOTES);
            removeTask($tododb, 'hometask', $delHomeTask);
        }

        if (isset($_POST['worktask-delete'])) {
            $delWorkTask = htmlentities($_POST['worktask-delete'], ENT_QUOTES);
            removeTask($tododb, 'worktask', $delWorkTask);
        }
        
    // récupération des exceptions
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }

?>