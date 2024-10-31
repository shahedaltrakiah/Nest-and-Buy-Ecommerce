<?php require 'views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center mb-5 s_product_inner">

        <!-- Main Product Image and Thumbnails Section -->
        <div class="col-lg-6 col-xl-6 d-flex align-items-start">
            <div class="product-slider d-flex flex-row">

                <!-- Main Product Image -->
                <div class="main-image-container">
                    <?php
                    $allImages = explode(',', $product['all_images']);
                    $mainImage = trim($allImages[0]);
                    ?>
                    <img id="main-image" width="540" height="540" src="/public/<?= htmlspecialchars($mainImage); ?>"
                         class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['product_name']); ?>">
                </div>

                <!-- Thumbnails Section to the Right of Main Image with Scroll -->
                <div class="sub-images d-flex flex-column ms-3" style="max-height: 400px; overflow-y: auto;">
                    <?php foreach ($allImages as $image):
                        $image = trim($image); ?>
                        <img onclick="changeMainImage(this.src)" class="sub-image img-thumbnail mb-2"
                             width="150" height="150" src="/public/<?= htmlspecialchars($image); ?>"
                             alt="<?= htmlspecialchars($product['product_name']); ?>" style="cursor: pointer;">
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-lg-5 col-xl-5">
            <div class="s_product_text">
                <!-- Product Name and Price -->
                <h2><?= htmlspecialchars(ucwords(str_replace('-', ' ', $product['product_name']))); ?></h2>
                <h4 class="product-price text-primary mt-3"><sup>JD</sup> <?= htmlspecialchars(number_format($product['price'], 2)); ?></h4>

                <!-- Product Description -->
                <p class="lh-lg mt-3"><?= htmlspecialchars($product['description']); ?></p>

                <!-- Availability Status -->
                <div class="availability mb-3">
                    <strong>Availability:</strong>
                    <?php
                    if ($product['stock_quantity'] > 5) {
                        echo "<span class='text-success'>Available</span>";
                    } elseif ($product['stock_quantity'] > 0) {
                        echo "<span class='text-warning'>Hurry up, limited quantity!</span>";
                    } else {
                        echo "<span class='text-danger'>Out of Stock</span>";
                    }
                    ?>
                </div>

                <!-- Quantity Selector and Add to Cart Button -->
                <div class="d-flex align-items-center mb-5 mt-5">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <form action="/customer/cart" method="post" class="me-3 d-flex align-items-center">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity']; ?>" class="form-control quantity-input me-2" required>
                            <button type="submit" class="btn btn-primary add-to-cart">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="btn btn-secondary me-3" disabled>Out of Stock</button>
                    <?php endif; ?>

                    <form action="/customer/profile/add" method="post" class="ms-2">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="reviews-section my-5">
        <h4 class="mb-4">Customer Reviews</h4>
        <div class="d-flex justify-content-between my-5">
            <!-- Review Submission Form -->
            <div class="review-form-container col-md-5">
                <h5>Write a Review</h5>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select" required>
                            <option value="">Choose Rating</option>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?= $i; ?>"><?= $i; ?> Star<?= $i > 1 ? 's' : ''; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>

            <!-- Divider Line -->
            <div class="vr mx-3"></div>

            <!-- Display Reviews -->
            <div class="customer-reviews col-md-6">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review mt-3 p-3 border rounded bg-light">
                            <p><strong>Rating:</strong> <?= htmlspecialchars($review['rating']); ?> Stars</p>
                            <p><strong>Comment:</strong> <?= htmlspecialchars($review['comment']); ?></p>
                            <p><em>Reviewed on <?= htmlspecialchars(date("F j, Y", strtotime($review['created_at']))); ?></em></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript function to change the main image on thumbnail click
    function changeMainImage(src) {
        document.getElementById("main-image").src = src;
    }
</script>

<?php require 'views/partials/footer.php'; ?>

<style>
    /* Product Image Styles */
    .product-slider {
        display: flex;
        flex-direction: column;
    }

    .main-image-container {
        border: 3px solid #3B5D50; /* Thicker border using main color */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .main-image-container img {
        width: 100%; /* Responsive image */
        height: auto; /* Maintain aspect ratio */
        transition: transform 0.3s, filter 0.3s;
    }

    .main-image-container img:hover {
        transform: scale(1.05); /* Slightly enlarge on hover */
        filter: brightness(90%); /* Darken on hover for effect */
    }

    .sub-images {
        display: flex;
        flex-direction: column; /* Stack thumbnails vertically */
        max-height: 400px; /* Fixed height for scrolling */
        overflow-y: auto; /* Allow vertical scrolling */
        padding-right: 10px; /* Space for scrollbar */
    }

    .sub-images img {
        cursor: pointer;
        border: 2px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
        transition: transform 0.2s, border-color 0.2s;
    }

    .sub-images img:hover {
        transform: scale(1.05); /* Slightly enlarge on hover */
        border-color: #3B5D50; /* Highlight border */
    }

    /* Product Details Styles */
    .s_product_text {
        padding: 15px;
        background-color: #fff; /* White background for details */
        border-radius: 10px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .product-price {
        font-size: 1.5rem; /* Larger font size for price */
    }

    .add-to-cart {
        background-color: #3B5D50; /* Consistent button color */
        border: none;
    }

    /* Review Styles */
    .reviews-section {
        background-color: #f8f9fa; /* Light grey background for reviews */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .review-form-container {
        background-color: #fff; /* White background for form */
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .review {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 15px;
        transition: background-color 0.3s;
    }

    .review:hover {
        background-color: #f1f1f1; /* Highlight on hover */
    }
</style>
