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
                <div class="sub-images d-flex flex-column ms-3 customer-reviews" style="max-height: 400px; overflow-y: auto;">
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
            <div>
                <h2><?= htmlspecialchars(ucwords(str_replace('-', ' ', $product['product_name']))); ?></h2>
                <h4 class="product-price text-primary mt-3"><sup>JD</sup> <?= htmlspecialchars(number_format($product['price'], 2)); ?></h4>
                <p class="lh-lg mt-3"><?= htmlspecialchars($product['description']); ?></p>

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

    <!-- Reviews Section (Side-by-Side Layout) -->
    <div class="reviews-section my-5 d-flex flex-column">
        <h4 class="mb-4">Customer Reviews</h4>
        <div class="d-flex justify-content-between my-5" style="width: 100%;">

            <!-- Review Submission Form -->
            <div class="review-form-container col-md-5">
                <?php if ($user): ?>
                    <p>We're happy to see your feedback, <?= htmlspecialchars($user['name']); ?>, on our <?= htmlspecialchars($product['product_name']); ?>.</p>
                <?php endif; ?>

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
                </form>
            </div>

            <!-- Divider Line -->
            <div class="vr mx-3"></div>

            <!-- Display Reviews with Scrolling -->
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
    function changeMainImage(src) {
        document.getElementById("main-image").src = src;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require 'views/partials/footer.php'; ?>

<style>
    /* Product Image Styles */
    .product-slider {
        display: flex;
        flex-direction: column;
    }

    .main-image-container {
        border: 3px solid #3B5D50;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    .sub-images {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .s_product_text {
        padding: 15px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .reviews-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .review-form-container, .customer-reviews {
        height: 100%;
        max-height: 400px;
    }

    .customer-reviews {
        overflow-y: auto;
    }

    .customer-reviews::-webkit-scrollbar {
        display: none;
    }

    .customer-reviews {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
