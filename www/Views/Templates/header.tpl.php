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
}
?>

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
                <li><span>Bonjour <?php echo $decoded->name; ?></span></li>
                <li><a href="logout">Déconnexion</a></li>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li><a href="login">Connexion</a></li>
                    <li><a href="register">Inscription</a></li>
                </ul>
            <?php endif; ?>
        </ul>
    </div>
</nav>
