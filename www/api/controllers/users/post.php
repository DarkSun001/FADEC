<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();
    if (!$request) {
        throw new Exception("Invalid JSON input");
    }

    $user = new User();
    $user->name = $request['name'];
    $user->email = $request['email']; 
    $user->password = $request['password'];
    $user->jwt_token = $user->generateJwtToken();
    

    if ($user->create()) {
        Response::json(201, [], ["jwt_token" => $user->jwt_token]);
        
    } else {
        Response::json(500, [], ["message" => "User not created"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
