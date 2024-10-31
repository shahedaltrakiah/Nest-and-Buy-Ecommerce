<?php

class Review extends Model {
    public function __construct() {
        parent::__construct('reviews'); // Assuming the table name is 'reviews'
    }

    // Method to add a review
    public function addReview($data) {
        $statement = $this->pdo->prepare("INSERT INTO reviews (product_id, customer_id, rating, comment) VALUES (:product_id, :customer_id, :rating, :comment)");
        return $statement->execute([
            ':product_id' => $data['product_id'],
            ':customer_id' => $data['customer_id'],
            ':rating' => $data['rating'],
            ':comment' => $data['comment']
        ]);
    }



    // Method to get reviews for a specific product
    public function getReviewsByProductId($productId) {
        $statement = $this->pdo->prepare("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY created_at DESC");
        $statement->execute([':product_id' => $productId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
