<?php


// creer fonction pour verifier si utilisateur existe deja
function pseudoAviable()
{
    $cnx = connexionPDO();
    $result = array();

    try {
        $req = $cnx->prepare("SELECT pseudo FROM useru");
        $req->execute();

        $result = $req->fetchAll(PDO::FETCH_COLUMN);

        return $result;
        
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement de la date , du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
    }
    return $result;
}

function addUser($mail, $password, $pseudo)
{
    $cnx = connexionPDO();
    $result = null;
    try {
        $mdpHash = password_hash($password, PASSWORD_DEFAULT);
        $req = $cnx->prepare("INSERT  into useru (mail, password, pseudo) values(:mail,:password,:pseudo)");

        $result = $req->execute([':mail' => htmlspecialchars($mail), ':password' => $mdpHash, ':pseudo' => htmlspecialchars($pseudo)]);
        header("Refresh:2; url= '?action=Accueil'");
        return $result = true;
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement de la date , du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
    }
    return $result;
}

?>