<?php
if (isset($_POST)) {
    foreach ($_POST as $field => $value) {
        $exclude = ['eventdate', 'newpw', 'newpwconfirm'];
        $delete = isset(explode('_', $field)[1]) && explode('_', $field)[1] === 'delete'  ? true : false;
        $clock = isset(explode('_', $field)[1]) && explode('_', $field)[1] === 'clock'  ? true : false;
        $newLogin = isset($_POST['newlogin']) ? $_POST['newlogin'] : '';
        $newPw = isset($_POST['newlogin']) ? $_POST['newpw'] : '';
        $newPwConfirm = isset($_POST['newlogin']) ? $_POST['newpwconfirm'] : '';
        
        if ($delete) {
            $deleteField = explode('_', $field)[0];
            removeTask($tododb, $deleteField);
        } else if ($clock) {
            $field = explode('_', $field)[0];
            defineUrgentTask($tododb, $field);
        } else if ($newLogin) {
            if ($newPw !== $newPwConfirm) {
                $_SESSION['wrongPwCreate'] = true;
                break;
            } else {
                $_SESSION['wrongPwCreate'] = false;
                createUser($newLogin, $newPw, $newPwConfirm, $tododb);
                break;
            }
            
        } else if ($value !== '' && !in_array($field, $exclude)) {
            addTask($tododb, $field);
        }
    }
}