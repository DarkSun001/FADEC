<form method="post">
    <h2>Connexion</h2>
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Se Connecter</button>
</form>
<?php
$host = 'postgres';
$port = 5432;
$database = 'fadec_bdd';
$user = 'fadec_user';
$password = 'fadec_mdp';

try {
    $dbh = new PDO("pgsql:host=$host;port=$port;dbname=$database;user=$user;password=$password");
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
