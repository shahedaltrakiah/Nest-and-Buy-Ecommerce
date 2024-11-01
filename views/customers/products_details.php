<?php require 'views/partials/header.php'; ?>

<div class="container mt-5">
    <div class="container mt-5">
        <div class="row justify-content-center mb-5 s_product_inner">

            <!-- Main Product Image and Thumbnails Section -->
            <div class="col-lg-6 col-xl-6 d-flex align-items-start">
                <div class="product-slider d-flex flex-row">

                    <!-- Main Product Image -->
                    <div class="main-image-container">
                        <?php
                        $allImages = explode(',', $product['all_images']);
                        $mainImage = $allImages[0];
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
                                 alt="<?= htmlspecialchars($product['product_name']); ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>



            <!-- Product Details Section -->
            <div class="col-lg-5 col-xl-5 ">
                <div class="s_product_text">
                    <!-- Product Name and Price -->
                    <h2><?= htmlspecialchars(ucwords(str_replace('-', ' ', $product['product_name']))); ?></h2>

                    <h4 class="product-price text-primary mt-3"><sup>JD</sup> <?= htmlspecialchars(number_format($product['price'], 2)); ?></h4>

                    <!-- Product Description -->
                    <p class="lh-lg mt-3"><?= htmlspecialchars($product['description']); ?></p>

                    <!-- Availability Status -->
                    <div class="availability mb-3">
                        <span><strong>Availability:</strong></span>
                        <?php
                        if ($product['stock_quantity'] > 5) {
                            echo "Available";
                        } elseif ($product['stock_quantity'] > 0) {
                            echo "Hurry up, limited quantity!";
                        } else {
                            echo "Out of Stock";
                        }
                        ?>
                    </div>

                    <!-- Quantity Selector and Add to Cart Button -->
                    <div class="d-flex align-items-center mb-5 mt-5">
                        <input type="number" min="1" max="<?= $product['stock_quantity']; ?>" value="1"
                               class="form-control w-25 me-2 text-center" id="quantity" name="quantity">
                        <?php if ($product['stock_quantity'] > 0): ?>
                            <a href="/cart/add/<?= $product['id']; ?>" class="btn btn-secondary">Add to Cart</a>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Out of Stock</button>
                        <?php endif; ?>
                        <a href="/wishlist/add/<?= $product['id']; ?>" class="btn btn-outline-secondary ms-2">
                            <i class="fa-solid fa-heart"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <!-- Reviews Section (Side-by-Side Layout) -->
    <div class="reviews-section my-5 mt-5">
        <h4 class="mb-4 mt-5">Customer Reviews</h4>
        <div class="d-flex justify-content-between my-5">
            <!-- Review Submission Form -->
            <div class="review-form-container col-md-5">
                <?php if ($user): ?>
                    <p>We're happy to see your feedback, <?= htmlspecialchars($user['name']); ?>, on our <?= htmlspecialchars($product['product_name']); ?>.</p>
                <?php endif; ?>

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
                    <button type="submit" class="btn btn-primary">Submit Review</button>

                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger mt-2"><?= htmlspecialchars($errorMessage); ?></div>
                    <?php endif; ?>
                </form>

            </div>

            <!-- Divider Line -->
            <div class="vr mx-3"></div>

            <!-- Display Reviews -->
            <div class="customer-reviews col-md-6">
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review mt-3 p-3 border rounded">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php require 'views/partials/footer.php'; ?>
