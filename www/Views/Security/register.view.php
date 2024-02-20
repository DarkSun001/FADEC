<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>

<form id="registerForm">

    <h2 class="text-2xl font-bold mb-4">Inscription</h2>

    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
        <input type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre nom" required>
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre email" required>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
        <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre mot de passe" required>
    </div>

    <div>
        <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
        <select name="status" id="status" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" required>
            <option value="1">1 à definir</option>
            <option value="0">0 à definir</option>
        </select>
    </div>

    <div class="mb-4">
        <button type="button" id="registerButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">S'inscrire</button>
    </div>
    
    <div id="registerMessageContainer"></div>
</form>

<script>
    $(document).ready(function() {
        $("#registerButton").click(function() {
            // Récupérez les données du formulaire
            // var id = $("#id").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var status = $("#status").val();

            // Créez l'objet de données pour la requête AJAX
            var registerData = {
                // "id": id,
                "name": name,
                "email": email,
                "password": password,
                "status": status
            };

            var baseUrl = '<?= $baseUrl ?>';
            var apiUrl = baseUrl + "users/post.php";

            // Envoi de la requête AJAX avec jQuery
            $.ajax({
                url: apiUrl,
                type: 'POST',
                data: JSON.stringify(registerData),
                contentType: 'application/json',
                success: function(response) {
                    // La requête a fonctionné
                    console.log(response);
                    // Afficher le message de retour
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
        });
    });
</script>