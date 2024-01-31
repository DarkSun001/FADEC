<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
 var registerData = {
        "id" : "1",
        "email": "adam1@gmail.com",
        "password": "adib",
        "name": "Adam",
        "status": "1",

    };

    console.log(registerData);

    // URL de l'API
    
    var apiUrl = 'http://localhost:80/api/controllers/users/post.php';

    // Envoi de la requête AJAX avec jQuery
    $.ajax({
        url: apiUrl,
        type: 'POST',
        data: JSON.stringify(registerData),
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

