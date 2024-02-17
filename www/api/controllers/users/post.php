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
    $user->id = $request["id"];
    $user->email = $request["email"];
    $user->name = $request["name"];
    $user->password = $request["password"];
    $user->status = $request["status"];

    if ($user->create()) {
        Response::json(201, [], ["message" => "User created"]);
    } else {
        Response::json(500, [], ["message" => "User not created"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
