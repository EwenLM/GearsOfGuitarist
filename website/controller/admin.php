<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionAdmin.php';

require RACINE . '/model/functionLogin.php';


$msg =null ;


//Recupération de tous les pseudo des utlisateurs 
$pseudos = pseudoAviable(); // Obtenez les pseudonymes disponibles
$selectUsers = array(); // Initialisez le tableau des utilisateurs sélectionnés

// Itérez sur chaque pseudo pour obtenir les informations de l'utilisateur
foreach ($pseudos as $pseudo) {
    // Récupérez les informations de l'utilisateur en utilisant le pseudo
    $userData = getUser($pseudo);
    // Ajoutez les informations de l'utilisateur au tableau $selectUsers
    if ($userData) {
        $selectUsers[] = $userData;
    }
}
// ====Ajout de guitarist====

if (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["group"]) && isset($_POST["bio"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $group = $_POST["group"];
    $bio = $_POST["bio"];

    if (empty($id) || empty($name) || empty($bio)) {
        $msg = 'Veuillez saisir tous les champs';
    }

    elseif(!preg_match("/^^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/",$id)){
        $msg = "L'id n'est pas valide" ;
    }
    elseif(!preg_match("/^[a-zA-Z\d\s]+$/",$name)){
        $msg = 'Les caractères spéciaux ne sont pas autorisés' ;
    }
    elseif(!empty($group) && !preg_match("/^[a-zA-Z\d\s]+$/",$group)){
        $msg = 'Le  nom du groupe ne doit contenir que des lettres ou des chiffres' ;
    }
    elseif(preg_match('/<\s*script\s*>|<\s*\/\s*script\s*>/i', $bio)){
        $msg = 'La biographie contient des caractères interdits' ;
    }
    else{
        $result = selectGuitarist();
        $isExist = array_column($result, 'name');
        if(in_array($name, $isExist)){
            $msg = "Guitarsite déjà enregistré";
        }
        else{
            addGuitarist($id, $name, $group, $bio);
            $msg = 'Guitariste ajouté ! ';
        }
    }
    $_SESSION['msgGuitarist']= $msg;
}

// ====Ajout d'album====
if (isset($_POST["title"]) && isset($_POST["year"])) {
    $title = $_POST["title"];
    $year= $_POST["year"];
    if (empty($title) || empty($year)) {
        $msg = 'Veuillez saisir tous les champs';
    }
    elseif(!preg_match("/^[a-zA-Z\d\sÀ-ÖØ-öø-ÿ]+$/u",$title)){
        $msg = 'Les caractères spéciaux ne sont pas autorisés' ;
    }
    elseif(!preg_match("/^\d{4}$/", $year)){
        $msg = 'Veuillez saisir une année valide';
    }
    else{
        $result = selectAlbum();
        $isExist = array_column($result, 'title');
        if(in_array($title, $isExist)){
            $msg = "Album déjà enregistré";
        }
        else{
        $addAlbum=addAlbum($title, $year);
            if($addAlbum===true){
            $msg = 'Album ajouté ! ';
            }
            else{
                $msg=$addAlbum;
            }
        }
    }
    $_SESSION['msgAlbum']= $msg;
}

// Ajout de musique
// Selection du guitarist dans un menu déroulant
    $guitarist = "IS NOT NULL";
    $selectGuitarist = selectGuitarist(); 
    $isGuitarist = array_column($selectGuitarist, 'name');
    $_SESSION['selectGuitarist'] = $isGuitarist;

    $selectAlbum = selectAlbum(); 
    $isAlbum = array_column($selectAlbum, 'title');
    $_SESSION['selectAlbum'] = $isAlbum;

if(isset($_POST["titleM"]) && isset($_POST["album"]) && isset($_POST["guitarist"])){
    $titleM = $_POST["titleM"];
    $album = $_POST["album"];
    $guitarist = $_POST["guitarist"];


    if (empty($titleM)){
        $msg = 'Veuillez saisir le titre de la musique';
    }

    else{
        $result = selectMusic();
        $isExist = array_column($result, 'name');
        if(in_array($titleM, $isExist)){
            $msg= "Musique déjà enregistré ! ";
        }
        else{
        $addMusic= addMusic($titleM, $album, $guitarist);
            if($addMusic===true){
            $msg = "Musique ajoutée";
            }
            else{
                $msg = $addMusic ;
            }
        }
    }
    $_SESSION['msgMusic']= $msg;
}




include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php'; 

include RACINE . '/view/viewAdmin.php';

include RACINE . '/view/footer.php';
?>