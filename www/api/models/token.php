<?php

require_once __DIR__ . '/../library/get-database-connection.php';
require_once __DIR__ . '/../library/functions/genId.php';

class Token
{
    private $conn;
    private $genId;
    public $id;
    public $token;
    public $user_id;
    public $created_at;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->genId = new GenId();
    }

    public function create()
    {
        // Générer un identifiant unique pour le token
        $this->id = $this->genId->generateRandomId();

        // Préparer la requête d'insertion
        $query = "INSERT INTO cat_token (id, token, user_id, created_at) VALUES (:id, :token, :user_id, NOW())";
        $stmt = $this->conn->prepare($query);

        // Liage des valeurs aux paramètres de la requête
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":user_id", $this->user_id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        // Préparer la requête de suppression
        $query = "DELETE FROM cat_token WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Liage des valeurs aux paramètres de la requête
        $stmt->bindParam(":id", $this->id);

        // Exécution de la requête
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    public function getTokenByUserId()
    {
        // Préparer la requête de sélection
        $query = "SELECT * FROM cat_token WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);

        // Liage des valeurs aux paramètres de la requête
        $stmt->bindParam(":user_id", $this->user_id);

        // Exécution de la requête
        $stmt->execute();

        return $stmt;
    }
}

?>
