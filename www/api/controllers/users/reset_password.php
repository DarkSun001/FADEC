<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();

    if (!$request) {
        throw new Exception("Invalid JSON input");
    }

    // Check if the required fields are present in the request
    $requiredFields = ['id', 'password']; // Ajoutez 'password' comme champ requis
    foreach ($requiredFields as $field) {
        if (!isset($request[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $user = new User();
    $user->id = $request["id"];

    // Check if the password field is provided
    if (isset($request['password'])) {
        // Vous devez effectuer des validations supplémentaires sur le mot de passe si nécessaire
        $user->password = password_hash($request['password'], PASSWORD_DEFAULT);
    }

    // Perform the update operation
    if ($user->updatePassword()) { // Vous devez implémenter une méthode 'updatePassword' dans votre modèle User
        Response::json(200, [], ["message" => "Password updated successfully"]);
    } else {
        Response::json(500, [], ["message" => "Failed to update password"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
