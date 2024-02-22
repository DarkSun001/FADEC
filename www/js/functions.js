
var baseUrl = location.hostname === "localhost" ? "http://localhost:80/api/controllers" : "http://141.94.203.225/api/controllers";
var clearUrl = location.hostname === "localhost" ? "http://localhost:80/" : "http://141.94.203.225/";



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
    
    var inputRow = document.createElement('tr');
    inputRow.innerHTML = '<td>AUTO-GENERATED</td>' +
                         '<td><input type="text" id="newUserName" placeholder="Name"></td>' +
                         '<td><input type="text" id="newUserEmail" placeholder="Email"></td>' +
                         '<td><input type="number" id="newUserStatus" placeholder="Status" min="0" max="3"></td>' +
                         '<td><input type="password" id="newUserPassword" placeholder="Password"></td>' +
                         '<td><button onclick="createNewUser()">Create</button></td>';
    
    // Append the input row to the table body
    tableBody.appendChild(inputRow);

    if (users.length === 0) {
        var row = document.createElement('tr');
        row.innerHTML = '<td colspan="5">No users found</td>';
        tableBody.appendChild(row);
        return;
    }
    
    users.forEach(function (user) {
        var row = document.createElement('tr');
        row.innerHTML = '<td>' + user.id + '</td>' +
            '<td><input type="text" class="edit-name" value="' + user.name + '"></td>' +
            '<td>' + user.email + '</td>' +
            '<td><input type="number" min="0" max="3" class="edit-status" value="' + user.status + '"></td>' +
            '<td>PASSWORD </td>'+
            '<td>' +
            '<button class="save-btn" style="display:none">Save</button>' +
            '<button class="delete-btn" onclick="deleteUser(\'' + user.id + '\')">Delete</button>' +
            '</td>';
        tableBody.appendChild(row);

        // Add event listeners for input fields
        var editInputs = row.querySelectorAll('.edit-name, .edit-status');
        editInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var saveBtn = row.querySelector('.save-btn');
                saveBtn.style.display = 'inline-block';
            });
        });
        
        // Add event listener for save button
        var saveBtn = row.querySelector('.save-btn');
        saveBtn.addEventListener('click', function() {
            updateUser(row, user.id);
        });
    });
}


function toggleEditMode(row, editMode) {
    var editInputs = row.querySelectorAll('input.edit-name, input.edit-status');
    var saveBtn = row.querySelector('.save-btn');
    
    editInputs.forEach(function(input) {
        input.readOnly = !editMode;
    });

    if (editMode) {
        saveBtn.style.display = 'none';
    } else {
        saveBtn.style.display = 'inline-block';
    }
}

function updateUser(row, userId) {
    var name = row.querySelector('.edit-name').value;
    var status = row.querySelector('.edit-status').value;

    // Perform the update operation (send an AJAX request)
    var url = baseUrl + "/users/update.php";
    var data = JSON.stringify({ id: userId, name: name, status: status });
    //if status is not between 0 and 3 included stop function and alert 
    if (status < 0 || status > 3) {
        alert("Status must be between 0 and 3 included");
        return;
    }
    var xhttp = new XMLHttpRequest();
    xhttp.open("PATCH", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log("Update Successful");
                // Hide the "Save" button after successful update
                var saveBtn = row.querySelector('.save-btn');
                saveBtn.style.display = 'none';
                getAllUser();
            } else {
                console.error("Error: " + this.status);
            }
        }
    };

    xhttp.send(data);
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


function createNewUser() {
    var url = baseUrl + "/users/post.php";
    var name = document.getElementById("newUserName").value;
    var email = document.getElementById("newUserEmail").value;
    var status = document.getElementById("newUserStatus").value;
    var password = document.getElementById("newUserPassword").value;

    if (status < 0 || status > 3) {
        alert("Status must be between 0 and 3 included");
        return;
    }

    if (name === "" || email === "" || password === "") {
        alert("Name, Email and Password must be filled");
        return;
    }
    var data = JSON.stringify({ name: name, email: email, status: status, password: password});

    console.log("Create URL:", url);
    console.log("Create Data:", data);

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    xhttp.onreadystatechange = function () {
        console.log("ReadyState:", this.readyState);
        console.log("Status:", this.status);

        if (this.readyState == 4) {
            if (this.status == 201) {
                console.log("Create Successful");
                getAllUser();
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


