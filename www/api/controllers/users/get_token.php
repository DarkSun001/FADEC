<?php

require_once __DIR__ . "/../../models/token.php";
require_once __DIR__ . "/../../library/json-response.php";

try {
    // Vérifier si l'ID de l'utilisateur est présent dans les paramètres de requête
    if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
        throw new Exception("User ID is missing in the request");
    }

    // Récupérer l'ID de l'utilisateur depuis les paramètres de requête
    $user_id = $_GET['user_id'];

    // Créer une instance de la classe Token
    $token = new Token();

    // Récupérer les tokens associés à l'ID de l'utilisateur
    $tokens = $token->getTokenByUserId($user_id);

    // Vérifier si des tokens ont été trouvés
    if ($tokens->rowCount() > 0) {
        // Extraire les résultats sous forme de tableau associatif
        $tokenList = $tokens->fetchAll(PDO::FETCH_ASSOC);
        // Répondre avec un code de succès et les tokens au format JSON
        Response::json(200, [], ["tokens" => $tokenList]);
    } else {
        // Aucun token trouvé pour cet utilisateur
        Response::json(404, [], ["message" => "No tokens found for this user"]);
    }
} catch (Exception $e) {
    // Répondre avec une erreur et le message d'erreur de l'exception
    Response::json(500, [], ["message" => $e->getMessage()]);
}

?>
