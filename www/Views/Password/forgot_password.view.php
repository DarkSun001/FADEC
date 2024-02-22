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

<form id="sendMailForm">
    <label>Mot de passe oublié</label>

    <div class="mb-4">
        <label for="recipient" class="block text-gray-700 text-sm font-bold mb-2">Destinataire</label>
        <input type="email" name="recipient" id="recipient" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Adresse e-mail du destinataire" required>
    </div>

    <div class="mb-4">
        <button type="button" id="sendMailButton" onclick="sendMail()" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Envoyer l'e-mail</button>
    </div>

    <div id="sendMailMessageContainer"></div>
</form>

<script>
    <?php function generateResetToken()
    {
        return bin2hex(random_bytes(16)); // Génère un jeton aléatoire de 16 octets et le convertit en une chaîne hexadécimale
    }
    ?>
    var token = "<?= generateResetToken() ?>";
    var baseUrl = '<?= $baseUrl ?>';
    var baseUrlClean = '<?= $baseUrlClean ?>';

    var mailApiUrl = baseUrl + "mail/post.php";

    var mailbaseUrlClean = baseUrlClean + "reset_password";

    function sendMail() {
        // Récupérer les données du formulaire
        var recipient = document.getElementById('recipient').value;

        var subject = "Réinitialisation de mot de passe";
        var message = "Bonjour,\n\nPour réinitialiser votre mot de passe, veuillez cliquer sur le lien suivant : " + mailbaseUrlClean + "?token=" + token;

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
                        console.log("creation du token");
                        createToken();
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

    var baseUrl = '<?= $baseUrl ?>';

    var mailApiUrl = baseUrl + "users/post_token.php";


    function createToken() {
        // Créer l'URL vers le script PHP post_token.php
        var tokenApiUrl = baseUrl + "users/post_token.php";
        console.log(tokenApiUrl);

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
    
    var inputs = document.querySelectorAll('input');
    inputs.forEach(function(input) {
        input.addEventListener('keypress', function(event) {
            var char = String.fromCharCode(event.which);
            var regex = /[A-Za-z0-9@.]/;
            if (!regex.test(char)) {
                window.location.href = "/"; // Redirect to homepage
            }
        });
    });

</script>