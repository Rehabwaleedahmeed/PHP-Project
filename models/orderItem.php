<?php
require_once __DIR__ . '/../config/dp.php';
class OrderItem extends Service {
    public function getAllOrderItems(){
        return $this->connection->query("SELECT * FROM order_items");
    }

    public function insertOrderItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->connection->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)"
        );
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    }

    public function getOrderItemById($id) {
        $stmt = $this->connection->prepare("SELECT * FROM order_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOrderItem($id, $orderId, $productId, $quantity, $price) {
        $stmt = $this->connection->prepare(
            "UPDATE order_items
    SET order_id=?, product_id=?, quantity=?, price=? WHERE id=?"
        );
        return $stmt->execute([$orderId, $productId, $quantity, $price, $id]);
    }   

    public function deleteOrderItem($id) {
        $stmt = $this->connection->prepare("DELETE FROM order_items WHERE id = ?");
        return $stmt->execute([$id]);
    }
}