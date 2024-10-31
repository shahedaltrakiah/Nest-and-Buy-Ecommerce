<?php
require_once 'models/Model.php';    
class Order extends Model 
{
    public function __construct()
    {
        parent::__construct('orders');
    }

    public function create($data) {
        if (isset($data['customer_id'], $data['total_amount'])) {
            $stmt = $this->pdo->prepare("INSERT INTO orders (customer_id, order_date, status, coupon_id, total_amount, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");

            try {
                $stmt->execute([
                    $data['customer_id'], 
                    $data['order_date'], 
                    $data['status'], 
                    $data['coupon_id'], 
                    $data['total_amount'], 
                    $data['created_at'], 
                    $data['updated_at']
                ]);
    
                // Return the last inserted order ID
                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                // Log the error message or output for debugging
                error_log("Database error: " . $e->getMessage());
                throw new Exception("Database error: " . $e->getMessage());
            }
        } else {
            throw new Exception("Missing required fields: customer_id and total_amount");
        }
    }
    


}
