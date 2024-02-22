<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//get jwt_token from cookie
if(isset($_COOKIE['jwt_token'])){
    $jwt_token = $_COOKIE['jwt_token'];
   $algorithm = 'HS256';
   $key = new Key('4d4m1t0l3Sp3c1@lM3gaS3cr3tK3y', $algorithm);

    $headers = new stdClass();
    $decoded = JWT::decode($jwt_token, $key, $headers);
    $id = $decoded->id;

}

//header("Location: /404");
//exit();


?>

<script>
function disconnect () {
    console.log("Disconnecting...");


    
    var url = baseUrl + "/users/delete.php";
    console.log('<?php echo $id ?>')
    var data = JSON.stringify({ id: "<?php echo $id ?>" , session_delete: true });

    document.cookie = "jwt_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";


    localStorage.removeItem("jwt_token");

    var xhttp = new XMLHttpRequest();
    xhttp.open("DELETE", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");

    xhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                console.log("Logout Successful");
                console.log("Redirecting to " + clearUrl);
                window.location.href = clearUrl;
            } else {
                console.log("Redirecting to " + clearUrl);
                window.location.href = clearUrl;
                console.error("Error: " + this.status);
            }
        }
    };

    xhttp.send(data);
    
}
</script>

<nav class="navbar">
    <div class="container">
        <a href="#" class="navbar-brand">Logo</a>
        <ul class="navbar-nav">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">À propos</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="formulaire_devis">Devis</a></li>
            <?php if(isset($decoded)): ?>
                <li><span <?php if($decoded->status == 3) echo 'style="color: red;"'; ?>>Bonjour <?php echo $decoded->name; ?><?php if($decoded->status == 3) echo ' (admin)'; ?></span></li>
                <?php if($decoded->status == 3): ?>
                    <li><a href="/backoffice">Backoffice</a></li>
                <?php endif; ?>
                <li><a onclick="disconnect()">Déconnexion</a></li>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li><a href="login">Connexion</a></li>
                    <li><a href="register">Inscription</a></li>
                </ul>
            <?php endif; ?>
        </ul>
    </div>
</nav>
