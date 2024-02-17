<?php

require_once __DIR__ . '/../library/get-database-connection.php';

class Materiaux
{
    private $conn;

    public $id;
    public $nom;
    public $prix_kilo;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM cat_materiaux";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM cat_materiaux WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create()
    {
        $query = "INSERT INTO cat_materiaux (nom, prix_kilo) VALUES (:nom, :prix_kilo)";
        $stmt = $this->conn->prepare($query);

        $nom = htmlspecialchars(strip_tags($this->nom));
        $prix_kilo = htmlspecialchars(strip_tags($this->prix_kilo));

        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prix_kilo", $prix_kilo);

        return $stmt->execute();
    }

    public function update()
    {
        $query = "UPDATE cat_materiaux SET nom = :nom, prix_kilo = :prix_kilo WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($this->id));
        $nom = htmlspecialchars(strip_tags($this->nom));
        $prix_kilo = htmlspecialchars(strip_tags($this->prix_kilo));

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prix_kilo", $prix_kilo);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM materiaux WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
