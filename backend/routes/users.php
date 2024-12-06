<?php

header("Access-Control-Allow-Origin: http://localhost:3000"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 
header("Access-Control-Allow-Credentials: true"); 



require_once '../config/Database.php';



$database = new Database();
$conn = $database->getConnection();

try {
    // Récupérer les utilisateurs
    $query = "SELECT id, username, email, role FROM users";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $exception) {
    echo json_encode(['error' => 'Erreur : ' . $exception->getMessage()]);
}
?>
