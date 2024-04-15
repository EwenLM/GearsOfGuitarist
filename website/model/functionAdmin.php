<?php




//============= Fonctions liées aux guitaristes ================

// ==Ajout de guitariste==
function addGuitarist($id, $name, $group, $bio)
{
    $cnx = connexionPDO();
    $result = null;
    try {
        $req = $cnx->prepare("INSERT  into guitarist (idGuitarist, name, groupG, bio) values(:idGuitarist, :name, :groupG, :bio)");

        $result = $req->execute([':idGuitarist' => htmlspecialchars($id), ':name' => htmlspecialchars($name), ':groupG' => htmlspecialchars($group), ':bio' => htmlspecialchars($bio)]);
        return $result = true;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
    }
    return $result;
}

// Selection des guitaristes
function selectGuitarist()
{
    $cnx = connexionPDO();
    $result = array();
    try {
        $req = $cnx->prepare("SELECT * FROM guitarist ORDER BY `guitarist`.`name` ASC ");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");

        return $result; // Retourner un tableau vide en cas d'erreur
    }
}

function guitaristIdByName($name) {
    $guitarists = selectGuitarist(); 
    // Parcourir tous les guitaristes pour trouver celui avec le nom 
    foreach ($guitarists as $guitarist) {
        if ($guitarist['name'] == $name) {

            // Retourner l'id
            return $guitarist['idGuitarist']; 
        }
    }
    // Retourner null si aucun guitariste avec ce nom n'a été trouvé
    return null;
}


// ============== Fonctions liées aux albums ================

// ==Ajout d'album==
function addAlbum($title, $year)
{
    $cnx = connexionPDO();
    try {
        $req = $cnx->prepare("INSERT  into album (title, yearY) values(:title, :year)");

        $result = $req->execute([':title' => htmlspecialchars($title), ':year' => htmlspecialchars($year)]);
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

function selectAlbum()
{
    $cnx = connexionPDO();
    $result = array();
    try {
        $req = $cnx->prepare("SELECT * FROM album  ORDER BY `album`.`yearY` ASC");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");

        return $result; // Retourner un tableau vide en cas d'erreur
    }
}


// ============== Fonctions liées aux musiques ===============

// ==Ajout de musique==
function addMusic($name, $album, $guitarist)
{
    $cnx = connexionPDO();
    $result = null;
    try {
        $req = $cnx->prepare("INSERT  into music (name, title) values(:name, :title)");

        $result = $req->execute([':name' => $name, ':title' => $album]);

        if (!empty($guitarist)) {

            $idGuitarist = guitaristIdByName($guitarist);
            $idMusic = musicIdByName($name);

            $req = $cnx->prepare("INSERT  into play (idGuitarist, idMusic) values(:idGuitarist, :idMusic)");

            $result = $req->execute([':idGuitarist' => htmlspecialchars($idGuitarist), ':idMusic' => htmlspecialchars($idMusic)]);
        }
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

// ==Selection musique==
function selectMusic()
{
    $cnx = connexionPDO();
    $result = array();
    try {
        $req = $cnx->prepare("SELECT * FROM music");
        $req->execute();
        $result = $req->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");

        return $result; // Retourner un tableau vide en cas d'erreur
    }
}

function musicIdByName($name) {
    $music = selectMusic();  
    
    // Parcourir les musiques
    foreach ($music as $music) {
        if ($music['name'] == $name) {

            // Retourner l'id
            return $music['idMusic']; 
        }
    }
    return null;
}

?>