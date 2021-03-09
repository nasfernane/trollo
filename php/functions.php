<?php

function displayLog() {
    // affiche les options de login/signup/logout en fonction de la session utilisateur
    $isLogged = isset($_SESSION['userid']) ? true : false;

    return $isLogged 
    ? '<button class="header__auth--logout"><a href="?page=logout">Logout</a></button>'
    : '<button class="header__auth--login"><a href="?page=login">Login</a></button>
    <button class="header__auth--signup"><a href="?page=signup">Sign Up</a></button>';

}

// création d'un nouvel utilisateur avec hashage du mot de passe puis redirige vers home page
function createUser(string $newLogin, string $newPw, string $newPwConfirm, object $database) {
    $encryptedPw = password_hash($newPw, PASSWORD_BCRYPT);

    $createUser = $database->prepare("
        INSERT INTO 
        users (login, password) 
        VALUES (:login, :password)");
        
    $createUser->execute(array(
        ':login' => $newLogin,
        ':password' => $encryptedPw
    ));

    header('location: ?page=home');
}

// connexion d'un utilisateur déjà existant
function userLogin(string $login, string $pw, $database) {
    // construction et exécution de la requête
    $user = $database->prepare("
        SELECT * 
        FROM users
        WHERE login = '{$login}'
        ");
    $user->execute();
    $user = $user->fetchAll();

    // si l'utilisateur existe
    if ($user) {
        // récupération du mot de passe de l'utilisateur enregistré, puis vérification du mot de passe entré
        $userPassword = $user[0]['password'];
        $isCorrectPw = password_verify($pw, $userPassword);

        // si les identifiants sont corrects, crée la session et ajoute son id avant de rediriger vers home
        if ($isCorrectPw) {
            $_SESSION['userid'] = $user[0]['idUser'];
            $_SESSION['wrongLogin'] = false;
            header('location: ?page/home');
        } else {
            $_SESSION['wrongLogin'] = true;
        }
    } else {
        $_SESSION['wrongLogin'] = true;
    }
    

}

// affiche les tâches existantes selon la table choisie
function displayTasks(string $table, object $database) {
    // définit le classement en fonction du type de liste
    $orderBy = $table === 'eventtask' ? 'date' :'dateCreation';
    $idUser = $_SESSION['userid'];

    // récupère les tâches de l'utilisateur
    $userTasks = $database->prepare("
        SELECT * 
        FROM {$table} 
        WHERE idUser = '{$idUser}'
        ORDER BY {$orderBy} ASC");
    $requestStatus = $userTasks->execute();

    // si la requête est réussie, combine chaque tâche dans un ensemble HTML et le retourne
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

// affiche une liste en fonction de la table choisie dans une BDD
function displayList(string $table, object $database) {
    // récupère les tâches correspondantes
    $displayTasks = displayTasks("{$table}task", $database);
    // formate le titre de la liste
    $title = strtoupper($table[0]) . substr($table, 1);
    // récupération de la date
    $today = date('Y-m-d');
    // création de l'input calendrier pour la liste d'events
    $datepicker = $table === 'event'? "
        <span class='datePicker'>
            <span class='datePicker__button'></span>
            <input name='eventdate' type='date' value='$today' min='$today' class='datePicker__input' />
        </span>" 
        : '';
    

    // renvoie un ensemble HTML affichant la liste ainsi que toutes ses tâches récupérées dans $displayTasks, en ajoutant le calendrier si nécessaire
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
    // récupération de la tâche à ajouter
    $task = htmlentities($_POST[$table], ENT_QUOTES);
    // récupère la date si présente (dans le cas de la liste events)
    $date = isset($_POST['eventdate']) ? $_POST['eventdate'] : '';
    $idUser = $_SESSION['userid'];

    // construit la requête en fonction de la présence ou non d'une date d'évènement
    if (!$date) {
        $addTask = $database->prepare("
        INSERT INTO
        $table (Nom, idUser)
        VALUES (:task, :idUser)");

        // exécute la requête
        $addTask->execute(array(
        ':task' => $task,
        ':idUser' => $idUser
        ));  
    } else {
        $addTask = $database->prepare("
            INSERT INTO
            $table (Nom, idUser, Date)
            VALUES (:task, :idUser, :date)");

        // exécute la requête
        $addTask->execute(array(
            ':task' => $task,
            ':date' => $date,
            ':idUser' => $idUser
        ));
    } 
}

// supprime une tâche de la bdd
function removeTask (object $database, string $table) {
    // récupère le nom de la tâche à supprimer
    $task = htmlentities($_POST["{$table}_delete"], ENT_QUOTES);
    $idUser = $_SESSION['userid'];

    // première requête pour récupérer son ID dans la BDD
    $deletingId = $database->query("
    SELECT id{$table} FROM $table
    WHERE nom='{$task}' && idUser='{$idUser}'
    ");

    // fetch la première requête puis déstructure le tableau retourné
    $deletingId = $deletingId->fetchAll();
    $deletingId = $deletingId[0]["id{$table}"];

    // deuxième requête pour supprimer la tâche avec l'id récupéré
    $removeTask = "
        DELETE FROM $table
        WHERE id{$table}='{$deletingId}'
    ";
    $database->exec($removeTask);
}  

// définit une tâche comme urgent
function defineUrgentTask (object $database, string $table) {
    // récupération du nom de la tâche
    $task = htmlentities($_POST["{$table}_clock"], ENT_QUOTES);
    $idUser = $_SESSION['userid'];

    // première requête pour récupérer l'id de la tâche à supprimer
    $taskId = $database->query("
    SELECT id{$table} FROM $table
    WHERE nom='{$task}' && idUser='{$idUser}'
    ");

    // fetch la deuxième requête puis déstructure le tableau retourné
    $taskId = $taskId->fetchAll();
    $taskId = $taskId[0]["id{$table}"];

    // définit la tâche ou l'évènement comme urgent(e) avec l'id récupéré
    $modifyTask = "
        Update $table
        SET urgent = NOT urgent
        WHERE id{$table}='{$taskId}'
    ";
    $database->exec($modifyTask);


}


?>