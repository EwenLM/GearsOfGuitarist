<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionAdmin.php';
require RACINE . '/model/functionGuitarist.php';

// Affichage des guitaristes par date d'ajout
$selectGuitarist = selectGuitarist();

$indexGuitarists = array();
foreach ($selectGuitarist as $key => $guitarist) {
    $indexGuitarists[$key] = $guitarist['dated'];
}

// Trie les guitaristes en utilisant la date d'ajout 
array_multisort($indexGuitarists, SORT_DESC, $selectGuitarist);

// Selectionne seulement les 5 derniers ajoutées
$selectGuitarist = array_slice($selectGuitarist, 0, 5);


include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';

include RACINE . '/view/viewHome.php';

include RACINE . '/view/footer.php';

?>
