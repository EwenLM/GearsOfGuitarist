<?php

if (isset( $_POST['email'], $_POST['subject'], $_POST['message'])) {
    
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (empty($email) || empty($subject) || empty($message)) {
        $msg = 'Veuillez saisir tous les champs';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = 'Veuillez saisir un email valide';
    } elseif (preg_match('/<\s*script\s*>|<\s*\/\s*script\s*>/i', $message) || preg_match('/<\s*script\s*>|<\s*\/\s*script\s*>/i', $subject)) {
        $msg = 'Votre message contient des caratères non autorisé';
    } else {

        $to = 'your@mail.com';
        $headers = "From: <$email>" . "\r\n";

        // Envoyer l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            $msg = "Votre message a été envoyé !";
        } else {
            $msg = "Erreur lors de l'envoi du message. Veuillez réessayer.";
        }
    }
    $_SESSION['msgContact'] = $msg;
}


include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewContact.php';
include RACINE . '/view/footer.php';
