<?php

require 'models/Model.php';

class Product extends Model {
    public function __construct()
    {

        parent::__construct('products');
    }

    public function getProducts()
    {
        $statement = $this->pdo->prepare("
        SELECT p.*, 
               (SELECT pi.image_url 
                FROM productimages pi 
                WHERE pi.product_id = p.id 
                LIMIT 1) AS image_url, 
               c.category_name 
        FROM $this->table p 
        JOIN categories c ON p.category_id = c.id
    ");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMainCategoriesWithProducts()
    {
        $statement = $this->pdo->prepare("
        SELECT c.id AS category_id, 
               c.category_name, 
               c.image_url AS category_image_url,
               (p.id) AS product_id,
               p.product_name,p.price,
               (SELECT pi.image_url 
                             FROM ProductImages pi 
                             WHERE pi.product_id = p.id 
                             LIMIT 1) AS product_images
        FROM Categories c
        LEFT JOIN Products p ON p.category_id = c.id
        GROUP BY c.id
        ORDER BY c.category_name ASC 
    ");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getProductCategory($categoryId)
    {
        $statement = $this->pdo->prepare("
        SELECT 
            c.category_name,
            p.*,
            (SELECT pi.image_url 
             FROM productimages pi 
             WHERE pi.product_id = p.id 
             LIMIT 1) AS image_url
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE c.id = :category_id
    ");
        // Bind the category ID parameter to the query
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        // Fetch all product data along with category details
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

  
    // rania function fro product_details/New: Fetch a single product with all its images
     public function getProductById($productId)
     {
         $statement = $this->pdo->prepare("
             SELECT p.*, c.category_name, 
                    (SELECT GROUP_CONCAT(image_url) 
                     FROM productimages 
                     WHERE product_id = p.id) AS all_images
             FROM products p
             JOIN categories c ON p.category_id = c.id
             WHERE p.id = :product_id
         ");
         $statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
         $statement->execute();
         return $statement->fetch(\PDO::FETCH_ASSOC);
     }
 
     //rania function fro product_details/  New: Add review to a product
     public function addReview($productId, $fullName, $email, $phone, $rating, $comment)
     {
         $statement = $this->pdo->prepare("
             INSERT INTO reviews (product_id, full_name, email, phone, rating, comment, created_at) 
             VALUES (:product_id, :full_name, :email, :phone, :rating, :comment, NOW())
         ");
         $statement->bindParam(':product_id', $productId, PDO::PARAM_INT);
         $statement->bindParam(':full_name', $fullName, PDO::PARAM_STR);
         $statement->bindParam(':email', $email, PDO::PARAM_STR);
         $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
         $statement->bindParam(':rating', $rating, PDO::PARAM_INT);
         $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
         return $statement->execute();
     }
}
