<?php require 'views/partials/header.php'; ?>

<div class="container mt-5" >
    <div class="row justify-content-center mb-5 s_product_inner">

        <!-- Main Product Image and Thumbnails Section -->
        <div class="col-lg-6 col-xl-6 d-flex align-items-start">
            <div class="product-slider d-flex flex-row">

                <!-- Main Product Image -->
                <div class="main-image-container position-relative">
                    <?php
                    $allImages = explode(',', $product['all_images']);
                    $mainImage = trim($allImages[0]);
                    ?>
                    <img id="main-image" width="540" height="540" src="/public/<?= htmlspecialchars($mainImage); ?>"
                         class="img-fluid rounded shadow" alt="<?= htmlspecialchars($product['product_name']); ?>">

                    <form action="/customer/profile/add" method="post" class="wishlist-button">
                        <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                        <button type="submit" class="btn action-button">
                            <i class="fa-solid fa-heart" style="font-size: 30px"> </i>
                        </button>
                    </form>
                </div>

                <?php if (isset($errorMessage)): ?>
                    <script>
                        Swal.fire({
                            icon: 'warning',
                            title: 'Login First',
                            text: '<?php echo $errorMessage; ?>',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3B5D50'
                        }).then(() => {

                            window.history.replaceState(null, null, window.location.pathname);
                        });;
                    </script>
                <?php elseif (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Review Submitted!',
                            text: 'Your review has been added successfully.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3B5D50'
                        }).then(() => {
                            // Remove the `success` parameter from the URL
                            window.history.replaceState(null, null, window.location.pathname);
                        });
                    </script>
                <?php endif; ?>

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
        <div class="col-lg-5 col-xl-5">
            <div>

                <h2><?= htmlspecialchars(ucwords(str_replace('-', ' ', $product['product_name']))); ?></h2>
                <?php
                // Calculate Average Rating
                $totalRating = 0;
                $reviewCount = count($reviews);
                if ($reviewCount > 0) {
                    foreach ($reviews as $review) {
                        $totalRating += (int)$review['rating']; // Sum all the ratings
                    }
                    $averageRating = $totalRating / $reviewCount; // Calculate average
                } else {
                    $averageRating = 0; // Default to 0 if no reviews
                }
                ?>

                <!-- Display Average Rating as Stars -->
                <div class="star-rating mt-3 mb-2 ">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fa fa-star fs-5  <?= ($i <= $averageRating) ? 'text-warning' : 'text-muted'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <a href="#reviews-section" class="text-primary" style="cursor: pointer;"><?= count($reviews); ?> reviews</a>
                <h4 class="product-price text-primary mt-3"> JD <?= htmlspecialchars(number_format($product['price'], 2)); ?></h4>
                <p class="lh-lg mt-3"><?= htmlspecialchars($product['description']); ?></p>

                <div class="availability mb-1">
                    <strong>Availability:</strong>
                    <?php
                    if ($product['stock_quantity'] > 5) {
                        echo "<span class='text-success'>Available</span>";
                    } elseif ($product['stock_quantity'] > 0) {
                        echo "<span class='text-warning'>Hurry up, limited quantity!</span>";
                    } else {
                        echo "<span class='text-danger '>Out of Stock</span>";
                    }
                    ?>
                </div>
                <div class="d-flex align-items-center mb-3 mt-3 ">
                    <?php if ($product['stock_quantity'] > 0): ?>
                        <form action="/customer/cart" method="post" class="button-form me-3 d-flex align-items-center gap-2">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">

                            <!-- Quantity Input Field -->
                            <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock_quantity']; ?>"
                                   class="quantity-input form-control mb-2" style="height: 50px; width: 150px; text-align: center; margin-top: -10px;" required>

                            <!-- Add to Cart Button -->
                            <button type="submit" class="btn btn-primary action-button" style="height: 50px; width: 200px;">
                                <i class="fa-solid fa-cart-plus" style="margin-right: 5px;"></i> ADD TO CART
                            </button>
                        </form>
                    <?php else: ?>

                        <button class="btn btn-secondary action-button" style="height: 50px; width: 200px;"  disabled>Out of Stock</button>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>

    <!-- Reviews Section -->
    <div class="reviews-section my-5 d-flex flex-column">
        <div class="col-md-6">
            <h4 class="mt-4" style="font-weight: bold; color: #3B5D50;">Write a Review</h4>
        </div>

        <div class="my-5 mt-3" style="width: 100%;">

            <!-- Review Submission Form -->

            <form method="POST" action="" enctype="multipart/form-data">
                <!-- Rating and Upload Image side by side -->
                <div class="d-flex justify-content-between mb-3">
                    <!-- Rating Section -->
                    <div class="me-2" style="flex: 1;">
                        <label for="rating" class="form-label">Rating</label>
                        <div class="star-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa fa-star" data-value="<?= $i; ?>" onclick="setRating(<?= $i; ?>)" id="star-<?= $i; ?>"></i>
                            <?php endfor; ?>
                            <input type="hidden" name="rating" id="rating" required>
                        </div>
                    </div>

                    <!-- Upload Image Section -->
                    <div class="ms-2" style="flex: 1;">
                        <label for="image" class="form-label">Upload Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>
                </div>

                <!-- Comment Section -->
                <div class="mb-3">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Submit Button aligned to bottom right -->
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary action-button mt-3" style="height: 50px; width: 200px;">Submit Review</button>
                </div>
            </form>

            <!-- Divider Line -->
            <hr class="mb-3" style="width: 75%; border: none; border-top: dotted #3B5D50; margin: 0 auto;">

            <!-- Display Reviews Section -->
            <div class="customer-reviews w-100" id="reviews-section">
                <div class="col-md-6 mb-5">
                    <h4 class="mt-4" style="font-weight: bold; color: #3B5D50;">Customers Review</h4>
                </div>

                <div class="reviews-filter mb-3">
                    <form method="GET" action="">
                        <div class="d-flex justify-content-between align-items-center">
                            <select name="filter" class="form-select me-2 mb-1">
                                <option value="all" <?= empty($_GET['filter']) || $_GET['filter'] === 'all' ? 'selected' : ''; ?>>All Reviews</option>
                                <option value="my" <?= isset($_GET['filter']) && $_GET['filter'] === 'my' ? 'selected' : ''; ?>>My Reviews</option>
                            </select>
                            <select name="sort" class="form-select me-2 mb-1">
                                <option value="asc" <?= !isset($_GET['sort']) || $_GET['sort'] === 'asc' ? 'selected' : ''; ?>>Ascending</option>
                                <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : ''; ?>>Descending</option>
                            </select>
                            <select name="image_filter" class="form-select me-2 mb-1">
                                <option value="all" <?= empty($_GET['image_filter']) || $_GET['image_filter'] === 'all' ? 'selected' : ''; ?>>Show All Reviews</option>
                                <option value="with_images" <?= isset($_GET['image_filter']) && $_GET['image_filter'] === 'with_images' ? 'selected' : ''; ?>>Show Reviews with Images</option>
                                <option value="without_images" <?= isset($_GET['image_filter']) && $_GET['image_filter'] === 'without_images' ? 'selected' : ''; ?>>Show Reviews without Images</option>
                            </select>
                            <button type="submit" class="btn btn-primary action-button me-2 mb-1 p-3" style='font-size:14px '>Filter</button>
                        </div>
                    </form>
                </div>

                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <?php if ($review['status'] === 'accepted'): // Display only accepted reviews ?>
                            <div class="review mt-1 p-3 border rounded bg-light d-flex position-relative">
                                <!-- Delete Button -->
                                <?php if (isset($user) && $user['id'] === $review['customer_id']): ?>
                                    <div class="delete-button position-absolute top-0 end-0 me-2 mt-2">
                                        <button class="delete-review btn-danger btn-sm" data-id="<?= $review['id'] ?>">X</button>
                                    </div>
                                <?php endif; ?>

                                <!-- Review Content -->
                                <div class="review-info me-3" style="flex: 1;">
                                    <p><strong>Rating:</strong>
                                        <?php
                                        $rating = (int)$review['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $rating ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-warning"></i>';
                                        }
                                        ?>
                                    </p>
                                    <p><strong>Reviewer:</strong> <?= htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?></p>
                                    <p><strong>Comment:</strong> <?= htmlspecialchars($review['comment']); ?></p>
                                    <p><em>Reviewed on <?= htmlspecialchars(date("F j, Y", strtotime($review['created_at']))); ?></em></p>
                                </div>

                                <!-- Review Image Centered -->
                                <div class="review-image d-flex justify-content-center align-items-center">
                                    <?php if (!empty($review['image_url'])): ?>
                                        <img src="/<?= htmlspecialchars($review['image_url']) ?>" alt="Review Image" class="review-image" onclick="zoomImage(this)" style="height: 120px; width: 120px;">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; // End of accepted review check ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">No reviews yet. Be the first to leave a review!</p>
                <?php endif; ?>


            </div>

        </div>
    </div>
    </div>
