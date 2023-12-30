<?php

// Assuming you have a get-database-connection.php file
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

    public function create()
    {
        // Adapt the SQL query for user data
        $query = "INSERT INTO cat_user (id, email, name, password, status) 
                  VALUES (:id, :email, :name, :password, :status)";

        $stmt = $this->conn->prepare($query);

        // Sanitize and bind input
        $id = htmlspecialchars(strip_tags($this->id));
        $email = htmlspecialchars(strip_tags($this->email));
        $name = htmlspecialchars(strip_tags($this->name));
        $password = htmlspecialchars(strip_tags($this->password));
        $status = htmlspecialchars(strip_tags($this->status));

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":status", $status);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Additional methods (update, read, delete) as needed...
}

?>