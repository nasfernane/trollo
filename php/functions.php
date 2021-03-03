<?php

// affiche les tâches existantes selon la table choisie
function displayTasks(string $table) {
    $host = 'mysql:host=localhost;dbname=trollo';
    $tododb = new PDO($host, 'root', '');
    $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $userTasks = $tododb->prepare("SELECT * FROM {$table}");
    $requestStatus = $userTasks->execute();

    if ($requestStatus) {
        foreach ($userTasks as $task) {
            echo <<<HTML
                    <div class="task">
                        <li>$task[nom]</li>
                        <form method="POST">
                            <button class="deleteBtn" name="delete" value="$task[nom]" title="Supprimer"><img src="/assets/img/delete.png" alt="Supprimer Tâche"></button>
                        </form>
                    </div>
HTML;
        }
    }
};

// ajoute une tâche à la bdd
function addTask (object $database, string $table, string $task) {
    $addTask = $database->prepare("
                INSERT INTO
                $table (Nom)
                VALUES (:task)");

            // exécute la requête
            $addTask->execute(array(
                ':task' => $task,
            ));
}

function removeTask (object $database, string $table, string $task) {

    // requête pour récupérer l'id de la tâche à supprimer
    $deletingId = $database->query("
    SELECT idTask FROM $table
    WHERE nom='{$task}'
    ");

    // déstructure le tableau retourné par le fetch de la requête
    $deletingId = $deletingId->fetchAll();
    $deletingId = $deletingId[0]['idTask'];

    // supprime la tâche avec l'id récupéré
    $removeTask = "
        DELETE FROM $table
        WHERE idTask='{$deletingId}'
    ";
    $database->exec($removeTask);

}
            

?>