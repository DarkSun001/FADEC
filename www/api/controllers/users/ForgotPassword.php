<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h2>Mot de passe oublié</h2>
    <form id="forgotPasswordForm" action="reset_password.php" method="POST">
    <div>
        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <button type="submit">Envoyer</button>
    </div>
</form>
    
    <div id="messageContainer"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#forgotPasswordForm').submit(function(event) {
                event.preventDefault();
                
                var email = $("#email").val();

                // Créer l'objet de données pour la requête AJAX
                var resetData = {
                    "email": email
                };

                var baseUrl = location.hostname === "localhost" ? "http://localhost:80/api/controllers" : "http://141.94.203.225/api/controllers";
                var apiUrl = baseUrl;

                // Envoi de la requête AJAX avec jQuery
                $.ajax({
                    url: apiUrl,
                    type: 'POST',
                    data: JSON.stringify(resetData),
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
</body>
</html>
