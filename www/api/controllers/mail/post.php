<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/mail.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();

    if (!$request) {
        throw new Exception("Invalid JSON input");
    }


} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
