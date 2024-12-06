<?php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode d'inscription
    public function register() {
       
        $query = "INSERT INTO " . $this->table . " (username, email, password, role) VALUES (:username, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // Hachage du mot de passe pour la sécurité
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        // Liaison des paramètres
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $this->role);
       

        // Exécution de la requête et gestion des erreurs
        if ($stmt->execute()) {
            return json_encode(["message" => "Inscription réussie"]);
        } else {
            $errorInfo = $stmt->errorInfo(); 
            return json_encode(["message" => "Erreur lors de l'inscription", "error" => $errorInfo[2]]);
        }
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
           
            if (password_verify($this->password, $user['password'])) {
                return $user; 
            } else {
                error_log("Mot de passe incorrect pour l'email: " . $this->email);
            }
        } else {
            error_log("Utilisateur non trouvé pour l'email: " . $this->email);
        }
    
        return false; 
    }
    
    
}
?>
