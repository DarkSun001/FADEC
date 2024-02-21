<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>
<script>
    var baseUrl = '<?= $baseUrl ?>';
    var apiUrl = baseUrl + "users/get.php";

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

