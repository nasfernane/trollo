<?php
// affiche les tâches existantes selon la table choisie
function displayTasks(string $table) {
    $host = 'mysql:host=localhost;dbname=trollo';
    $tododb = new PDO($host, 'root', '');
    $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $userTasks = $tododb->prepare("SELECT * FROM {$table}");
    $requestStatus = $userTasks->execute();

    if ($requestStatus) {
        $html = '';
        foreach ($userTasks as $task) {
            $html .= "
                <div class='task'>
                    <li>$task[nom]</li>
                    <form method='POST'>
                        <button class='deleteBtn' name='$table-delete' value='$task[nom]' title='Supprimer'><img src='/assets/img/delete.png' alt='Supprimer Tâche'></button>
                    </form>
                </div>";
        }
        return $html;
    }
};

function displayList(string $table) {
    $displayTasks = displayTasks("{$table}task");
    $title = strtoupper($table[0]) . substr($table, 1);

    return <<<HTML
        <section class="todoContainer__list todoContainer__list--{$table}">
            <header class="todoContainer__list__header">
                <img src="/assets/img/{$table}.png" alt="">
                <h2>TO-DO {$title}</h2>
            </header>
            
            <form method="POST" class="todoContainer__list__form">
                <label for="form__input">Ajouter</label>
                <input name="{$table}task" type="text" id="form__input" autocomplete="off">
                <button class="addBtn" title="Ajouter"><img src="/assets/img/add-button.png" alt="Add Button"></button> 
            </form>
            
            <ul>
                {$displayTasks} 
            </ul>
        </section>
HTML;
}



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

// supprime une tâche de la bdd
function removeTask (object $database, string $table, string $task) {

    // requête pour récupérer l'id de la tâche à supprimer
    $deletingId = $database->query("
    SELECT id{$table} FROM $table
    WHERE nom='{$task}'
    ");

    // déstructure le tableau retourné par le fetch de la requête
    $deletingId = $deletingId->fetchAll();
    $deletingId = $deletingId[0]["id{$table}"];

    // supprime la tâche avec l'id récupéré
    $removeTask = "
        DELETE FROM $table
        WHERE id{$table}='{$deletingId}'
    ";
    $database->exec($removeTask);
}
            
?>