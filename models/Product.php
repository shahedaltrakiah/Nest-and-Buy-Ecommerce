<?php

require 'models/Model.php';

class Product extends Model
{
    public function __construct()
    {
        parent::__construct('products');
    }

    // Method to get all products with their category names and first image
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
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get main categories and their products with primary images
    public function getMainCategoriesWithProducts()
    {
        $statement = $this->pdo->prepare("
            SELECT c.id AS category_id, 
                   c.category_name, 
                   c.image_url AS category_image_url,
                   GROUP_CONCAT(p.id) AS product_id,
                   GROUP_CONCAT(p.product_name) AS product_names,
                   GROUP_CONCAT(p.price) AS product_prices,
                   GROUP_CONCAT((SELECT pi.image_url 
                                 FROM productimages pi 
                                 WHERE pi.product_id = p.id 
                                 LIMIT 1)) AS product_images
            FROM categories c
            LEFT JOIN products p ON p.category_id = c.id
            GROUP BY c.id
            ORDER BY c.category_name ASC, COUNT(p.id) DESC
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get products by category ID with first image and category name
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
        $statement->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get products by pagination and filtering with primary image
    public function getProductsByPage($search = '', $min_price = 0, $max_price = 1000, $category_id = null, $currentPage = 1, $itemsPerPage = 10)
    {
        $offset = ($currentPage - 1) * $itemsPerPage;
        $sql = "
            SELECT p.*, 
                   (SELECT pi.image_url 
                    FROM productimages pi 
                    WHERE pi.product_id = p.id 
                    LIMIT 1) AS image_url 
            FROM products p
            WHERE p.price BETWEEN :min_price AND :max_price";

        // Apply search and category filters
        if ($search) {
            $sql .= " AND p.product_name LIKE :search";
        }
        if ($category_id) {
            $sql .= " AND p.category_id = :category_id";
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':min_price', $min_price);
        $stmt->bindValue(':max_price', $max_price);
        $stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        if ($category_id) {
            $stmt->bindValue(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to count total products with filtering
    public function getProductCount($search = '', $min_price = 0, $max_price = 1000, $category_id = null)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE price BETWEEN :min_price AND :max_price";

        // Add search and category filters
        if ($search) {
            $sql .= " AND product_name LIKE :search";
        }
        if ($category_id) {
            $sql .= " AND category_id = :category_id";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':min_price', $min_price);
        $stmt->bindValue(':max_price', $max_price);

        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        if ($category_id) {
            $stmt->bindValue(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Method to get all categories
    public function getCategories()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsByFilter($category_id, $min_price, $max_price)
    {
        $sql = "SELECT * FROM products WHERE price >= :min_price AND price <= :max_price";
        if ($category_id) {
            $sql .= " AND category_id = :category_id";
        }

        $stmt = $this->pdo->prepare($sql); // Updated from $this->db to $this->pdo
        $stmt->bindValue(':min_price', $min_price, PDO::PARAM_INT);
        $stmt->bindValue(':max_price', $max_price, PDO::PARAM_INT);
        if ($category_id) {
            $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Added FETCH_ASSOC for consistent output
    }

    // New method to get a product by ID
    public function getProductById($productId) {
        $statement = $this->pdo->prepare("
            SELECT 
                p.id, 
                p.product_name, 
                p.description, 
                p.price, 
                p.average_rating, 
                p.stock_quantity, 
                p.created_at, 
                p.updated_at, 
                pi.image_url, 
                c.category_name 
            FROM 
                $this->table AS p 
            JOIN 
                productimages AS pi ON p.id = pi.product_id 
            JOIN 
                categories AS c ON p.category_id = c.id  -- Adjust this line if necessary
            WHERE 
                p.id = :productId
        ");
        
        $statement->bindParam(':productId', $productId, \PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetch(\PDO::FETCH_ASSOC); // Return a single product as an associative array
    }
    
    
}