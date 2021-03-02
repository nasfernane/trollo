<?php
    $host = 'mysql:host=localhost;dbname=todolist';

    // connexion à la bdd et récupération des exceptions
    try {
        $tododb = new PDO($host, 'root', '');
        $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // si une requête post 'task' est définie
        if (isset($_POST['task'])) {
            $task = htmlspecialchars($_POST['task']);
            
            // requête préparée avec marqueur nommé pour ajouter une nouvelle tâche
            $addTask = $tododb->prepare("
                INSERT INTO
                Tasks (Nom)
                VALUES (:task)");

            // exécute la requête
            $addTask->execute(array(
                ':task' => $task,
            ));

            echo "Nouvelle tâche ajoutée";
        }

        if (isset($_POST['delete'])) {
            // convertir les entitées HTML en ignorant les guillemets simples
            $deletingTask = htmlspecialchars($_POST['delete']);

            print_r('deleting task : ' . $deletingTask . "<br/>");

            // requête pour récupérer l'id de la tâche à supprimer
            $deletingId = $tododb->query("
                SELECT idTask FROM Tasks
                WHERE nom='{$deletingTask}'
            ");
            // déstructure le tableau retourné par le fetch de la requête
            [$deletingId] = ($deletingId->fetchAll());
            $deletingId = $deletingId['idTask'];

            print_r('formated ID : ' . $deletingId . "<br/>");
            // supprime la tâche avec l'id récupéré
            $removeTask = "
                DELETE FROM Tasks 
                WHERE idTask='{$deletingId}'
            ";
            $tododb->exec($removeTask);

            echo "Tâche supprimée";
        }
        
    // récupération des exceptions
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }


?>