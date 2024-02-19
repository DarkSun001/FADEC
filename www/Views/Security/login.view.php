<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>

<form id="loginForm">

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre email" required>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
        <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre mot de passe" required>
    </div>

    <div class="mb-4">
        <button type="button" id="loginButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se connecter</button>
    </div>

    <div id="messageContainer"></div>

</form>

<script>
    // Attendez que le DOM soit chargé
    $(document).ready(function() {
        // Ajoutez un gestionnaire d'événements au clic du bouton de connexion
        $("#loginButton").click(function() {
            // Récupérez les données du formulaire
            var email = $("#email").val();
            var password = $("#password").val();

            // Créez l'objet de données pour la requête AJAX
            var loginData = {
                "email": email,
                "password": password
            };

            var baseUrl = '<?= $baseUrl ?>';
            var apiUrl = baseUrl + "users/get.php";

            // Envoi de la requête AJAX avec jQuery
            $.ajax({
                url: apiUrl,
                type: 'POST',
                data: JSON.stringify(loginData),
                contentType: 'application/json',
                success: function(response) {
                    // La requête a fonctionné
                    console.log(response.message); // Afficher le message de retour

                    // Afficher le message dans la div messageContainer
                    $("#messageContainer").html('<div class="text-green-600">' + response.message + '</div>');
                },
                error: function(error) {
                    // La requête n'a pas fonctionné
                    if (error.responseJSON) {
                        console.log(error.responseJSON.message); // Afficher le message d'erreur du serveur

                        // Afficher le message d'erreur dans la div messageContainer
                        $("#messageContainer").html('<div class="text-red-600">' + error.responseJSON.message + '</div>');
                    } else {
                        console.log("Erreur inattendue:", error.responseText);

                        // Afficher une erreur inattendue dans la div messageContainer
                        $("#messageContainer").html('<div class="text-red-600">Erreur inattendue: ' + error.responseText + '</div>');
                    }
                }
            });
        });
    });
</script>