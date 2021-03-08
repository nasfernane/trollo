<?php
if (isset($_POST)) {
    // boucle sur toutes les requêtes POST pour envoyer les requêtes correpondantes à la BDD
    foreach ($_POST as $field => $value) {
        // exlut les champs sur lesquels on ne veut pas boucler
        $exclude = ['eventdate', 'newpw', 'newpwconfirm', 'pw'];
        // récupération des champs seulement si ils existent :
        // delete
        $delete = isset(explode('_', $field)[1]) && explode('_', $field)[1] === 'delete'  ? true : false;
        // clock
        $clock = isset(explode('_', $field)[1]) && explode('_', $field)[1] === 'clock'  ? true : false;
        // login nouveau compte 
        $newLogin = isset($_POST['newlogin']) ? $_POST['newlogin'] : '';
        // mot de passe nouveau compte
        $newPw = isset($_POST['newpw']) ? $_POST['newpw'] : '';
        // mot de passse de confirmation
        $newPwConfirm = isset($_POST['newpwconfirm']) ? $_POST['newpwconfirm'] : '';
        // login utilisateur déjà existant
        $login = isset($_POST['login']) ? $_POST['login'] : '';
        // mot de passe nouveau compte
        $pw= isset($_POST['pw']) ? $_POST['pw'] : '';

        

        // en cas de champ delete
        if ($delete) {
            // on destructure pour récupérer la table à altérer
            $deleteField = explode('_', $field)[0];
            // on supprime de la bdd
            removeTask($tododb, $deleteField);
        } 
        
        // en cas de champ clock
        else if ($clock) {
            // on destrucutre pour savoir à quelle table il appartient
            $field = explode('_', $field)[0];
            // on toggle le champ urgent
            defineUrgentTask($tododb, $field);
        } 
        
        // en cas de création d'un nouveau login
        else if ($newLogin && $newPw && $newPwConfirm) {
            // si les mots de passe ne correspondent pas
            if ($newPw !== $newPwConfirm) {
                // on l'indique créer l'alerte l'utilisateur
                $_SESSION['wrongPwCreate'] = true;
                break;
            // sinon,
            } else {
                $_SESSION['wrongPwCreate'] = false;
                // on crée le nouvel utilisateur
                createUser($newLogin, $newPw, $newPwConfirm, $tododb);
                break;
            }   
        } 

        // En cas de connexion d'un utilisateur
        else if ($login) {
            userLogin($login, $pw, $tododb);
            break;
        }
        
        // par défaut, ajout du champ comme nouvelle entrée dans la BDD
        else if ($value !== '' && !in_array($field, $exclude)) {
            addTask($tododb, $field);
        }
    }
}