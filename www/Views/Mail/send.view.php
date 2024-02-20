<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>
<form id="sendMailForm">

    <h2 class="text-2xl font-bold mb-4">Envoyer un e-mail</h2>

    <div class="mb-4">
        <label for="recipient" class="block text-gray-700 text-sm font-bold mb-2">Destinataire</label>
        <input type="email" name="recipient" id="recipient" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Adresse e-mail du destinataire" required>
    </div>

    <div class="mb-4">
        <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Sujet</label>
        <input type="text" name="subject" id="subject" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Sujet de l'e-mail" required>
    </div>

    <div class="mb-4">
        <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
        <textarea name="message" id="message" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre message" rows="4" required></textarea>
    </div>

    <div class="mb-4">
        <button type="button" id="sendMailButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer l'e-mail</button>
    </div>

    <div id="sendMailMessageContainer"></div>
</form>

<script>
    var baseUrl = '<?= $baseUrl ?>';
    var mailApiUrl = baseUrl + "mail/post.php";


    $(document).ready(function() {
        $("#sendMailButton").click(function() {
            // Récupérer les données du formulaire
            var recipient = $("#recipient").val();
            var subject = $("#subject").val();
            var message = $("#message").val();

            // Créer l'objet de données pour la requête AJAX
            var mailData = {
                "recipient": recipient,
                "subject": subject,
                "message": message
            };



            // Envoi de la requête AJAX avec jQuery
            $.ajax({
                url: mailApiUrl,
                type: 'POST',
                data: JSON.stringify(mailData),
                contentType: 'application/json',
                success: function(response) {
                    // La requête a fonctionné
                    console.log(response);
                    // Afficher le message de retour
                    $("#sendMailMessageContainer").html('<div class="text-green-600">' + response.message + '</div>');
                },
                error: function(error) {
                    // La requête n'a pas fonctionné
                    if (error.responseJSON) {
                        console.log(error.responseJSON.message);
                        $("#sendMailMessageContainer").html('<div class="text-red-600">' + error.responseJSON.message + '</div>');
                    } else {
                        console.log("Erreur inattendue:", error.responseText);
                        $("#sendMailMessageContainer").html('<div class="text-red-600">Erreur inattendue: ' + error.responseText + '</div>');
                    }
                }
            });
        });
    });
</script>