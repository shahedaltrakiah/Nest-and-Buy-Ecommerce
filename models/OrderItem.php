<?php

require_once 'models/Model.php';    

class OrderItem extends Model 
{
    public function __construct()
    {
        parent::__construct('orderitems'); // Assuming the table name is 'order_items'
    }

    public function create($data)
    {
        parent::create($data);
    }
}
