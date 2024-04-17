<?php

if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $msg = 'Veuillez saisir tous les champs';
    } else {
        
        $to = 'ewenlm@proton.me'; 
        $headers = "From: $name <$email>" . "\r\n";

        // Envoyer l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            $msg = "Votre message a été envoyé !";
        } else {
            $msg = "Erreur lors de l'envoi du message. Veuillez réessayer.";
        }
    }
    $_SESSION['msgContact']= $msg;
}


include RACINE . '/view/head1.php';
include RACINE . '/view/head2.php';
include RACINE . '/view/header.php';
include RACINE . '/view/viewContact.php';
include RACINE . '/view/footer.php';
?>