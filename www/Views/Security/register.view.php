<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    $baseUrl = $_ENV['LOCALHOST_URL'];
} else {
    $baseUrl = $_ENV['PROD_URL'];
}

?>

<form id="registerForm">

    <h2 class="text-2xl font-bold mb-4">Inscription</h2>

    <div class="mb-4">
        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
        <input type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre nom" required>
    </div>

    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" id="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre email" required>
    </div>

    <div class="mb-4">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
        <input type="password" name="password" id="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Votre mot de passe" required>
    </div>

    <div class="mb-4">
        <button type="button" id="registerButton" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">S'inscrire</button>
    </div>

    <div id="registerMessageContainer"></div>
</form>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var registerButton = document.getElementById("registerButton");
    registerButton.addEventListener("click", function() {
        // Retrieve form data
        var name = document.getElementById("name").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;

        // Create data object for AJAX request
        var registerData = {
            "name": name,
            "email": email,
            "password": password
        };

        var baseUrl = '<?php echo $baseUrl; ?>';
        var apiUrl = baseUrl + "users/post.php";

        // Send AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", apiUrl, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 201) {
                    // Registration successful
                    console.log("xhr.responseText" + xhr.responseText);
                    var response = JSON.parse(xhr.responseText);
                    console.log(response);
                    console.log("User registered successfully");
                    document.getElementById("registerMessageContainer").innerHTML = '<div class="text-green-600">User registered successfully</div>';
                } else {
                    // Registration failed
                    var errorResponse = JSON.parse(xhr.responseText);
                    var errorMessage = errorResponse.message || "Unexpected error";
                    console.error(errorMessage);
                    
                    document.getElementById("registerMessageContainer").innerHTML = '<div class="text-red-600">' + errorMessage + '</div>';
                }
            }
        };
        xhr.send(JSON.stringify(registerData));
    });
});
</script>