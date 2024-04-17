<?php
require RACINE . '/model/bdConnect.php';
require RACINE . '/model/functionGear.php';

$msg= null;

$selectGuitarist = selectGuitarist();
$isGuitarist = array_column($selectGuitarist, 'name');
$_SESSION['selectGuitarist'] = $isGuitarist;


//========Ajouter Guitare==============

if (isset($_POST["nameG"]) && isset($_POST["brandG"]) && isset($_POST["yearG"]) && isset($_POST["selectedMusic"])) {
    $nameG = $_POST["nameG"];
    $brandG = $_POST["brandG"];
    $yearG = $_POST["yearG"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameG) || empty($brandG) || empty($yearG) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[a-zA-Z\d\s]+$/", $nameG) || !preg_match("/^[a-zA-Z\d\s]+$/", $brandG)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } elseif (!preg_match("/^\d{4}$/", $yearG)) {
        $msg = 'Entrez une année au format yyyy';
    } else {

        $addGear = addGear($nameG, $brandG);
        $addGuitar = addGuitar($yearG);
        $addContribution = addContribution();
        if ($addGear === true && $addGuitar === true && $addContribution === true) {
            $msg = 'Guitare ajoutée ! ';
        } else {
            $msg = $addGuitar;
        }
    }
    header("Location:?action=ProfilGuitariste");
    $_SESSION["msgGuitar"] = $msg;
}

//===========Ajouter Ampli============

if (isset($_POST["nameA"]) && isset($_POST["brandA"]) && isset($_POST["power"]) && isset($_POST["techno"])) {
    $nameG = $_POST["nameA"];
    $brandG = $_POST["brandA"];
    $power = $_POST["power"];
    $techno = $_POST["techno"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameG) || empty($brandG) || empty($power) || empty($techno) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[a-zA-Z\d\s]+$/", $nameG) || !preg_match("/^[a-zA-Z\d\s]+$/", $brandG) || !preg_match("/^[a-zA-Z\d\s]+$/", $power) || !preg_match("/^[a-zA-Z\d\s]+$/", $techno)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } else {

        $addGear = addGear($nameG, $brandG);
        $addAmp = addAmp($power, $techno);
        $addContribution = addContribution();
        if ($addGear === true && $addAmp === true && $addContribution === true) {
            $msg = 'Ampli ajouté ! ';
        } else {
            $msg = $addAmp;
        }
    }
    header("Location:?action=ProfilGuitariste");
    $_SESSION['msgAmp'] = $msg;
}


//=========Ajout Pédale==========

if (isset($_POST["nameP"]) && isset($_POST["brandP"]) && isset($_POST["effect"])) {
    $nameP = $_POST["nameP"];
    $brandP = $_POST["brandP"];
    $effect = $_POST["effect"];
    $music = $_POST["selectedMusic"];
    $_SESSION["selectedMusic"] = $music;

    if (empty($nameP) || empty($brandP) || empty($effect) || empty($music)) {

        $msg = "Veuillez remplir tous les champs";
    } elseif (!preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $nameP) || !preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $brandP) || !preg_match("/^[\w\d\s\p{L}\p{M}]*$/u", $effect)) {
        $msg = 'Les caractères spéciaux ne sont pas autorisés';
    } else {

        $addGear = addGear($nameP, $brandP);
        $addPedal = addPedal($effect);
        $addContribution = addContribution();
        if ($addGear === true && $addPedal === true && $addContribution === true) {
            $msg = "Pédale d'effet ajoutée";
        } else {
            $msg = $addPedal;
        }
    }
    header("Location:?action=ProfilGuitariste");
    $_SESSION['msgPedal'] = $msg;
}


include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewGuitarist.php';
include RACINE . '/view/footer.php';

?>