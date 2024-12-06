<?php
class Database {
    private $host = "localhost";       
    private $db_name = "ecommerce";     
    private $username = "root";         
    private $password = "";             
    public $conn;

    
    public function getConnection() {
        $this->conn = null;

        try {
            // Création de la connexion PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
