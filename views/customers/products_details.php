<?php require 'views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row s_product_inner justify-content-center mb-5">
        <!-- Product Images Section -->
        <div class="col-lg-7 col-xl-7">
            <div class="product_slider_img">
                <div id="vertical">
                    <!-- Main Product Image -->
                    <div>
                        <?php
                        // The main product image URL (base image)
                        $baseImageUrl = htmlspecialchars($product['image_url'] ?? '../images/default-product.png');
                        ?>
                        <img id="main-image" width="461px" height="461px"
                             src="http://localhost/Ecommerce_website.github.io-/<?= $baseImageUrl; ?>"
                             class="img-fluid" alt="<?= htmlspecialchars($product['product_name']); ?>">
                    </div>

                    <!-- Sub-images (Thumbnails) -->
                    <div class="sub-images mt-3">
                        <?php
                        // Extract base name and extension for image processing
                        $baseName = pathinfo($baseImageUrl, PATHINFO_FILENAME);
                        $extension = pathinfo($baseImageUrl, PATHINFO_EXTENSION);

                        // Loop through sub-images (from 1 to 9)
                        for ($i = 1; $i <= 9; $i++) {
                            // Generate sub-image URL
                            $subImageUrl = "http://localhost/Ecommerce_website.github.io-/images/{$baseName}{$i}.{$extension}";

                            // Check if the file exists locally
                            $localImagePath = "../images/{$baseName}{$i}.{$extension}";

                            // If the file doesn't exist, stop the loop
                            if (!file_exists($localImagePath)) {
                                break;
                            }

                            // Display the sub-image with a class for JavaScript handling
                            echo '<img class="sub-image img-thumbnail ms-1" width="60px" height="60px" src="' . $subImageUrl . '" alt="' . htmlspecialchars($product['product_name']) . '">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-lg-5 col-xl-4">
            <div class="s_product_text ">
                <?php
                // Function to format the product name
                function formatProductName($name)
                {
                    // Replace dashes with spaces and capitalize each word
                    return ucwords(str_replace('-', ' ', $name));
                }
                ?>

                <h3><?= htmlspecialchars(formatProductName($product['product_name'])); ?></h3>
                <h2>$<?= htmlspecialchars($product['price']); ?></h2>

                <p><?= htmlspecialchars($product['description']); ?></p>
                <ul class="list list-unstyled">
                    <li>
                        <a class="active" href="#"><span>Category</span> : Household</a>
                    </li>
                    <li>
                        <a href="#">
                            <span>Availability</span> :
                            <?php
                            // Check stock quantity for availability
                            if (is_null($product['stock_quantity'])) {
                                echo "Sold Out";
                            } elseif ($product['stock_quantity'] <= 5) {
                                echo "Don't miss out, stock running low!";
                            } else {
                                echo "In Stock";
                            }
                            ?>
                        </a>
                    </li>
                </ul>
                <div class="card_area d-flex justify-content-between align-items-center">
                    <div class="product_count">
                        <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                        <input class="input-number" type="text" value="1" min="0" max="10">
                        <span class="number-increment"> <i class="ti-plus"></i></span>
                    </div>
                    <a href="#" class="btn btn-secondary me-1">Add to Cart</a>
                    <a href="#" class="like_us btn-secondary"> <i class="ti-heart"></i> </a>
                </div>
            </div>

        </div>
        <div class="container mt-5">
            <!-- Review Form -->
            <h4>Add Your Review</h4>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control w-50" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control w-50" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" class="form-control w-50" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" class="form-control w-50" required>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea name="comment" id="comment" class="form-control w-50" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>

            </form>
        </div>

        <!-- Display Reviews -->
        <h4 class="mt-5">Reviews</h4>
        <?php if (count($reviews) > 0): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong>Rating:</strong> <?= htmlspecialchars($review['rating']); ?> Stars</p>
                    <p><strong>Comment:</strong> <?= htmlspecialchars($review['comment']); ?></p>
                    <p><em>Reviewed on <?= htmlspecialchars($review['created_at']); ?></em></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to leave a review!</p>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript for Image Swap -->
<script>
    // Select all sub-images
    const subImages = document.querySelectorAll('.sub-image');

    // Select the main image
    const mainImage = document.getElementById('main-image');

    // Loop through each sub-image and add a click event listener
    subImages.forEach(function (subImage) {
        subImage.addEventListener('click', function () {
            // Set the src of the main image to the clicked sub-image src
            mainImage.src = subImage.src;
        });
    });
</script>


