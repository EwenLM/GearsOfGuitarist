<?php

function connexionPDO(){
    
require RACINE . '/config/bdd.php';

    // Tentative de connexion
    try {
            $conn = new PDO("mysql:host=$DBHOST;dbname=$DBNAME",$HOSTNAME,$HOSTPASSWORD);
            // Defini le mode d'erreur sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
    }
    // Si la connexion échoue 
    catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE ."/config/error.log");
        
    }
    return;
 }
?>