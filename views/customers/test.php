<?php

// Include the necessary files
require_once '../Ecommerce-website/libraries/Controller.php'; // Include the Controller
require_once '../Ecommerce-website/models/Product.php'; // Include the Product model
require_once '../Ecommerce-website/models/Wishlist.php'; // Include the Wishlist model

// Create an instance of the Product model
$productModel = new Product();
$wishlistModel = new Wishlist(); // Create an instance of the Wishlist model

// Fetch products from the database
$products = $productModel->getProducts();

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Test</title>
</head>
<body>
<h1>Product List</h1>

<?php if ($products && count($products) > 0): ?>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <p>Image Source: <?= htmlspecialchars('ecommerce_website/public/' . $product['image_url']) ?></p>
                <img src="<?= htmlspecialchars('/public/' . $product['image_url']) ?>" alt="<?= htmlspecialchars($product['product_name'] ?? 'Product Image') ?>">

                <h2><?= htmlspecialchars($product['product_name'] ?? 'No Name') ?></h2>
                <p>Description: <?= htmlspecialchars($product['description'] ?? 'No Description') ?></p>
                <p>Category: <?= htmlspecialchars($product['category_name'] ?? 'No Category') ?></p>
                <p>Price: $<?= htmlspecialchars($product['price'] ?? 'No Price') ?></p>
                <p>Stock: <?= htmlspecialchars($product['stock_quantity'] ?? 'Out of Stock') ?></p>
                
                <!-- Add to Cart Form -->
                <form action="/customer/cart" method="post">
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity']; ?>">
                    <button type="submit" class="add-to-cart">Add to Cart</button>
                </form>
                
                <!-- Wishlist Form that redirects to profile.php -->
                <form action="/customer/profile/add" method="post"> <!-- Action points to profile.php -->
                    <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                    <button type="submit" class="add-to-wishlist">Add to Wishlist</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No products found.</p>
<?php endif; ?>

</body>
</html>
