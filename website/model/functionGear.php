<?php
require RACINE . "/model/functionLogin.php";
require RACINE . "/model/functionAdmin.php";


// Sélection id du matériel
function selectIdGear()
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT MAX(idGear) AS maxId FROM gear");
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
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

//Sélection guitare par musique
function selectMusicGuitar($idMusic)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT gear.idGear, gear.name, gear.brand, guitar.yearY, contribution.idMusic 
        FROM guitar JOIN contribution USING (idGear) 
        JOIN gear USING (idGear) 
        WHERE contribution.idMusic = :idMusic;");
        $req->execute([':idMusic' => $idMusic]);
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

//Sélection ampli par music
function selectMusicAmp($idMusic)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT gear.idGear, gear.name, gear.brand, amp.powerP, amp.technology,contribution.idMusic 
        FROM amp JOIN contribution USING (idGear) 
        JOIN gear USING (idGear) 
        WHERE contribution.idMusic = :idMusic;");
        $req->execute([':idMusic' => htmlspecialchars($idMusic)]);
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

//Sélection pédales par musique
function selectMusicPedal($idMusic)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT gear.idGear, gear.name, gear.brand, pedal.effect, contribution.idMusic 
        FROM pedal JOIN contribution USING (idGear)
        JOIN gear USING (idGear) 
        WHERE contribution.idMusic = :idMusic;");
        $req->execute([':idMusic' => $idMusic]);
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


// Ajout de matériel dans la base de données
function addGear($name, $brand)
{
    $cnx = connexionPDO();
    $result = null;
    try {
        $req = $cnx->prepare("INSERT  into gear (name, brand) values(:name, :brand)");
        $result = $req->execute([':name' => htmlspecialchars($name), ':brand' => htmlspecialchars($brand)]);

        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'Le site rencontre un problème, réessayez plus tard.';
    }
    return $result;
}

//Ajout de guitare
function addGuitar($year)
{
    $cnx = connexionPDO();
    $result = null;
    $gear = selectIdGear();
    $idGear = $gear['maxId'];
    try {
        $req = $cnx->prepare("INSERT INTO guitar (yearY, idGear) VALUES (:year, :idGear)");
        $result = $req->execute([':year' => htmlspecialchars($year), ':idGear' => $idGear]);
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'Le site rencontre un problème, réessayez plus tard.';
    }
    return $result;
}

//Ajout d'ampli
function addAmp($power, $techno)
{
    $cnx = connexionPDO();
    $result = null;

    $gear = selectIdGear();
    $idGear = $gear['maxId'];

    try {
        $req = $cnx->prepare("INSERT INTO amp (powerP, technology, idGear) VALUES (:power, :technology, :idGear)");
        $result = $req->execute([':power' => htmlspecialchars($power), ':technology' => htmlspecialchars($techno), ':idGear' => $idGear]);
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'Le site rencontre un problème, réessayez plus tard.';
    }
    return $result;
}

//Ajout de pédale
function addPedal($effect)
{
    $cnx = connexionPDO();
    $result = null;

    $gear = selectIdGear();
    $idGear = $gear['maxId'];

    try {
        $req = $cnx->prepare("INSERT INTO pedal (effect, idGear) VALUES (:effect, :idGear)");
        $result = $req->execute([':effect' => htmlspecialchars($effect), ':idGear' => $idGear]);
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'Le site rencontre un problème, réessayez plus tard.';
    }
    return $result;
}

//Ajouter une contribution
function addContribution()
{
    $cnx = connexionPDO();
    $result = null;

    try {
        $pseudo = $_SESSION['pseudo'];
        $getUser = getUser($pseudo);
        $idUser = $getUser['idUser'];

        $trackSelected = $_SESSION['selectedMusic'];
        $idMusic = musicIdByName($trackSelected);

        $gear = selectIdGear();
        $idGear = $gear['maxId'];

        $req = $cnx->prepare("INSERT  into contribution (idMusic, idGear, idUser) values(:music, :gear, :user)");
        $result = $req->execute([':music' => $idMusic, ':gear' => $idGear, ':user' => $idUser]);
        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'Le site rencontre un problème, réessayez plus tard.';
        return $result;
    }
}

//Sélection des contribution par utilisateur
function selectContribution($idUser)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT gear1.name, gear1.brand, music.name, contribution.dateD, contribution.idContribution 
            FROM gear AS gear1 
            JOIN contribution USING (idGear) 
            JOIN gear AS gear2 USING (idGear) 
            JOIN music USING (idMusic) 
            WHERE contribution.idUser = :idUser");
        $req->execute([':idUser' => $idUser]);
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

//Suppression contribution
function deleteContribution($idContribution){
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("DELETE FROM contribution WHERE `contribution`.`idContribution` = :idContribution");
        $req->execute([':idContribution' => $idContribution]);
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        header("Location:?action=ProfilUtilisateur");
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = 'echec suppression';
        return $result;

    }
}



//Nombre de contribution par utilisateur
function numberOfConByUser($idUser)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT COUNT(*) FROM `contribution` WHERE idUser = :idUser ");
        $req->execute([':idUser' => $idUser]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
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

//Nombre de contribution par musique
function numberOfConByMusic($idMusic)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("SELECT COUNT(*) FROM `contribution` WHERE idMusic = :idMusic ");
        $req->execute([':idMusic' => $idMusic]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
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