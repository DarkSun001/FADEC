<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
    $baseUrlClean = $_ENV['LOCALHOST_URL2'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
    $baseUrlClean = $_ENV['PROD_URL2'];
}
?>

<form id="createTokenForm">
    <h2 class="text-2xl font-bold mb-4">Créer un jeton</h2>
    <div class="mb-4">
        <label for="userId" class="block text-gray-700 text-sm font-bold mb-2">ID utilisateur</label>
        <input type="text" name="userId" id="userId" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="ID de l'utilisateur" required>
    </div>
    <div class="mb-4">
        <button type="button" id="createTokenButton" onclick="createToken()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Créer le jeton</button>
    </div>
    <div id="createTokenMessageContainer"></div>
</form>

<script>
    var baseUrl = '<?= $baseUrl ?>';

    var mailApiUrl = baseUrl + "users/post_token.php";

    function createToken() {
        // Créer l'URL vers le script PHP post_token.php
        var tokenApiUrl = baseUrl + "users/post_token.php";
        console.log(tokenApiUrl);

        var fakeToken = "fake_token";
        var fakeUserId = "fake_user_id";

        var requestData = {
            "token": fakeToken,
            "user_id": fakeUserId
        };

        // Envoi de la requête AJAX avec JavaScript pur
        var xhr = new XMLHttpRequest();
        xhr.open("POST", tokenApiUrl, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 201) {
                    // La requête a réussi
                    console.log("Token créé avec succès.");
                } else {
                    // La requête a échoué
                    console.error("Erreur lors de la création du token.");
                }
            }
        };
        
        // Envoyer la requête avec des données vides, car aucune donnée n'est nécessaire pour la création du token
        xhr.send(JSON.stringify({}));
    }

</script>