<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionLogin.php';
$msg = null;

// ========Connexion==========
if (isset($_POST["pseudo"]) && isset($_POST["password"])) {
    $pseudo = $_POST["pseudo"];
    $password = $_POST["password"];

    if (empty($pseudo) || empty($password)) {
        $msg = "Veuillez saisir tous les champs";
    } else {
        try {
            // Tentative de connexion avec les identifiants fournis et enregistrement dans la session
            login($pseudo, $password);

            if (isset($_SESSION["pseudo"])) {
                $msg = "Bonjour, " . $_SESSION["pseudo"] . "!";
                
            };
        } catch (Exception $e) {
            // Si les éléments de connexion ne sont pas bon , renvoie une erreur
            $msg = $e->getMessage();
        }
    }
    
    $_SESSION['msg'] = $msg;
} else {
}
include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewLogin.php';


include RACINE . '/view/footer.php';
