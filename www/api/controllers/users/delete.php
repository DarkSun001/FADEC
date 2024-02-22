<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/users.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();

    $user = new User();

    if (isset($request['id']) && isset($request['session_delete']) && $request['session_delete'] == true) {
        $user->id = $request['id'];
        var_dump($user->id);

        if ($user->disconnect() == true) {
            Response::json(200, [], ["message" => "User session deleted successfully"]);
            return;
        } else {
            Response::json(500, [], ["message" => "Failed to delete user session"]);
            return;
        }
    }

    if (isset($request['id'] )) {
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
