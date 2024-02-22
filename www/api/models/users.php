<?php

require_once __DIR__ . '/../library/get-database-connection.php';
require_once __DIR__ . '/../library/functions/genId.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

class User
{
    private $conn;
    private $genId;
    public $id;
    public $email;
    public $name;
    public $password;
    public $status;
    public $jwtToken;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
        $this->genId = new GenId();
    }

    public function userExists()
    {
        $query = "SELECT COUNT(*) FROM cat_user WHERE email = :email OR id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":id", $this->id);
        
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            return true;
        }
        
        return false;
        
        
    }

    public function create()
    {


     
       
        $this->id = $this->genId->generateRandomId();
        if ($this->userExists()) {
            throw new Exception("User already exists.");
        }
    
        $this->status = 0;
  

      
    
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO cat_user (id, email, name, password, status, jwt_token) 
                  VALUES (:id, :email, :name, :password, :status, :jwt_token)";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":status", $this->status);
        

        $jwtToken = $this->generateJwtToken();
        $stmt->bindParam(":jwt_token", $jwtToken);
    
        if ($stmt->execute()) {
            return $jwtToken;
        }
    
        return false;
    }

    public function getUserById()
    {
        $query = "SELECT * FROM cat_user WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        return $stmt;
    }


    

    public function login()
    {

        $query = "SELECT id, email, name, password, status FROM cat_user WHERE email = :email";

        $stmt = $this->conn->prepare($query);


        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->status = $row['status'];

            if (password_verify($this->password, $row['password'])) {
                if ($this->status == 0) {
                    return 0;

                }


                $this->id = $row['id'];
                $this->name = $row['name'];
                $this->email = $row['email'];
                $this->jwtToken = $this->generateJwtToken();
                
                $this->insertNewToken($this->id, $this->jwtToken);
                return $this->jwtToken;
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
    
            
            $newPassword = $this->genId->generateRandomId(); 
            
            
            $updateQuery = "UPDATE cat_user SET password = :password WHERE id = :id";
            $updateStmt = $this->conn->prepare($updateQuery);
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt->bindParam(":password", $hashedPassword);
            $updateStmt->bindParam(":id", $userId);
            $updateStmt->execute();
    
           
    
            return true;

            
        }
    
        return false;
    }
    

    public function insertNewToken($userId, $token)
    {
        $query = "UPDATE cat_user SET
                    jwt_token = :token
                    WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":token", $token);
        $stmt->bindParam(":id", $userId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

    }

    public function generateJwtToken()
    {
     
        $secretKey = "4d4m1t0l3Sp3c1@lM3gaS3cr3tK3y";


        $payload = array(
            "id" => $this->id,
            "email" => $this->email,
            "name" => $this->name,
            "status" => $this->status,
            "exp" => time() + 60 * 60 * 24 
        );

        $algorithm = 'HS256';

        // Generate JWT token
        $token = JWT::encode($payload, $secretKey, $algorithm);


        return $token;
    }



    public function disconnect()
    {
        $query = "UPDATE cat_user SET jwt_token = '' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = $errorInfo[2] ?? "Unknown error";
            throw new Exception("Error executing SQL query: " . $errorMessage);
        }
     
    }
}


