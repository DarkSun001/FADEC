
var baseUrl = location.hostname === "localhost" ? "http://localhost:80/api/controllers" : "http://141.94.203.225/api/controllers";


function getAllUser(data, callback) {
url = baseUrl + "/users/get.php";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                if (typeof callback === 'function') {
                    callback(this.responseText);
                }
                var responseData = JSON.parse(this.responseText);


                var users = responseData.users;

                updateTable(users);
            } else {
                console.error("Error: " + this.status);
            }
        }
    };
    xhttp.open("GET", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function updateTable(users) {
    var tableBody = document.querySelector('#userTable tbody');
    tableBody.innerHTML = '';

    if (users.length === 0) {
        var row = document.createElement('tr');
        row.innerHTML = '<td colspan="5">No users found</td>';
        tableBody.appendChild(row);
        return;
    }
    

    users.forEach(function (user) {
        console.log(user);
        var row = document.createElement('tr');
        row.innerHTML = '<td>' + user.id + '</td>' +
            '<td>' + user.name + '</td>' +
            '<td>' + user.email + '</td>' +
            '<td>' + user.status + '</td>' +
            '<td>' +
            '<a>Edit</a>' +
            '<a onclick="deleteUser(\'' + user.id + '\')">Delete</a>' +
            '</td>';
        tableBody.appendChild(row);
    });
}
function deleteUser(id) {
    var url = baseUrl + "/users/delete.php";
    var data = JSON.stringify({ id: id });

    console.log("Delete URL:", url);
    console.log("Delete Data:", data);

    var xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    xhttp.onreadystatechange = function () {
        console.log("ReadyState:", this.readyState);
        console.log("Status:", this.status);

        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log("Delete Successful");
                getAllUser(); // Refresh user list after deletion
            } else {
                console.error("Error: " + this.status);
            }
        }
    };

    xhttp.send(data);
}


// var mailApiUrl = baseUrl + "mail/post.php";

// function sendMail() {
//     // Récupérer les données du formulaire
//     var recipient = document.getElementById('recipient').value;
//     var subject = document.getElementById('subject').value;
//     var message = document.getElementById('message').value;

//     // Créer l'objet de données pour la requête AJAX
//     var mailData = {
//         "recipient": recipient,
//         "subject": subject,
//         "message": message
//     };
//     console.log(mailData);

//     // Envoi de la requête AJAX avec JavaScript pur
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', mailApiUrl, true);
//     xhr.setRequestHeader('Content-Type', 'application/json');
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4) {
//             try {
//                 if (xhr.status === 200) {
//                     // La requête a fonctionné
//                     var response = JSON.parse(xhr.responseText);
//                     console.log(response);
//                     // Afficher le message de retour
//                     document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-green-600">' + response.message + '</div>';
//                 } else {
//                     // La requête n'a pas fonctionné
//                     var errorResponse = JSON.parse(xhr.responseText);
//                     console.log(errorResponse.message);
//                     document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-red-600">' + errorResponse.message + '</div>';
//                 }
//             } catch (error) {
//                 // Gestion des erreurs lors de l'analyse JSON
//                 console.error("Erreur lors de l'analyse JSON:", error);
//                 document.getElementById('sendMailMessageContainer').innerHTML = '<div class="text-red-600">Erreur lors de la réception de la réponse du serveur.</div>';
//             }
//         }
//     };

//     xhr.send(JSON.stringify(mailData));
// }