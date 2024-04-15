<?php
session_start();

// Activer l'affichage des erreurs et spécifier le niveau de rapport d'erreur
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);


require dirname(__FILE__) . "/config/config.php";
require RACINE . "/config/root.php";
?>
