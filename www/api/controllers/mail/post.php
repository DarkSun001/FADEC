<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/mail.php";
require __DIR__ . "/../../library/json-response.php";

try {
    // Récupérer les données JSON envoyées depuis le formulaire
    $requestData = Request::getJsonBody();

    // Vérifier si les données sont valides
    if (!$requestData || !isset($requestData['recipient']) || !isset($requestData['subject']) || !isset($requestData['message'])) {
        throw new Exception("Invalid JSON input");
    }

    // Créer une instance de la classe Mail
    $mail = new Mail();

    // Assigner les données du formulaire à l'instance de Mail
    $mail->recipient = $requestData['recipient'];
    $mail->subject = $requestData['subject'];
    $mail->message = $requestData['message'];

    // Envoyer l'e-mail
    if ($mail->send()) {
        Response::json(200, [], ["message" => "L'e-mail a été envoyé avec succès"]);
    } else {
        Response::json(500, [], ["message" => "Erreur lors de l'envoi de l'e-mail"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
