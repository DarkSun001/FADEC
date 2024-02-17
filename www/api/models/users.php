<?php

require_once __DIR__ . '/../library/get-database-connection.php';

class User
{
    private $conn;

    public $id;
    public $email;
    public $name;
    public $password;
    public $status;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }


    public function userExists()
    {
        $query = "SELECT COUNT(*) FROM cat_user WHERE email = :email OR id = :id";
        $stmt->bindParam(":id", $this->id);
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->fetchColumn() > 0) {
            return true;
        }
        return false;
    }

    // Fonction pour générer un identifiant aléatoire
    function generateRandomId()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomId = '';
        for ($i = 0; $i < 10; $i++) {
            $randomId .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomId;
    }

    public function create()
    {
        if ($this->userExists()) {
            throw new Exception("User already exists.");
        }

        // Générer un identifiant aléatoire
        $this->id = $this->generateRandomId();

        $query = "INSERT INTO cat_user (id, email, name, password, status) 
           VALUES (:id, :email, :name, :password, :status)";

        $stmt = $this->conn->prepare($query);

        $email = htmlspecialchars(strip_tags($this->email));
        $name = htmlspecialchars(strip_tags($this->name));
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":status", $status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    

    public function login()
    {

        $query = "SELECT id, email, name, password FROM cat_user WHERE email = :email";

        $stmt = $this->conn->prepare($query);


        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM cat_user";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}