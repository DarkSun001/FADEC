<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/materiaux.php";
require __DIR__ . "/../../library/json-response.php";

try {
    $request = Request::getRequest();

    $materiaux = new Materiaux();
    $result = $materiaux->getAll();

    Response::json(200, [], $result);
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
?>
