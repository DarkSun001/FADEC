<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/mail.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getJsonBody();

    if (!$request) {
        throw new Exception("Invalid JSON input");
    }

    $mail = new Mail();
    $mail->recipient = $request["recipient"];
    $mail->subject = $request["subject"];
    $mail->message = $request["message"];

    if ($mail->send()) {
        Response::json(201, [], ["message" => "Mail sent", "mail" => $mail]);
    } else {
        Response::json(500, [], ["message" => "Mail not sent"]);
    }
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
