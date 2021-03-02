<?php

    // identifiants
    $servername = 'localhost';
    $username = 'root';
    $password = '';

    // connexion à la bdd et récupération des exceptions
    try {
        $dbco = new PDO("mysql:host=$servername;dbname=todolist;charset=utf8;port=3306", $username, $password);
        $dbco->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie";
        // $sql = "CREATE DATABASE pdodb";
        // $dbco->exec($sql);
        
    } catch (PDOException $err) {
        echo "Erreur : " . $err->getMessage();
    }

    // fermeture du serveur
    // $connexion = null;
    

    if (isset($_POST['task'])) {
        $task = $_POST['task'] . "\n";
        file_put_contents('list.txt', $task, FILE_APPEND);
        header("Location: /");
    }

    if (isset($_POST['delete'])) {
        $deletingTask = (int) $_POST['delete'];
        $file = explode("\n", file_get_contents('list.txt'));
        unset($file[$deletingTask]);
        file_put_contents('list.txt', implode("\n", $file));
    }

    function displayTasks($args) {
        $tasks = explode("\n", $args);
        foreach ($tasks as $task) { 
            if ($task) {
                echo <<<HTML
                <div class="task">
                    <li>$task</li>
                    <form method="POST">
                        <button name="delete" value="$task">X</button>
                    </form>
                </div>
HTML;
            } 
        }
    }
?>