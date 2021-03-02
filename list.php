<?php
    require_once 'hostconfig.php';

    // connexion à la bdd et récupération des exceptions
    try {
        $tododb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['task'])) {
            $task = $_POST['task'];
            
            $addTask = $tododb->prepare("
                INSERT INTO
                Tasks (Nom)
                VALUES (:task)");

            $addTask->execute(array(
                ':task' => $task,
            ));

            echo "Nouvelle tâche ajoutée";
        }

        if (isset($_POST['delete'])) {
            $deletingTask = $_POST['delete'];

            $removeTask = $tododb->prepare("
                DELETE FROM Tasks 
                WHERE nom='{$deletingTask}'
            ");

            $removeTask->execute();

            echo "Tâche supprimée";
        }
        
        
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }

    // fermeture du serveur
    // $connexion = null;
    

    
?>