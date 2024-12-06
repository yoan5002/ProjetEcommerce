<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once '../models/Product.php';
require_once '../config/Database.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $uploadDir = '../uploads/';
    $fileName = basename($_FILES['image']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];

        echo $product->addProduct($name, $description, $price, $fileName);
    } else {
        echo json_encode(["message" => "Erreur lors du téléversement de l'image."]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['existingImage']; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            $image = $fileName; 
        }
    }

    echo $product->updateProduct($id, $name, $description, $price, $image);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && $action === 'delete') {
    parse_str(file_get_contents("php://input"), $data);
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    error_log("ID reçu pour suppression : " . $id);
    if ($id) {
        $productDetails = $product->getProductById($id);
        $imagePath = '../uploads/' . $productDetails['image'];

        if (file_exists($imagePath)) {
            unlink($imagePath); 
        }

        echo $product->deleteProduct($id);
    } else {
        echo json_encode(["message" => "ID manquant."]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'getAll') {
    echo json_encode($product->getAllProducts());
}
?>
