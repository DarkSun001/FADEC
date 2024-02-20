<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>

<div id="resultats"></div>

<script>
    var baseUrl = '<?= $baseUrl ?>';
    var apiUrl = baseUrl + "materiaux/get.php";

    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: apiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {

            // Affichez les résultats dans la page
            var resultats = document.getElementById('resultats');
            resultats.innerHTML = '<h2>Prix des matériaux</h2>';
            resultats.innerHTML += '<ul>';

            response.forEach(function(materiaux) {
                // Créez un nouvel objet avec seulement les propriétés nécessaires
                var materiauxAffiche = {
                    nom: materiaux.nom,
                    prix_kilo: materiaux.prix_kilo
                };

                // Affichez le résultat dans la console
                console.log(materiauxAffiche);

                // Excluez l'affichage de l'ID dans le HTML généré
                resultats.innerHTML += '<li>' + materiauxAffiche.nom + ' : ' + materiauxAffiche.prix_kilo + ' €</li>';
            });

            resultats.innerHTML += '</ul>';
        },
        error: function(error) {
            // La requête n'a pas fonctionné
            console.error('Erreur de requête : ' + error.status + ' ' + error.statusText);
            console.log(error.responseText); // Affichez la réponse détaillée en cas d'erreur
        }
    });
</script>