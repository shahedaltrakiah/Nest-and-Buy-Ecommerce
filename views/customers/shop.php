<?php require "views/partials/header.php"; ?>

<!-- Start Hero Section -->
<div class="hero" style="height: 60px;">
    <div class="container">
        <div class="row ">
            <div class="col-lg-12">
                <div class="intro-excerptt">
                    <h1 style="margin-bottom: 20px; margin-top: -30px;"> Shop </h1>
                    <p style="font-size: 15px;">Discover Your Perfect Style: Handpicked Furniture for Every Space.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Filter Form -->


<!-- Start Displaying Filtered Products -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php foreach ($products as $product) : ?>
                <div class="col-12 col-md-4 col-lg-3 mb-5">
                    <a class="product-item" href="/customers/product_details/<?php echo $product['id'];?>">
                        <img  width="261px" height="261px" src="/public/<?php echo $product ['image_url']; ?>" class="img-fluid product-thumbnail" alt="<?php echo $product['product_name']; ?>">
                        <h3 class="product-title">
                            <b> <?php echo ucwords(str_replace(['-', '_'], ' ', $product['product_name'])); ?> </b>
                        </h3>
                        <strong class="product-price">
                            <sup> JD </sup><?php echo $product ['price']; ?>
                        </strong>
                        <span class="icon-cross">
                            <img src="../public/images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php require "views/partials/footer.php"; ?>
