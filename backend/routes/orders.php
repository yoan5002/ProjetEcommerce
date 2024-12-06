<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../config/Database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
        
        $userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

        if ($userId > 0) {
            $query = "
                SELECT o.id AS order_id, o.total_price, o.order_date, 
                       p.name AS product_name, oi.quantity, oi.price 
                FROM orders o
                JOIN order_items oi ON o.id = oi.order_id
                JOIN products p ON oi.product_id = p.id
                WHERE o.user_id = :user_id
                ORDER BY o.order_date DESC";

            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($orders) {
                // Regrouper les commandes par ID
                $groupedOrders = [];
                foreach ($orders as $order) {
                    $orderId = $order['order_id'];
                    if (!isset($groupedOrders[$orderId])) {
                        $groupedOrders[$orderId] = [
                            'order_id' => $orderId,
                            'total_price' => $order['total_price'],
                            'order_date' => $order['order_date'],
                            'items' => []
                        ];
                    }
                    $groupedOrders[$orderId]['items'][] = [
                        'product_name' => $order['product_name'],
                        'quantity' => $order['quantity'],
                        'price' => $order['price']
                    ];
                }

                echo json_encode(array_values($groupedOrders)); 
            } else {
                echo json_encode(["message" => "Aucune commande trouvée."]);
            }
        } else {
            echo json_encode(["message" => "Utilisateur non trouvé ou non spécifié."]);
        }
    } else {
        echo json_encode(["message" => "Méthode non autorisée."]);
    }
} catch (Exception $e) {
    error_log("Erreur : " . $e->getMessage());
    echo json_encode(["message" => "Erreur serveur."]);
}
?>
