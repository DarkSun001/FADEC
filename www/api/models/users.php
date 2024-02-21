<?php

require_once __DIR__ . '/../library/get-database-connection.php';
require_once __DIR__ . '/../library/functions/genId.php';

class User
{
    private $conn;
    private $genId;
    public $id;
    public $email;
    public $name;
    public $password;
    public $status;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->genId = new GenId();
    }

    public function userExists()
    {
        // Check if either email or ID matches
        $query = "SELECT COUNT(*) FROM cat_user WHERE email = :email OR id = :id";
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);
    
        // Execute the query
        $stmt->execute();
    
        // Check if any rows are returned
        if ($stmt->fetchColumn() > 0) {
            return true; // User exists
        }
        return false; // User does not exist
    }

    public function create()
    {
        if ($this->userExists()) {
            throw new Exception("User already exists.");
        }

        // Générer un identifiant aléatoire
        $this->id = $this->genId->generateRandomId();

        $query = "INSERT INTO cat_user (id, email, name, password, status) 
           VALUES (:id, :email, :name, :password, :status)";

        $stmt = $this->conn->prepare($query);

        $email = htmlspecialchars(strip_tags($this->email));
        $name = htmlspecialchars(strip_tags($this->name));
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $status = trim(htmlspecialchars(strip_tags($this->status)));

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


    public function delete()
    {
        $query = "DELETE FROM cat_user WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function update()
    {
        // Build the SQL query dynamically based on provided fields
        $query = "UPDATE cat_user SET";
        $params = [];
    
        // Check if name is provided and not empty
        if (!empty($this->name)) {
            $query .= " name = :name,";
            $params['name'] = $this->name;
        }
    
        // Check if status is provided
        if (isset($this->status)) {
            $query .= " status = :status,";
            $params['status'] = $this->status;
        }
    
        // Remove the trailing comma if any
        $query = rtrim($query, ',');
    
        // Add WHERE clause for user ID
        $query .= " WHERE id = :id";
    
        // Prepare the query
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters
        $stmt->bindParam(":id", $this->id);
        foreach ($params as $param => &$value) {
            $stmt->bindParam(":$param", $value);
        }
    
        // Execute the query
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }

    public function forgotPassword($email)
    {
        $query = "SELECT id FROM cat_user WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $userId = $row['id'];
    
            // Générer un nouveau mot de passe
            $newPassword = $this->genId->generateRandomId(); // Remplacez cette fonction par votre propre méthode pour générer un mot de passe aléatoire
            
            // Mettre à jour le mot de passe de l'utilisateur dans la base de données
            $updateQuery = "UPDATE cat_user SET password = :password WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt->bindParam(":password", $hashedPassword);
            $updateStmt->bindParam(":id", $userId);
            $updateStmt->execute();
    
            // Envoyer le nouveau mot de passe à l'utilisateur (par exemple, par e-mail)
    
            return true;

            // Remplacez cette fonction par votre propre méthode pour envoyer un e-mail
        }
    
        return false;
    }
    

}