</div>
<?php require 'views/partials/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.querySelectorAll('.delete-review').forEach(button => {
            button.addEventListener('click', function() {
                const reviewId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a form to submit the deletion
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '';
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'delete_review_id';
                        hiddenInput.value = reviewId;
                        form.appendChild(hiddenInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
        function changeMainImage(src) {
            document.getElementById("main-image").src = src;
        }

        // JavaScript to handle star rating selection
        function setRating(rating) {
            // Set the hidden input value to the selected rating
            document.getElementById("rating").value = rating;

            // Update star appearance based on selected rating
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById("star-" + i);
                if (i <= rating) {
                    star.classList.add("selected");
                } else {
                    star.classList.remove("selected");
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function zoomImage(img) {
            // Create a modal to display the image
            const modal = document.createElement('div');
            modal.style.position = 'fixed';
            modal.style.zIndex = '1000';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';

            const imgClone = document.createElement('img');
            imgClone.src = img.src;
            imgClone.style.maxWidth = '90%';
            imgClone.style.maxHeight = '90%';

            modal.appendChild(imgClone);
            document.body.appendChild(modal);

            // Close modal on click
            modal.onclick = function() {
                document.body.removeChild(modal);
            };
        }
    </script>
    <style>
        .review {
            position: relative; /* Ensure the review box is a positioning context */
        }

        .delete-button {
            position: absolute;
            top: 10px; /* Adjust this value for vertical positioning */
            right: 10px; /* Adjust this value for horizontal positioning */
            z-index: 10; /* Ensure it is above other content */
        }

        .delete-review {
            background: none; /* Remove background for a cleaner look */
            border: none; /* Remove border for a cleaner look */
            color: red; /* Set the text color for the delete button */
            cursor: pointer; /* Change cursor to pointer for better UX */
        }

        /* Star Rating Styles */
        .star-rating {
            display: flex;
            gap: 5px;
        }

        .star-rating .fa-star {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating .fa-star.selected {
            color: #ffcc00;
        }
        /* Wishlist Button */
        .wishlist-button {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .wishlist-button .action-button {
            background-color: transparent; /* Remove the background */
            color: #6ca197; /* Set the color to match your desired color */
            border: none; /* Remove any border */
            padding: 0; /* Remove padding to keep it compact */
            cursor: pointer; /* Ensure it looks clickable */
        }

        .wishlist-button .action-button:hover {
            color: #3B5D50; /* Optional: Change color on hover for better UX */
        }

        /* Product Image Styles */
        .quantity-input {
            width: 60px;
            height: 40px;
            padding: 0;
            border: 1px solid #ced4da;
            border-radius: 5px;
            text-align: center;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-button {
            width: 60px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1rem;
            border-radius: 5px;
            background-color: #4c6a63;
            color: white;
            border: none;
        }

        .button-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

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
            width: 8px;
        }

        .customer-reviews::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .customer-reviews::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
