<?php

function displayTasks() {
    $host = 'mysql:host=localhost;dbname=todolist';
    $tododb = new PDO($host, 'root', '');
    $tododb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $userTasks = $tododb->prepare('SELECT * FROM Tasks');
    $requestStatus = $userTasks->execute();

    if ($requestStatus) {
        foreach ($userTasks as $task) {
            echo <<<HTML
                    <div class="task">
                        <li>$task[nom]</li>
                        <form method="POST">
                            <button name="delete" value="$task[nom]">X</button>
                        </form>
                    </div>
                HTML;
        }
    }  
}          
            

?>