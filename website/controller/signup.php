<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionLogin.php';

$msg = null;
// recuperation des donnees saisies dans le formulaire
if (isset($_POST["mail"]) && isset($_POST["password"]) && isset($_POST["pseudo"])) {
    $mail = $_POST["mail"];
    $password = $_POST["password"];
    $pseudo = $_POST["pseudo"];

    if (empty($mail) || empty($password) || empty($pseudo)) {
        $msg = 'Veuillez saisir tous les champs';
    } elseif (!preg_match("/^[a-zA-Z\d]+$/", $pseudo)) {
        $msg = 'Votre Pseudo ne doit contenir que des des lettres ou des chiffres';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Veuillez saisir un email valide';
    } elseif (strlen($password) < 8) {
        $msg = "Mot de passe trop court";
    } else {
        
        $result = pseudoAviable();
        
        if(in_array($pseudo, $result)){
            $msg = "Pseudo déjà utilisé";
        }
        else{
            addUser($mail, $password, $pseudo);
            $msg = "Inscription réussie ! </p>";
        header("Refresh:2; url=?action=Accueil");
        }
    }
}
    $_SESSION['msg'] = $msg;

include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewSignup.php';
include RACINE . '/view/footer.php';
?>