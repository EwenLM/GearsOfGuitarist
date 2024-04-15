<?php

require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionLogin.php';

// =====Suppression======
$accountId = $_POST['banUser'];
$idUser = $_SESSION['userId'];
if ($idUser == $accountId){
    logout();
}

deleteAccount($accountId);



?>