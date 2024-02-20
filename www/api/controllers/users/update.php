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
    $requiredFields = ['id'];
    foreach ($requiredFields as $field) {
        if (!isset($request[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    $user = new User();
    $user->id = $request["id"];

    // Check if the name and/or status fields are provided
    if (isset($request['name'])) {
        $user->name = $request['name'];
    }

    if (isset($request['status'])) {
        $user->status = $request['status'];
    }


    // Perform the update operation
    if ($user->update()) {
        Response::json(200, [], ["message" => "User updated successfully"]);
    } else {
        Response::json(500, [], ["message" => "Failed to update user"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}