<?php
require "views/partials/admin_header.php";

// Fetch search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filtered_coupons = array_filter($coupons, function ($coupon) use ($search_query) {
    return stripos($coupon['code'], $search_query) !== false;
});

// If no search query, show all coupons
if ($search_query === '') {
    $filtered_coupons = $coupons;
}

// Pagination setup
$items_per_page = 20;
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$current_page = max($current_page, 1);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_coupons = array_slice($filtered_coupons, $start_index, $items_per_page);
$total_items = count($filtered_coupons);
$total_pages = ceil($total_items / $items_per_page);
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success">Coupons</h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                            <div class="col-auto">
                                <form class="d-flex align-items-center" method="GET" action="">
                                    <input type="text" id="search-docs" name="search"
                                        value="<?= htmlspecialchars($search_query) ?>"
                                        class="form-control rounded-pill border-primary me-2"
                                        placeholder="Search Products..." aria-label="Search"
                                        style="border: 1px solid #d1e7dd;">
                                    <button type="submit" class="btn btn-success rounded-pill">
                                        <i class="fas fa-search text-white"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Create Button -->
                            <div class="col-auto">
                                <a class="btn btn-success text-white d-flex align-items-center rounded-pill px-3 py-2"
                                   href="#" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                                    <i class="bi bi-plus-circle me-2"></i> Add New Coupons
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create coupon Modal -->
            <div class="modal fade" id="createCouponModal" tabindex="-1" aria-labelledby="createCouponModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="createCouponForm" action="/admin/coupon_create" method="POST" enctype="multipart/form-data">
                            <div class="modal-header p-0">
                                <div class="w-100 bg-success text-white p-2 d-flex justify-content-between align-items-center">
                                    <h5 class="modal-title text-white" id="createCouponModalLabel">Create New Coupon</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Discount</label>
                                    <textarea class="form-control" id="discount" name="discount" rows="2" required></textarea>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="usage_limit" class="form-label">Usage Limit</label>
                                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" step="0.01" required>
                                    </div>
                                    <div class="col">
                                        <label for="expiration_date" class="form-label">Expiration Date</label>
                                        <input type="date" class="form-control" id="expiration_date" name="expiration_date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success text-white">Save Coupon</button>
                                <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-borderless shadow-sm rounded">
                <thead class="table-success">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Usage Limit</th>
                        <th>Expiration Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paginated_coupons as $coupon): ?>
                        <tr class="text-center">
                            <td><?php echo htmlspecialchars($coupon['id']); ?></td>
                            <td class="text-truncate" style="max-width: 150px;">
                                <?php
                                $formattedName = str_replace('-', ' ', strtolower($coupon['code']));
                                $formattedName = ucwords($formattedName);
                                echo $formattedName;
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($coupon['discount']); ?></td>
                            <td><?php echo htmlspecialchars($coupon['usage_limit']); ?></td>
                            <td><?php echo htmlspecialchars($coupon['expiration_date']); ?></td>
                            <td><?php echo htmlspecialchars($coupon['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($coupon['updated_at']); ?></td>
                            <td>
                                <div style="display: inline-flex; gap: 5px;">
                                    <a href="/admin/coupon_edit/<?= htmlspecialchars($coupon['id']); ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form id="deleteForm-<?= htmlspecialchars($coupon['id']); ?>" action="/admin/deleteCoupon" method="POST" onsubmit="return confirmDelete(event, <?= htmlspecialchars($coupon['id']); ?>)">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($coupon['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <nav class="app-pagination ">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white" href="?page=<?= $current_page - 1 ?>&search=<?= urlencode($search_query) ?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link <?= $page == $current_page ? 'bg-success text-white' : 'bg-light text-dark' ?>" href="?page=<?= $page ?>&search=<?= urlencode($search_query) ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white" href="?page=<?= $current_page + 1 ?>&search=<?= urlencode($search_query) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    function confirmDelete(event, id) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this coupon?')) {
            document.getElementById('deleteForm-' + id).submit();
        }
    }
</script>

<?php
require "views/partials/admin_footer.php";
?>
