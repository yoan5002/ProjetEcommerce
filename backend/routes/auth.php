<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/Database.php';
require_once '../controllers/UserController.php';

$controller = new UserController();

try {
    $data = file_get_contents("php://input");
    $data = json_decode($data);

    $action = isset($_GET['action']) ? trim($_GET['action']) : '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($action === 'register') {
            if (!empty($data->username) && !empty($data->email) && !empty($data->password)) {
                $role = ($data->email === 'yoanlable@gmail.com') ? 'admin' : 'user';
                $result = $controller->register($data->username, $data->email, $data->password, $role);
                echo $result;
            } else {
                echo json_encode(["message" => "Données incomplètes pour l'inscription"]);
            }
        } elseif ($action === 'login') {
            if (!empty($data->email) && !empty($data->password)) {
                $result = $controller->login($data->email, $data->password);
                echo $result;
            } else {
                echo json_encode(["message" => "Données incomplètes pour la connexion"]);
            }
        } else {
            echo json_encode(["message" => "Action non reconnue"]);
        }
    } else {
        echo json_encode(["message" => "Méthode de requête non prise en charge"]);
    }
} catch (Exception $e) {
    error_log("Erreur serveur : " . $e->getMessage());
    echo json_encode(["message" => "Erreur serveur", "error" => $e->getMessage()]);
}
?>
