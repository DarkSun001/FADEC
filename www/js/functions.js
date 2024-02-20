
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

function forgotPassword(email) {
    var baseUrl = location.hostname === "localhost" ? "http://localhost:80/api/controllers" : "http://141.94.203.225/api/controllers";
    var url = baseUrl + "/users/ForgotPassword.php";
    var data = JSON.stringify({ email: email });

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                alert("Un e-mail de réinitialisation de mot de passe a été envoyé à votre adresse e-mail.");
            } else {
                alert("Une erreur est survenue lors de la réinitialisation de votre mot de passe. Veuillez réessayer plus tard.");
            }
        }
    };

    xhttp.send(data);
}