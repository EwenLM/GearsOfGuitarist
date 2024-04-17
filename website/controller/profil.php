<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGear.php';

$msg = null;

// ================Affichage des informations du profil====================
if (isset($_SESSION["pseudo"])) {

    $pseudo = $_SESSION['pseudo'];
    // Récupérer les informations du profil utilisateur à partir du pseudo
    $user = getUser($pseudo);

    // Vérifier si l'utilisateur existe
    if ($user) {
        // Récupérer les informations du profil utilisateur

        $userBio = $user['bio'];
        $_SESSION["userBio"] = $userBio;

        $userGenre = $user['favoriteGenre'];
        $_SESSION["userGenre"] = $userGenre;

        $userGroup = $user['favoriteGroup'];
        $_SESSION["userGroup"] = $userGroup;

        $userGuitarist = $user['favoriteGuitarist'];
        $_SESSION["userGuitarist"] = $userGuitarist;

        $userId = $user['idUser'];
        $_SESSION["userId"]=$userId;

        $nbrContribution = numberOfConByUser($userId);
        $nbrContribution = $nbrContribution['COUNT(*)'];
        $_SESSION['nbrContributionUser'] = $nbrContribution;
    } else {
    }



    // ===============Personalisation du profil======================
    if (isset($_POST["genre"]) && isset($_POST["group"]) && isset($_POST["guitarist"]) && isset($_POST["bio"])) {
        $genre = $_POST["genre"];
        $group = $_POST["group"];
        $guitarist = $_POST["guitarist"];
        $bio = $_POST["bio"];
        $pseudo = $_SESSION["pseudo"];

        if (!empty($genre) && !preg_match("/^[a-zA-Z\d\s]+$/", $genre)) {
            $msg = 'Le  nom du genre ne doit contenir que des lettres ou des chiffres';
        } elseif (!empty($group) && !preg_match("/^[a-zA-Z\d\s]+$/", $group)) {
            $msg = 'Le groupe contient des caractères interdits';
        } elseif (!empty($guitarist) && !preg_match("/^[a-zA-Z\d\s]+$/", $guitarist)) {
            $msg = 'Le guitariste contient des caractères interdits';
        } elseif (!empty($bio) && preg_match("/^[^\W_]+(?:[^\W_]+\s)*[^\W_]+$/", $bio)) {
            $msg = 'La biographie contient des caractères interdits';
        } else {

            addProfil($pseudo, $genre, $group, $guitarist, $bio);

            $msg = "Profil enregistré ! ";
        }

        $_SESSION['msgAddProfil'] = $msg;
    } else {
    }


    // ==================Modifiaction des identifiants=============================
    $getUser = getUser($pseudo);
    $getUserMail = $getUser['mail'];
    $_SESSION["mail"] = $getUserMail;

    if (isset($_POST["newPseudo"]) && isset($_POST["newMail"]) && isset($_POST["newPassword"])) {
        $newPseudo = $_POST["newPseudo"];
        $newMail = $_POST["newMail"];
        $newPassword = $_POST["newPassword"];
        $pseudo = $_SESSION["pseudo"];



        if (!empty($newPseudo) && !preg_match("/^[a-zA-Z\d]+$/", $newPseudo)) {
            $msg = 'Pseudo non valide';
        } elseif (!empty($newMail) && !filter_var($newMail, FILTER_VALIDATE_EMAIL)) {
            $msg = 'Email non valide';
        } elseif (!empty($newPassword) && strlen($newPassword) < 8) {
            $msg = 'Mot de passe trop court';
        } else {
            $result = pseudoAviable();

            if (in_array($newPseudo, $result)) {
                $msg = "Pseudo déjà utilisé";
            } else {
                updateProfil($pseudo, $newPseudo, $newMail, $newPassword);
                $msg = "Modification(s) enregistrée(s)! ";
            }
        }
        $_SESSION['msgUpdateProfil'] = $msg;
    } else {
    }
}


include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewProfil.php';
include RACINE . '/view/footer.php';
?>