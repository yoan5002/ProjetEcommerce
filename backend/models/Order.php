<?php
class Order {
    private $conn;
    private $table_orders = "orders";
    private $table_order_items = "order_items";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getOrdersByUser($userId) {
        $query = "SELECT o.id, o.date, oi.product_id, oi.quantity, oi.price
                  FROM " . $this->table_orders . " o
                  JOIN " . $this->table_order_items . " oi ON o.id = oi.order_id
                  WHERE o.user_id = :user_id
                  ORDER BY o.date DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
