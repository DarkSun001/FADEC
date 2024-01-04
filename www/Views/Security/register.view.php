<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    // Données JSON à envoyer dans la requête
    var jsonData = {
        "id": 12,
        "email": "adam1@gmail.com",
        "name": "adam",
        "password": "adib",
        "status": 1
    };

    console.log(jsonData);

    // URL de l'API
    
    var apiUrl = 'http://localhost:80/api/controllers/users/post.php';

    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: apiUrl,
        type: 'POST',
        data: JSON.stringify(jsonData),
        contentType: 'application/json',
        success: function(response) {
            // La requête a fonctionné
            console.log(response);
        },
        error: function(error) {
            // La requête n'a pas fonctionné
            console.log(error);
        }
    });


</script>