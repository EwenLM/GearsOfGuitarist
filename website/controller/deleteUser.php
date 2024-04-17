<?php

require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionLogin.php';

// =====Suppression======
$accountId = $_POST['banUser'];
$idUser = $_SESSION['userId'];
if ($idUser == $accountId){
    logout();
}

if(isset($_SESSION['isAdmin'])){
    header("Location:?action=Admin");  
}
else{
   header("Location:?action=Accueil"); 
}

deleteAccount($accountId);



?>