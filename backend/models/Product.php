<?php
class Product {
    private $conn;
    private $table = 'products';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addProduct($name, $description, $price, $image) {
        $query = "INSERT INTO " . $this->table . " (name, description, price, image) 
                  VALUES (:name, :description, :price, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":image", $image);

        if ($stmt->execute()) {
            return json_encode(["message" => "Produit ajouté avec succès."]);
        } else {
            return json_encode([
                "message" => "Erreur lors de l'ajout du produit.",
                "error" => $stmt->errorInfo()
            ]);
        }
    }

    public function updateProduct($id, $name, $description, $price, $image) {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, description = :description, price = :price, image = :image 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":image", $image);

        if ($stmt->execute()) {
            return json_encode(["message" => "Produit modifié avec succès."]);
        } else {
            return json_encode([
                "message" => "Erreur lors de la modification du produit.",
                "error" => $stmt->errorInfo()
            ]);
        }
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
    
        if ($stmt->execute()) {
            return json_encode(["message" => "Produit supprimé avec succès."]);
        } else {
            return json_encode([
                "message" => "Erreur lors de la suppression.",
                "error" => $stmt->errorInfo()
            ]);
        }
    }
    

    public function getProductById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getAllProducts() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>
