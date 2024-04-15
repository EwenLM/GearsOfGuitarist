<?php 
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGear.php';

// =====Suppression======
$idContribution = $_POST['idContribution'];

deleteContribution($idContribution)
?>