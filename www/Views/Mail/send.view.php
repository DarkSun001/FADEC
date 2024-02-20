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
        <button type="button" id="sendMailButton" onclick="sendMail()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer l'e-mail</button>
    </div>

    <div id="sendMailMessageContainer"></div>
</form>

<script>
    var baseUrl = '<?= $baseUrl ?>';
    
var mailApiUrl = baseUrl + "mail/post.php";
    function sendMail() {
    // Récupérer les données du formulaire
    var recipient = document.getElementById('recipient').value;
    var subject = document.getElementById('subject').value;
    var message = document.getElementById('message').value;

    // Créer l'objet de données pour la requête AJAX
    var mailData = {
        "recipient": recipient,
        "subject": subject,
        "message": message
    };
    console.log(mailData);

    // Envoi de la requête AJAX avec JavaScript pur
    var xhr = new XMLHttpRequest();
    xhr.open('POST', mailApiUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            try {
                if (xhr.status === 200) {
                    // La requête a fonctionné
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                    // Afficher le message de retour
                    document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-green-600">' + response.message + '</div>';
                } else {
                    // La requête n'a pas fonctionné
                    var errorResponse = JSON.parse(xhr.responseText);
                    console.log(errorResponse.message);
                    document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-red-600">' + errorResponse.message + '</div>';
                }
            } catch (error) {
                // Gestion des erreurs lors de l'analyse JSON
                console.error("Erreur lors de l'analyse JSON:", error);
                document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-red-600">Erreur lors de la réception de la réponse du serveur.</div>';
            }
        }
    };

    xhr.send(JSON.stringify(mailData));
}

</script>