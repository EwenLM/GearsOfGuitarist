<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionAdmin.php';

$msg= null;

$selectGuitarist = selectGuitarist();
$isGuitarist = array_column($selectGuitarist, 'name');
$_SESSION['selectGuitarist'] = $isGuitarist;



include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewGuitarist.php';
include RACINE . '/view/footer.php';

?>