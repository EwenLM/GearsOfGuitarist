<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGear.php';


if (isset($_POST['pseudoProfil'])) {
    $profilPseudo = $_POST['pseudoProfil'];
    // Récupérer les informations du profil à partir du pseudo
    $_SESSION['selectedProfil'] = $profilPseudo;
}
    $profil = getUser($_SESSION['selectedProfil']);

    if ($profil) {
        // Récupérer les informations du profil

        $profilBio = $profil['bio'];
        $_SESSION["profilBio"] = $profilBio;

        $profilGenre = $profil['favoriteGenre'];
        $_SESSION["profilGenre"] = $profilGenre;

        $profilGroup = $profil['favoriteGroup'];
        $_SESSION["profilGroup"] = $profilGroup;

        $profilGuitarist = $profil['favoriteGuitarist'];
        $_SESSION["profilGuitarist"] = $profilGuitarist;

        $profilId = $profil['idUser'];

        $nbrContribution = numberOfConByUser($profilId);
        $nbrContribution = $nbrContribution['COUNT(*)'];
        $_SESSION['nbrContribution'] = $nbrContribution;

        $profilId = $profil['idUser'];
        $profilContribution = selectContribution($profilId);
        $_SESSION['contributions'] = $profilContribution;

    }

include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewProfilUtilisateur.php';
include RACINE . '/view/footer.php';
?>