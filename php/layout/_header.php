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

    <header class="header">
        <div class="header__trollogo">
            <img src="/assets/img/troll.png" alt="Troll Icon">
            <a href="/">Trollo</a>
        </div>
        <div class="header__auth">
            <?= displayLog() ?>
        </div>
        
    </header>
        <main>