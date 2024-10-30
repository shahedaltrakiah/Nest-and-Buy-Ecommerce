<?php
require_once 'models/Model.php';    
class Order extends Model 
{
    public function __construct()
    {
        parent::__construct('orders');
    }

    public function create($data)
    {
        // Ensure required fields are present
        if (isset($data['customer_id'], $data['total_amount'])) {
            // You can also set default values for optional fields
            $data['order_date'] = date('Y-m-d H:i:s'); // Current date and time
            $data['status'] = 'pending'; // Default status
            $data['coupon_id'] = $data['coupon_id'] ?? null; // Optional coupon_id
            $data['created_at'] = date('Y-m-d H:i:s'); // Set created_at timestamp
            $data['updated_at'] = date('Y-m-d H:i:s'); // Set updated_at timestamp

            // Call the parent create method
            parent::create($data);
        } else {
            throw new Exception("Missing required fields: customer_id and total_amount");
        }
    }
}
