<?php
class Coupon extends Model {
    public function __construct()
    {
        parent::__construct('coupons');
    }

    public function getCouponByCode($code)
    {
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE code = :code");
        $statement->execute(['code' => $code]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}
