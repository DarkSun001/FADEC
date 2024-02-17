<?php

require __DIR__ . "/../../library/request.php";
require __DIR__ . "/../../models/materiaux.php";
require __DIR__ . "/../../library/json-response.php";

try {
    // Pas besoin de données du corps de la requête pour cette opération
    $request = Request::getRequest();

    $materiaux = new Materiaux();
    $result = $materiaux->getAll();

    // Envoyer la réponse JSON directement sans temporisation de sortie
    Response::json(200, [], $result);
} catch (Exception $e) {
    Response::json(500, [], ["message" => $e->getMessage()]);
}
?>
