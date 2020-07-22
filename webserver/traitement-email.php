<?php


$name = htmlentities($_POST['name'], ENT_QUOTES, 'UTF-8');
$msg = htmlentities($_POST['message'], ENT_QUOTES, 'UTF-8');
$from = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$to = "email de la personne sans espaces";

$subject = "";  
// Sujet du mail (tu peux ajouter la variable $name pour afficher le nom de l'expéditeur
// par exemple : $subject = "Simulation pour Mme/M. $name";

$message = "";
// Ici tu peux aussi inclure la variable $name si besoin soit afficher un message posté par
// l'expediteur en faisant ceci : $message = "$msg";
// Ou afficher un message personnalisé

$headers = "From: $from" . "\r\n" .
           "Reply-To: $to" . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

mail($to,$subject,$message, $headers);

echo "Votre simulation a bien été envoyée par email. Nous viendrons vers vous dans les meilleurs délais. Merci !";
// Le echo c'est le message de succes qui s'affichera lorsque le client envoi l'email.