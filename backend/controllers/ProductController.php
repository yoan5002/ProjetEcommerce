<?php
require_once '../models/Product.php';
require_once '../config/Database.php';

class ProductController {
    private $product;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->product = new Product($db);
    }

    public function addProduct($name, $description, $price, $image) {
        return $this->product->addProduct($name, $description, $price, $image);
    }

    public function deleteProduct($id) {
        return $this->product->deleteProduct($id);
    }

    public function getAllProducts() {
        return $this->product->getAllProducts();
    }
}
?>
