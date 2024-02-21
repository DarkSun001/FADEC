<?php
// Récupérer le token depuis l'URL
$token = $_GET['token'] ?? '';

// Vérifier si le token est valide (par exemple, en vérifiant dans la base de données)
$validToken = false; // Vous devez implémenter cette logique

if ($validToken) {
    

} else {
    echo 'Token invalide';
}
?>

<form id="resetPasswordForm">

    <h2 class="text-2xl font-bold mb-4">Réinitialisation du mot de passe</h2>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre email" required>
    </div>

    <div class="mb-4">
        <label for="newPassword" class="block text-gray-700 text-sm font-bold mb-2">Nouveau mot de passe</label>
        <input type="password" name="newPassword" id="newPassword" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nouveau mot de passe" required>
    </div>

    <div class="mb-4">
        <label for="confirmPassword" class="block text-gray-700 text-sm font-bold mb-2">Confirmer le mot de passe</label>
        <input type="password" name="confirmPassword" id="confirmPassword" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Confirmer le mot de passe" required>
    </div>

    <div class="mb-4">
        <button type="button" id="resetPasswordButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Réinitialiser le mot de passe</button>
    </div>

    <div id="resetPasswordMessageContainer"></div>
</form>

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
    $(document).ready(function() {
        $("#resetPasswordButton").click(function() {
            // Récupérer les données du formulaire
            var email = $("#email").val();
            var newPassword = $("#newPassword").val();
            var confirmPassword = $("#confirmPassword").val();

            // Vérifier si les mots de passe correspondent
            if (newPassword !== confirmPassword) {
                $("#resetPasswordMessageContainer").html('<div class="text-red-600">Les mots de passe ne correspondent pas.</div>');
                return; // Arrêter l'exécution de la fonction
            }

            // Créer l'objet de données pour la requête AJAX
            var resetPasswordData = {
                "email": email,
                "newPassword": newPassword
            };

            var baseUrl = '<?= $baseUrl ?>';
            var apiUrl = baseUrl + "reset_password.php"; // Endpoint pour la réinitialisation du mot de passe

            // Envoyer la requête AJAX avec jQuery
            $.ajax({
                url: apiUrl,
                type: 'POST',
                data: JSON.stringify(resetPasswordData),
                contentType: 'application/json',
                success: function(response) {
                    // La requête a fonctionné
                    console.log(response);
                    // Afficher le message de retour
                    $("#resetPasswordMessageContainer").html('<div class="text-green-600">' + response.message + '</div>');
                },
                error: function(error) {
                    // La requête n'a pas fonctionné
                    if (error.responseJSON) {
                        console.log(error.responseJSON.message); // Afficher le message d'erreur du serveur
                        // Afficher le message d'erreur dans la div resetPasswordMessageContainer
                        $("#resetPasswordMessageContainer").html('<div class="text-red-600">' + error.responseJSON.message + '</div>');
                    } else {
                        console.log("Erreur inattendue:", error.responseText);
                        // Afficher une erreur inattendue dans la div resetPasswordMessageContainer
                        $("#resetPasswordMessageContainer").html('<div class="text-red-600">Erreur inattendue: ' + error.responseText + '</div>');
                    }
                }
            });
        });
    });
</script>