<?php
require_once '../config/Database.php';
require_once '../models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();

        if (!$this->db) {
            throw new Exception("Erreur de connexion à la base de données.");
        }

        $this->user = new User($this->db);
    }

    // Méthode pour gérer l'inscription
    public function register($username, $email, $password, $role = 'user') {
        try {
            $this->user->username = $username;
            $this->user->email = $email;
            $this->user->password = $password;
            $this->user->role = $role;

            $result = $this->user->register();

            if ($result) {
                return json_encode(["message" => "Inscription réussie"]);
            } else {
                return json_encode(["message" => "Erreur lors de l'inscription"]);
            }
        } catch (Exception $e) {
            error_log("Erreur dans la méthode register : " . $e->getMessage());
            return json_encode(["message" => "Une erreur est survenue lors de l'inscription."]);
        }
    }

    // Méthode pour gérer la connexion
    public function login($email, $password) {
        $this->user->email = $email;
        $this->user->password = $password;
    
        $result = $this->user->login();
    
        if (is_array($result)) {  
            return json_encode([
                "message" => "Connexion réussie",
                "user" => [
                    "id" => $result['id'],
                    "username" => $result['username'],
                    "role" => $result['role']
                ]
            ]);
        } else {
            return json_encode(["message" => "Identifiants incorrects"]);
        }
    }
    
    

    // Méthode pour gérer la récupération de tous les utilisateurs (optionnel pour admin)
    public function getAllUsers() {
        try {
            $query = "SELECT id, username, email, role FROM users";
            $stmt = $this->db->prepare($query);
            $stmt->execute();

            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($users);
        } catch (Exception $e) {
            error_log("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
            return json_encode(["message" => "Erreur lors de la récupération des utilisateurs."]);
        }
    }
}
?>
