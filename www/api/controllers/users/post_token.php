<?php

require_once __DIR__ . "/../../models/token.php";
require_once __DIR__ . "/../../library/json-response.php";

try {
    // Créer une instance de la classe Token
    $token = new Token();

    // Créer le token
    if ($token->create()) {
        // Répondre avec un code de succès et un message JSON
        Response::json(201, [], ["message" => "Token created"]);
    } else {
        // Répondre avec une erreur et un message JSON en cas d'échec de la création du token
        Response::json(500, [], ["message" => "Failed to create token"]);
    }
} catch (Exception $e) {
    // Répondre avec une erreur et le message d'erreur de l'exception
    Response::json(500, [], ["message" => $e->getMessage()]);
}

?>
