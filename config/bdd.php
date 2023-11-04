<?php
try {
    $host = "127.0.0.1";
    $port = "5432"; // Port par défaut pour PostgreSQL.
    $username = "postgres";
    $password = "postgres";
    $database = "postgres";
    $charset = "utf8"; // Définissez le jeu de caractères approprié pour votre base de données.

    $dsn = "pgsql:host=$host;port=$port;dbname=$database;user=$username;password=$password";

    $pdo = new PDO($dsn);

    // Définissez les attributs PDO pour la gestion des erreurs et les modes (facultatif).
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Votre connexion à la base de données est désormais établie et stockée dans la variable $pdo.
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}

// Vous pouvez effectuer des opérations de base de données en utilisant la connexion $pdo ici.

// N'oubliez pas de fermer la connexion à la base de données lorsque vous avez terminé.
$pdo = null;

