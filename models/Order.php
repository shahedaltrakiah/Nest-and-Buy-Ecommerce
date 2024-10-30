<?php

require 'models/Model.php';


class Order extends Model {

    public function __construct()
    {
        parent::__construct('orders');

    }

}