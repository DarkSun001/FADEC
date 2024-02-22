<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

$clearUrl = str_replace('api/controllers/', '', $baseUrl);



?>



<form id="loginForm">

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre email" required>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
        <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre mot de passe" required>
    </div>

    <div class="mb-4">
        <button type="button" id="loginButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se connecter</button>
    </div>

    <div class="mb-4">
        <button type="button" id="forgotPassword" onclick="window.location.href = 'forgot_password'" class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Mot de passe oublié ?</button>
    </div>

    <div id="messageContainer"></div>

</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginButton").addEventListener("click", function() {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        var loginData = {
            "email": email,
            "password": password
        };

        var baseUrl = '<?= $baseUrl ?>';
        var clearUrl = '<?= $clearUrl ?>';
        var apiUrl = baseUrl + "users/get.php";

        var xhr = new XMLHttpRequest();
        xhr.open("POST", apiUrl, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200 || xhr.status === 201) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById("messageContainer").innerHTML = '<div class="text-green-600">' + response.message + '</div>';
                    if (response.jwt_token) {
                        document.cookie = "jwt_token=" + response.jwt_token;
                        console.log(baseUrl)
                        window.location.href = clearUrl;
                    }
                } else {
                    var errorMessage = "Erreur inattendue";
                    if (xhr.response) {
                        var errorResponse = JSON.parse(xhr.responseText);
                        errorMessage = errorResponse.message || "Erreur inattendue";
                    }
                    console.error(errorMessage);
                    document.getElementById("messageContainer").innerHTML = '<div class="text-red-600">' + errorMessage + '</div>';
                }
            }
        };
        xhr.send(JSON.stringify(loginData));
    });
});
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