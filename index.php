<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>To Do list</title>
        <link rel="stylesheet" href="style.css" />
    </head>
    <body>
        <main>
            <?php require_once 'functions.php'; ?>

            <h1>Votre TO-DO list</h1>
            <form method="POST" id="form">
                <label for="form__input">Nouvelle tâche</label>
                <input name="task" type="text" id="form__input" autocomplete="off">
                <button>Ajouter</button> 
            </form>
            <?php require "list.php"; ?>
            <ul>
                <?= displayTasks() ?>
            </ul>
            
            
        </main>
    </body>
</html>
