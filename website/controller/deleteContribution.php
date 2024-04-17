<?php 
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGear.php';

// =====Suppression======
$idContribution = $_POST['idContribution'];
$idGear = $_SESSION['idContribution'];
deleteContribution($idContribution, $idGear);
?>