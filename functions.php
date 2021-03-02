<?php

function displayTasks() {
    $servername = 'localhost';
    $dbname = 'todolist';
    $username = 'nasfernane';
    $password = 'blabladodo';

    $tododb = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
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