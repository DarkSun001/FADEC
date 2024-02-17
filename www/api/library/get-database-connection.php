<?php

class Database
{
    private static $instance = null;
    private $conn;

    private $driver = "pgsql";
    private $databaseName = "fadec_db";
    private $hostName = "postgres";
    private $userName = "fadec_user";
    private $password = "fadec_mdp";
    private $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];


    private function __construct()
    {
        //var dump password 
        var_dump($this->password);
        var_dump($this->userName);
        $dataSourceName = "$this->driver:dbname=$this->databaseName;host=$this->hostName;port=5432";
        $this->conn = new PDO($dataSourceName, $this->userName, $this->password, $this->options);
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>