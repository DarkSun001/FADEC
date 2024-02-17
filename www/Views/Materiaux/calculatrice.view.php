<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- je veux afficher les prix des matériaux dans cette page -->



<div id="resultats"></div>

<script>
    // URL de l'API pour récupérer les prix des matériaux
    var apiUrl = 'http://localhost:80/api/controllers/materiaux/getMateriaux.php';

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