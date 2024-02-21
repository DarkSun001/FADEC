<?php

namespace App;

use Dotenv\Dotenv;

require "vendor/autoload.php";

/*
    Si nous sommes sur l'url /login alors il faut instancier
    la class (controller) Security et appeler la method (Action) login
    Si l'url ne correspond à rien  alors il faut instancier
    la class (controller) Main et appeler la method (Action) page404
*/

//Récupérer l'URL et ne garder que l'URI, exemple /login

spl_autoload_register("App\myAutoloader");
function myAutoloader($class)
{
    //$class = App\Core\View
    $file = str_replace("App\\", "", $class);
    $file = str_replace("\\", "/", $file);
    $file .= ".php";
    if (file_exists($file)) {
        include $file;
    }
}

$uri = strtolower($_SERVER["REQUEST_URI"]);
$uri = strtok($uri, "?");
if (strlen($uri) > 1) $uri = rtrim($uri, "/");

//Récupérer le contenu du fichier routes.yaml
$fileRoute = "routes.yaml";
if (file_exists($fileRoute)) {
    $listOfRoutes = yaml_parse_file($fileRoute);
} else {
    die("Le fichier de routing n'existe pas");
}

//Comparer son URI avec ce que l'on a dans le fichier routes et voir s'il y a une correspondance
//S'il y a une correspandance on doit récupérer le controller et l'action
//On fait toutes les vérifications nécessaires et on fait
//une instance du controller et l'appel de l'action

if (!empty($listOfRoutes[$uri])) {
    if (!empty($listOfRoutes[$uri]["controller"])) {
        if (!empty($listOfRoutes[$uri]["action"])) {

            $controller = $listOfRoutes[$uri]["controller"];
            $action = $listOfRoutes[$uri]["action"];

            if (file_exists("Controllers/" . $controller . ".php")) {
                include "Controllers/" . $controller . ".php";
                $controller = "App\\Controllers\\" . $controller;
                if (class_exists($controller)) {
                    $object = new $controller();
                    if (method_exists($object, $action)) {
                        $object->$action();
                    } else {
                        die("L'action' " . $action . " n'existe pas");
                    }
                } else {
                    die("Le class controller " . $controller . " n'existe pas");
                }
            } else {
                die("Le fichier controller " . $controller . " n'existe pas");
            }
        } else {
            die("La route " . $uri . " ne possède pas d'action dans le ficher " . $fileRoute);
        }
    } else {
        die("La route " . $uri . " ne possède pas de controller dans le ficher " . $fileRoute);
    }
} else {
    //S'il n'y a pas de correspondance => page 404
    include "Controllers/Error.php";
    $object = new Controllers\Error();
    $object->page404();
}
?>
<script>
   
    var apiUrl = "";

    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: apiUrl,
        type: 'GET',
        contentType: 'application/json',
        success: function(response) {
            // La requête a fonctionné
            console.log(response);

            // Vérifier si aucun utilisateur avec le statut 3 n'est retourné
            if (!(response.users && response.users.length > 0 && response.users[0].status === 3)) {
                // Aucun utilisateur avec le statut 3, rediriger vers la page "register"
                window.location.href = "register";
                return; // Arrêter l'exécution ici pour éviter d'afficher le message
            }

            // Il y a des utilisateurs avec le statut 3, traiter normalement
            $("#registerMessageContainer").html('<div class="text-green-600">' + response.message + '</div>');
        },
        error: function(error) {
            // La requête n'a pas fonctionné
            if (error.responseJSON) {
                console.log(error.responseJSON.message); // Afficher le message d'erreur du serveur
                // Afficher le message d'erreur dans la div registerMessageContainer
                $("#registerMessageContainer").html('<div class="text-red-600">' + error.responseJSON.message + '</div>');
            } else {
                console.log("Erreur inattendue:", error.responseText);
                // Afficher une erreur inattendue dans la div registerMessageContainer
                $("#registerMessageContainer").html('<div class="text-red-600">Erreur inattendue: ' + error.responseText + '</div>');
            }
        }
    });
</script>