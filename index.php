<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>To Do list</title>
        <link rel="stylesheet" href="assets/sass/style.css" />
    </head>
    <body>
        <main>
            <?php require_once 'php/functions.php'; ?>
            <h1 class="mainTitle">Trollo</h1>

            <div class="todoContainer">
                <section class="todoContainer__list todoContainer__list--home">
                    <header class="todoContainer__list__header">
                        <img src="/assets/img/home.png" alt="">
                        <h2>TO-DO Home</h2>
                    </header>
                    
                    <form method="POST" class="todoContainer__list__form">
                        <label for="form__input">Ajouter</label>
                        <input name="hometask" type="text" id="form__input" autocomplete="off">
                        <button class="addBtn" title="Ajouter"><img src="/assets/img/add-button.png" alt="Add Button"></button> 
                    </form>
                    <?php require "list.php"; ?>
                    <ul>
                        <?= displayTasks('home') ?>
                    </ul>
                </section>

                <section class="todoContainer__list todoContainer__list--work">
                    <header class="todoContainer__list__header">
                        <img src="/assets/img/work.png" alt="">
                        <h2>TO-DO Work</h2>
                    </header>
                    
                    <form method="POST" class="todoContainer__list__form">
                    <label for="form__input">Ajouter</label>
                        <input  name="task" type="text" id="form__input" autocomplete="off">
                        <button class="addBtn" title="ajouter"><img src="/assets/img/add-button.png" alt="Ajouter Tâche"></button> 
                    </form>
                    <?php require "list.php"; ?>
                    <ul>
                        <?= displayTasks('home') ?>
                    </ul>
                </section>

            </div>  
                    
            
        </main>
    </body>
</html>
