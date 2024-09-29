<?php
require_once "Database.php"; 

class AdminOrder extends Database { 
    public function getOrders() {
        // For simplicity, we are joining users and products tables here. 
        // In a real application, consider creating a separate method to get order items.
        $sql = "SELECT o.*, u.name AS customer_name, p.name AS product_name
                FROM orders o
                INNER JOIN users u ON o.user_id = u.id
                INNER JOIN order_items oi ON o.id = oi.order_id
                INNER JOIN products p ON oi.product_id = p.id
                ORDER BY o.id DESC"; 
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            return $orders; 
        } else {
            return []; // Return an empty array if no orders found
        }
    }

    public function getOrder($orderId) {
        $orderId = mysqli_real_escape_string($this->conn, $orderId);

        $sql = "SELECT o.*, u.name AS customer_name, p.name AS product_name
                FROM orders o
                INNER JOIN users u ON o.user_id = u.id
                INNER JOIN order_items oi ON o.id = oi.order_id
                INNER JOIN products p ON oi.product_id = p.id
                WHERE o.id = '$orderId'";

        $result = $this->conn->query($sql); 

        if ($result->num_rows == 1) {
            return $result->fetch_assoc(); 
        } else {
            return null; // Return null if the order is not found
        }
    }

    public function updateOrderStatus($orderId, $newStatus) {
        $orderId = mysqli_real_escape_string($this->conn, $orderId);
        $newStatus = mysqli_real_escape_string($this->conn, $newStatus); 

        $sql = "UPDATE orders SET status = '$newStatus' WHERE id = '$orderId'";

        if ($this->conn->query($sql) === TRUE) {
            return true; 
        } else {
            return false; 
        }
    }

    public function deleteOrder($orderId) {
        $orderId = mysqli_real_escape_string($this->conn, $orderId); 
        
        // You should usually handle order deletion carefully. 
        // Consider archiving orders instead of deleting them for record-keeping.

        $sql = "DELETE FROM orders WHERE id = '$orderId'"; 

        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false; 
        }
    }
}
?>