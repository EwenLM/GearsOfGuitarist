<?php

require RACINE . "/model/functionSignup.php";

// ==========Obtention information de l'utilisateur============
function getUser($pseudo)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * from useru where pseudo=:pseudo");
        $req->execute([':pseudo' => $pseudo]);

        $result = $req->fetch(PDO::FETCH_ASSOC);
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


// ============Obtention du role de l'utilisateur=========
function isAdmin($pseudo)
{
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT isAdmin from `useru` where pseudo = :pseudo");
        $req->execute([':pseudo' => $pseudo]);

        $result = $req->fetch(PDO::FETCH_ASSOC);
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


// =============Connexion================
function login($pseudo, $password)
{
    // Vérifie si le pseudonyme existe dans la base de données
    $user = getUser($pseudo);
    $admin = isAdmin($pseudo);
    if (!$user) {
        throw new Exception("Pseudo incorrect.");
    }

    // Récupère le hash du mot de passe stocké en base de données
    $hashBD = $user["password"];

    // Vérifie si le mot de passe fourni correspond au hash stocké en base de données
    if (password_verify($password, $hashBD)) {
        // Si le mot de passe est correct,  enregistrement du pseudo dans la session
        $_SESSION["pseudo"] = $pseudo;

        // Si l'utilisateur est un admin , enregistrement dans la session
        if ($admin['isAdmin'] == 1) {
            $_SESSION["isAdmin"] = true;
        }
        header("Refresh:2; url= '?action=Accueil'");
        return true; // Authentification réussie
    } else {
        // Le mot de passe ne correspond pas au hash stocké en base de données
        throw new Exception("Mot de passe incorrect.");
    }
}


// ===========Personalisation du profil=============
function addProfil($pseudo, $genre, $group, $guitarist, $bio)
{
    $cnx = connexionPDO();
    try {
        // Récupérer les valeurs actuelles de la bdd
        $user = getUser($pseudo);

        $currentGenre = $user['favoriteGenre'];
        $currentGroup = $user['favoriteGroup'];
        $currentGuitarist = $user['favoriteGuitarist'];
        $currentBio = $user['bio'];

        //  si le champ est vide remplacer par la valeur présente en bdd
        if (empty($genre)) {
            $genre = $currentGenre;
        }
        if (empty($group)) {
            $group = $currentGroup;
        }
        if (empty($guitarist)) {
            $guitarist = $currentGuitarist;
        }
        if (empty($bio)) {
            $bio = $currentBio;
        }

        // Préparation requête
        $sql = "UPDATE useru SET favoriteGenre = :genre, favoriteGroup = :group, favoriteGuitarist = :guitarist, bio = :bio WHERE pseudo = :pseudo";
        $req = $cnx->prepare($sql);
        $req->bindParam(':genre', $genre);
        $req->bindParam(':group', $group);
        $req->bindParam(':guitarist', $guitarist);
        $req->bindParam(':bio', $bio);
        $req->bindParam(':pseudo', $pseudo);

        // Exécution requête
        $result = $req->execute();
        return $result;

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

// ===============Modification du profil ========================
function updateProfil($pseudo, $newPseudo, $newMail, $newPassword)
{
    $cnx = connexionPDO();

    try {
        // Récupérer les valeurs actuelles de la bdd
        $user = getUser($pseudo);

        $currentPseudo = $user['pseudo'];
        $currentMail = $user['mail'];
        $currentPassword = $user['password'];
        
        //  si le champ est vide remplacer par la valeur présente en bdd
        if (empty($newPseudo)) {
            $newPseudo = $currentPseudo;
        }
        if (empty($newMail)) {
            $newMail = $currentMail;
        }
        if (empty($newPassword)) {
            $newPassword = $currentPassword;
        }
        
        // Hash le mdp seulement si il est modifié
        if (!empty($newPassword) && $newPassword !== $currentPassword) {
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        } 

        $req = $cnx->prepare("UPDATE useru SET pseudo = :newPseudo, mail = :newMail, password = :newPassword WHERE pseudo = :pseudo");
        $req->bindParam(':newPseudo', $newPseudo);
        $req->bindParam(':newMail', $newMail);
        $req->bindParam(':newPassword', $newPassword);
        $req->bindParam(':pseudo', $pseudo);

        $result = $req->execute();
        $_SESSION["pseudo"] = $newPseudo;
        return $result;

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

function logout()
{
    if (isset($_SESSION["pseudo"])) {
        session_destroy();
        header("Location:?action=Accueil");
    }
}

function deleteAccount($idUser){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("DELETE from `useru` where idUser = :idUser");
        $req->execute([':idUser' => $idUser]);
        $result = $req->fetch(PDO::FETCH_ASSOC);
        header("Location:?action=Accueil");
    } catch (PDOException $msg) {
        $dateTime = date("d-m-Y H:i:s");
        $errorMessage = $msg->getMessage();
        $errorCode = $msg->getCode();

        // Enregistrement de la date , du message d'erreur et du code d'erreur dans un fichier
        $logMessage = "$dateTime Erreur : $errorMessage (Code d'erreur : $errorCode)\n";
        error_log($logMessage, 3, RACINE . "/config/error.log");
        $result = "erreur";
    }
    return $result;
}


?>