<?php


// Selection des informations d'un guitariste par rapport à son nom
function getGuitarist($name){
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT * FROM guitarist where name = :name");
        $req->execute([':name'=>$name]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
    }
}

//Selection d'une musique jouer par un guitarsite
function getMusic($idGuitarist)
{
    $cnx = connexionPDO();
    $result = array();
    try {
        $req = $cnx->prepare("SELECT  music.name, music.title, music.idMusic 
        FROM music JOIN play USING (idMusic) 
        JOIN guitarist USING (idGuitarist) 
        WHERE guitarist.idGuitarist = :idGuitarist;");
        $req->execute(['idGuitarist'=>$idGuitarist]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");

        return $result;
    }
}



?>
