<?php require "views/partials/header.php"; ?>

<!-- Start Hero Section -->
<div class="hero" style="height: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="intro-excerptt">
                    <h1 style="margin-bottom: 20px; margin-top: -30px;">Shop</h1>
                    <p style="font-size: 15px;">Discover Your Perfect Style: Handpicked Furniture for Every Space.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Filter Form -->
<div class="filter-container">
    <div class="container mt-4">
        <form method="GET" class="row g-3" id="filterForm">
            <!-- Search Filter -->
            <div class="col-md-3">
                <label for="search" class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text" id="search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Search products..." class="form-control">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-md-3">
                <label for="category_id" class="form-label">Category</label>
                <select class="form-select" id="category_id" name="category_id">
                    <option value="">All Categories</option>
                    <?php
                    $categories = $this->model ('Product')->getCategories();
                    foreach ($categories as $category) {
                        $selected = ($category_id ?? '') == $category['id'] ? 'selected' : '';
                        echo "<option value=\"" . htmlspecialchars($category['id']) . "\" $selected>" . htmlspecialchars($category['category_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Price Range Slider -->
            <div class="col-md-3">
                <label for="price_range" class="form-label">Price Range</label>
                <div class="price-slider">
                    <input type="range" id="min_price" name="min_price" min="0" max="1000" value="<?= htmlspecialchars($min_price ?? 0); ?>" oninput="updateMinPrice(this.value)">
                    <input type="range" id="max_price" name="max_price" min="0" max="1000" value="<?= htmlspecialchars($max_price ?? 1000); ?>" oninput="updateMaxPrice(this.value)">
                    <div>
                        <span id="minPriceLabel">$<?= htmlspecialchars($min_price ?? 0); ?></span> - <span id="maxPriceLabel">$<?= htmlspecialchars($max_price ?? 1000); ?></span>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Start Displaying Filtered Products -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div id="results">
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-12 col-md-4 col-lg-3 mb-5">
                            <a class="product-item" href="/customers/product_details/<?php echo $product['id']; ?>">
                                <img src="/public/<?php echo $product['image_url']; ?>" class="img-fluid product-thumbnail" width="261" height="261" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <h3 class="product-title">
                                    <b><?php echo ucwords(str_replace(['-', '_'], ' ', $product['product_name'])); ?></b>
                                </h3>
                                <strong class="product-price"><sup> JD </sup><?php echo htmlspecialchars($product['price']); ?></strong>
                                <span class="icon-cross">
                                <img src="../public/images/cross.svg" class="img-fluid">
                            </span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No products found matching your criteria.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="row">
    <div class="col-12 text-center">
        <div class="text-center mt-4">
            <?php if (isset($totalPages) && $totalPages > 0): ?>
                <?php if ($currentPage > 1): ?>
                    <a class="btn btn-secondary mx-1" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>&category_id=<?php echo $category_id; ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>">&laquo; Previous</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&min_price=<?= $min_price; ?>&max_price=<?= $max_price; ?>&category_id=<?= $category_id; ?>" class="btn <?= $i == $currentPage ? 'btn-secondary' : 'btn-primary'; ?> mx-1"><?= $i; ?></a>
                <?php endfor; ?>
                <?php if ($currentPage < $totalPages): ?>
                    <a class="btn btn-secondary mx-1" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>&category_id=<?php echo $category_id; ?>&min_price=<?php echo $min_price; ?>&max_price=<?php echo $max_price; ?>">Next &raquo;</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function updateMinPrice(value) {
        document.getElementById('minPriceLabel').textContent = '$' + value;
    }

    function updateMaxPrice(value) {
        document.getElementById('maxPriceLabel').textContent = '$' + value;
    }
</script>

<?php require "views/partials/footer.php"; ?>
