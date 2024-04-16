<?php

if (isset($_GET["action"])) {
    $action = $_GET["action"];
   
    switch($action) { 
        case "Accueil": 
        require RACINE . "/controller/home.php";
        break; 
        case "Connexion": 
        require RACINE . "/controller/login.php";
        break; 
        case "Inscription": 
        require RACINE . "/controller/signup.php";
        break; 
        case "JohnMayer": 
        require RACINE . "/controller/guitaristJohnMayer.php";
        break; 
        case "Déconnexion": 
        require RACINE . "/controller/logout.php";
        break; 
        case "Admin": 
        require RACINE . "/controller/admin.php";
        break; 
        case "Profil": 
        require RACINE . "/controller/profil.php";
        break; 
        case "ProfilUtilisateur": 
        require RACINE . "/controller/profilUtilisateur.php";
        break; 
        case "Guitariste": 
        require RACINE . "/controller/guitarist.php";
        break; 
        case "ProfilGuitariste": 
        require RACINE . "/controller/profilGuitarist.php";
        break; 
        case "Contact": 
        require RACINE . "/controller/contact.php";
        break; 
        case "Suppression": 
        require RACINE . "/controller/deleteContribution.php";
        break; 
        case "Ban": 
        require RACINE . "/controller/deleteUser.php";
        break; 
        default: 
        require RACINE . "/controller/error404.php";
        }

} else {
    // Si aucune action, afficher une page d'accueil
    require RACINE . "/controller/home.php";
}

?>