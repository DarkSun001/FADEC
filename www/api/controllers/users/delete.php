<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();

    $user = new User();

    // Check if the request contains the user ID
    if (isset($request['id'])) {
        $user->id = $request['id'];

        if ($user->delete()) {
            Response::json(200, [], ["message" => "User deleted successfully"]);
        } else {
            Response::json(500, [], ["message" => "Failed to delete user"]);
        }
    } else {
        Response::json(400, [], ["message" => "User ID not provided"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
