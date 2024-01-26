<h2>Login</h2>

<form id="loginForm">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>

    <button type="button" onclick="login()">Login</button>
</form>

<div id="result"></div>

<script>
    function login() {
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            type: 'GET',
            url: 'http://localhost:80/api/controllers/users/get.php', // Update with the absolute path
            data: JSON.stringify({
                email: email,
                password: password
            }),
            contentType: 'application/json',
            success: function(response) {
                $('#result').html('<p>' + response.message + '</p>');
                if (response.message === 'Login successful') {
                    // Redirect or perform any action after successful login
                }
            },
            error: function(xhr, status, error) {
                $('#result').html('<p>Error: ' + xhr.responseText + '</p>');
            }
        });
    }
</script>