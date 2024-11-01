<?php

class Review extends Model {
    public function __construct() {
        parent::__construct('reviews');
    }

    // Method to add a new review
    public function addReview($data) {
        $statement = $this->pdo->prepare(
            "INSERT INTO reviews (product_id, customer_id, rating, comment, created_at) 
             VALUES (:product_id, :customer_id, :rating, :comment, NOW())"
        );
        return $statement->execute([
            ':product_id' => $data['product_id'],
            ':customer_id' => $data['customer_id'],
            ':rating' => $data['rating'],
            ':comment' => $data['comment']
        ]);
    }

    // Method to get reviews for a specific product
    public function getReviewsByProductId($productId) {
        $statement = $this->pdo->prepare(
            "SELECT * FROM reviews WHERE product_id = :product_id ORDER BY created_at DESC"
        );
        $statement->execute([':product_id' => $productId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
