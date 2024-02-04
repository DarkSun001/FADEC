<?php
require 'vendor/autoload.php';  // Assurez-vous d'avoir le fichier autoload.php de Guzzle

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

// Remplacez les placeholders avec vos propres informations
$url = 'http://localhost:8080/login?next=%2F';
$username = 'admin@example.com';
$password = 'admin';

// Créez un client Guzzle
$client = new Client();

// Créez un gestionnaire de cookies
$cookieJar = new CookieJar();

// Effectuez une requête GET pour récupérer les cookies de la session
$response = $client->request('GET', $url, ['cookies' => $cookieJar]);

// Récupérez le token CSRF ou d'autres données nécessaires depuis la page de connexion

// Effectuez une requête POST pour soumettre le formulaire de connexion
$response = $client->request('POST', $url, [
    'form_params' => [
        'username' => $username,
        'password' => $password,
        'csrf_token' => 'votre_token_csrf',  // Remplacez par le token CSRF récupéré précédemment
    ],
    'cookies' => $cookieJar,
]);

// Affichez la réponse (peut être utile pour le débogage)
echo $response->getBody();