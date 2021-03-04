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
            $date = isset($task['date']) ? '(' . $task['date'] . ')' : '';
            $urgent = $task['urgent'] ? 'class="urgentTask"' : '';
            
            $html .= "
                <div class='task'>
                    <li $urgent>$task[nom] $date</li>
                    <form method='POST'>
                        <button class='clockBtn' name='{$table}_clock' value='$task[nom]' title='Définir urgence'><img src='/assets/img/urgent.png' alt='Définir urgence'></button>
                        <button class='deleteBtn' name='{$table}_delete' value='$task[nom]' title='Supprimer'><img src='/assets/img/delete.png' alt='Supprimer Tâche'></button>
                    </form>
                </div>";
        }
        return $html;
    }
};

function displayList(string $table) {
    $displayTasks = displayTasks("{$table}task");
    $title = strtoupper($table[0]) . substr($table, 1);
    $today = date('Y-m-d');
    $datepicker = $table === 'event'? "
        <span class='datePicker'>
            <span class='datePicker__button'></span>
            <input name='eventdate' type='date' value='$today' min='$today' class='datePicker__input' />
        </span>" 
        : '';
    

    return <<<HTML
        <section class="todoContainer__list todoContainer__list--{$table}">
            <header class="todoContainer__list__header">
                <img src="/assets/img/{$table}.png" alt="">
                <h2>TO-DO {$title}</h2>
            </header>
            
            <form method="POST" class="todoContainer__list__form">
                <label for="form__input">Add</label>
                <input name="{$table}task" type="text" id="form__input" autocomplete="off" />
                {$datepicker}
                <button class="addBtn" title="Ajouter"><img src="/assets/img/add-button.png" alt="Add Button"></button> 
            </form>
            
            <ul>
                {$displayTasks} 
            </ul>
        </section>
HTML;
}

// ajoute une tâche à la bdd
function addTask (object $database, string $table) {
    $task = htmlentities($_POST[$table], ENT_QUOTES);
    $date = $_POST['eventdate'] ?? '';

    if (!$date) {
        $addTask = $database->prepare("
        INSERT INTO
        $table (Nom)
        VALUES (:task)");

        // exécute la requête
        $addTask->execute(array(
        ':task' => $task,
        ));  
    } else {
        $addTask = $database->prepare("
                INSERT INTO
                $table (Nom, Date)
                VALUES (:task, :date)");

    // exécute la requête
    $addTask->execute(array(
        ':task' => $task,
        ':date' => $date
    ));
    } 
}

// supprime une tâche de la bdd
function removeTask (object $database, string $table) {
    $task = htmlentities($_POST["{$table}_delete"], ENT_QUOTES);

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

// définit une tâche comme urgent
function defineUrgentTask (object $database, string $table) {
    $task = htmlentities($_POST["{$table}_clock"], ENT_QUOTES);

    // requête pour récupérer l'id de la tâche à supprimer
    $taskId = $database->query("
    SELECT id{$table} FROM $table
    WHERE nom='{$task}'
    ");

    // déstructure le tableau retourné par le fetch de la requête
    $taskId = $taskId->fetchAll();
    $taskId = $taskId[0]["id{$table}"];

    // supprime la tâche avec l'id récupéré
    $modifyTask = "
        Update $table
        SET urgent = NOT urgent
        WHERE id{$table}='{$taskId}'
    ";
    $database->exec($modifyTask);


}


?>