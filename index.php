<?php require 'php/functions.php'; ?>

<?php require 'php/list.php'; ?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Trollo</title>
        <link rel="stylesheet" href="assets/sass/style.css" />
    </head>
    <body>
        <main>
            <h1 class="mainTitle">Trollo</h1>
            <div class="todoContainer">
                <?= displayList('home') ?>
                <?= displayList('work') ?>
                <?= displayList('event') ?>
            </div>                
        </main>
    </body>
</html>
