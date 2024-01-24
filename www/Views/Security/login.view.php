<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



<script>
    // Données JSON à envoyer dans la requête pour le login
    var loginData = {
        "email": "adam1@gmail.com",
        "password": "adib"
    };

    console.log(loginData);

    // URL de l'API pour le login (mettez à jour le nom du fichier en fonction de votre backend)
    var loginApiUrl = 'http://localhost:80/api/controllers/users/get.php';

    
    // Envoi de la requête AJAX avec jQuery

    $.ajax({
        url: loginApiUrl,
        type: 'POST',
        data: JSON.stringify(loginData),
        contentType: 'application/json',
        success: function(response) {
            // La requête a fonctionné
            console.log(response);
            console.log("login success");
        },
        error: function(error) {
            // La requête n'a pas fonctionné
            console.log(error);
        }
    });
  
 
</script>