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
