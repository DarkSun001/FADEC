<?php


require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/json-response.php";


try {
    $request = Request::getJsonBody();

    $user = new User();
    $user->email = $request['email'];
    $user->password = $request['password'];

    if ($user->login()) {
        Response::json(200, [], ["message" => "Login successful"]);
    } else {
        Response::json(401, [], ["message" => "Invalid credentials"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}

?>