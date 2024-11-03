<?php require "views/partials/admin_header.php"; ?>
<div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container-xl">
                <div class="row g-3 mb-4 align-items-center justify-content-between shadow-sm p-3 bg-light rounded">
                    <div class="col-auto">
                        <h1 class="app-page-title mb-0 text-success fw-bold">
                            <i class="fas fa-star me-3"></i>Product Reviews
                        </h1>
                    </div>
                </div>
                <div class="table-responsive">
    <table class="table table-hover table-borderless shadow-sm rounded">
        <thead class="table-success">
            <tr class="text-center">
                <th>ID</th>
                <th>Customer ID</th>
                <th>Product ID</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <tr class="text-center">
                        <td><?= htmlspecialchars($review['id']); ?></td>
                        <td><?= htmlspecialchars($review['customer_id']); ?></td>
                        <td><?= htmlspecialchars($review['product_id']); ?></td>
                        <td>
    <?php for ($i = 5; $i >= 1; $i--): ?>
        <i class="bi bi-star<?= ($i <= $review['rating']) ? '' : '-fill' ?> text-success"></i> 
    <?php endfor; ?>
</td>                <td class="text-truncate" style="max-width: 150px;">
                            <?= htmlspecialchars($review['comment']); ?>
                        </td>
                        <td><?= date('d M Y', strtotime($review['created_at'])); ?></td>
                        <td>
                            <div class="d-flex justify-content-center">
                            <form id="deleteForm-<?= htmlspecialchars($review['id']); ?>"
      action="/admin/deleteReview" method="POST"
      onsubmit="return confirmDelete(event, '<?= htmlspecialchars($review['id']); ?>')"
      class="ms-2">
    <input type="hidden" name="reviewId" value="<?= htmlspecialchars($review['id']); ?>">
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi bi-trash"></i>
    </button>
</form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No reviews available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

</div>

                </div>
            </div>
        </div>
    </div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(event, reviewId) {
    event.preventDefault(); // Prevent the form from submitting immediately

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user confirms, submit the form
            document.getElementById('deleteForm-' + reviewId).submit();
        }
    });
}
</script>


    <?php require "views/partials/admin_footer.php"; ?>