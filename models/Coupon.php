<?php

require 'models/Model.php';

class Coupon extends Model {

    public function __construct()
    {
        parent::__construct('coupons');

    }

}