<?php
require "views/partials/admin_header.php";
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
$filtered_orders = array_filter($orders, function ($order) use ($search_query) {
    return stripos($order['status'], $search_query) !== false;
});

// Default to all orders if no search query is provided
if ($search_query === '') {
    $filtered_orders = $orders;
}

$items_per_page = 20;
$current_page = max(1, isset($_GET['page']) ? (int)$_GET['page'] : 1);
$start_index = ($current_page - 1) * $items_per_page;
$paginated_orders = array_slice($filtered_orders, $start_index, $items_per_page);
$total_items = count($filtered_orders);
$total_pages = ceil($total_items / $items_per_page);
?>

<div class="app-wrapper">
    <div class="app-content pt-3 p-md-3 p-lg-4">
        <div class="container-xl">
            <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                <div class="col-auto">
                    <h1 class="app-page-title mb-0 text-success fw-bold" style="font-size: 2rem; text-shadow: 1px 1px 2px #d4edda;">
                        <i class="bi bi-box-seam me-2"></i>
                        Orders
                    </h1>
                </div>
                <div class="col-auto">
                    <div class="page-utilities">
                        <form class="docs-search-form row gx-1 align-items-center" method="GET" action="">
                            <div class="col-auto">
                                <input type="text" id="search-docs" name="search"
                                       value="<?= htmlspecialchars($search_query) ?>"
                                       class="form-control bg-light border-success rounded-pill"
                                       placeholder="Search orders....">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn rounded-pill" style="background-color: #5bb377; border-color: #5bb377;">
                                    <i class="fas fa-search text-white"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
    <table class="table table-hover table-borderless shadow-sm rounded">
        <thead class="table-success">
            <tr class="text-center">
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">Customer ID</th>
                <th class="text-nowrap">Order Date</th>
                <th class="text-nowrap">Status</th>
                <th class="text-nowrap">Total Amount</th>
                <th class="text-nowrap">Created At</th>
                <th class="text-nowrap">Updated At</th>
                <th class="text-nowrap">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paginated_orders as $order): ?>
                <tr class="text-center">
                    <td><?= htmlspecialchars($order['id']); ?></td>
                    <td><?= htmlspecialchars($order['customer_id']); ?></td>
                    <td><?= htmlspecialchars($order['order_date']); ?></td>
                    <td>
                        <span class="badge bg-<?php
                        if ($order['status'] == 'completed') {
                            echo 'success';
                        } elseif ($order['status'] == 'canceled') {
                            echo 'danger';
                        } else {
                            echo 'warning';
                        } ?>">
                            <?= htmlspecialchars(ucfirst($order['status'])) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($order['total_amount']); ?></td>
                    <td class="text-nowrap"><?= htmlspecialchars(date('Y-m-d', strtotime($order['created_at']))); ?></td>
                    <td class="text-nowrap"><?= htmlspecialchars(date('Y-m-d', strtotime($order['updated_at']))); ?></td>
                    <td>
                        <form action="/admin/changeOrderStatus" method="POST" class="d-inline">
                            <input type="hidden" name="orderId" value="<?= htmlspecialchars($order['id']); ?>">
                            <input type="hidden" name="currentStatus" value="<?= htmlspecialchars($order['status']); ?>">
                            <select name="status" <?= ($order['status'] === 'completed' || $order['status'] === 'canceled') ? 'disabled' : ''; ?>>
                                <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="canceled" <?= $order['status'] === 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                            </select>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



            <nav class="app-pagination">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $current_page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white"
                           href="?page=<?= $current_page - 1 ?>&search=<?= urlencode($search_query) ?>" tabindex="-1"
                           aria-disabled="true">Previous</a>
                    </li>
                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?= $page == $current_page ? 'active' : '' ?>">
                            <a class="page-link <?= $page == $current_page ? 'bg-success text-white' : 'bg-light text-dark' ?>"
                               href="?page=<?= $page ?>&search=<?= urlencode($search_query) ?>"><?= $page ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?= $current_page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link bg-primary text-white"
                           href="?page=<?= $current_page + 1 ?>&search=<?= urlencode($search_query) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php
require "views/partials/admin_footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('select[name="status"]').forEach(select => {
        select.addEventListener('change', function () {
            const form = this.form;
            const selectedValue = this.value;
            const currentStatus = form.querySelector('input[name="currentStatus"]').value;

            if (selectedValue === 'completed') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to mark this order as completed!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, mark it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    } else {
                        this.value = currentStatus; // Reset selection if canceled
                    }
                });
            } else if (selectedValue === 'canceled') {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to cancel this order!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'No, keep it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if confirmed
                    } else {
                        this.value = currentStatus; // Reset selection if canceled
                    }
                });
            } else {
                form.submit(); // Submit for other statuses
            }

            // Disable the select if the current status is already completed or canceled
            if (currentStatus === 'completed' || currentStatus === 'canceled') {
                this.disabled = true; // Disable the dropdown
            }
        });
    });
</script>
