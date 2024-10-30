<?php require "views/partials/header.php"; ?>

<link href="/public/css/user_profile_style.css" rel="stylesheet">

<div class="main-container">
    <!-- Profile Section -->
    <div class="profile-card">
        <button class="profile-edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
        <div class="profile-info">
            <img src="/public/images/<?= htmlspecialchars($customer->profile_image ?? 'default.jpg') ?>" alt="Profile Picture">
            <div>
                <h3><?php echo htmlspecialchars($customer[0]['first_name ']); ?></h3>
            </div>
        </div>
        <div class="profile-details mt-4">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer->first_name) ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer->last_name) ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?= htmlspecialchars($customer->email) ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer->phone) ?>" readonly>
                </div>
                <div class="col-md-12 mt-3">
                    <label>Address</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($customer->address) ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History Section -->
    <div class="order-card">
        <h4>Order History</h4>
        <table class="table order-table">
            <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>#12345</td>
                <td>Oct 15, 2024</td>
                <td><span class="badge bg-success">Delivered</span></td>
                <td>$49.99</td>
                <td>
                    <button class="view-details-btn" data-bs-toggle="modal"
                            data-bs-target="#orderDetailsModal">View Details</button>
                </td>
            </tr>
            <tr>
                <td>#12346</td>
                <td>Sept 30, 2024</td>
                <td><span class="badge bg-warning">Shipped</span></td>
                <td>$29.99</td>
                <td>
                    <button class="view-details-btn" data-bs-toggle="modal"
                            data-bs-target="#orderDetailsModal">View Details</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="container wishlist-section my-4">
    <h4 class="mb-4 text-center text-primary">Your Wishlist</h4> <!-- Changed to text-primary -->

    <div class="row justify-content-center"> <!-- Center the row -->
        <?php if (!empty($wishlistItems)): ?>
            <?php foreach ($wishlistItems as $item): ?>
                <div class="col-md-3 col-sm-6 mb-4"> <!-- Bootstrap column for responsive layout -->
                    <div class="card wishlist-card">
                        <img class="card-img-top" style="height: 80px; width: 80px; object-fit: contain; margin: auto;" src="<?= htmlspecialchars('/public/' . $item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                        <div class="card-body text-center">
                            <h6 class="card-title text-dark"><?= htmlspecialchars($item['product_name']) ?></h6> <!-- Changed to text-dark -->
                            <p class="card-text text-muted">$<?= htmlspecialchars($item['price']) ?></p>

                            <!-- Form to remove item from wishlist -->
                            <form class="remove-wishlist-form" action="/customers/profile/remove" method="POST">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product_id']) ?>">
                                <button type="button" class="btn btn-danger btn-sm remove-btn">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No items in your wishlist.</p> <!-- Changed to text-muted -->
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Profile Edit Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>First Name</label>
                        <input type="text" class="form-control" value="John">
                    </div>
                    <div class="col-md-6">
                        <label>Last Name</label>
                        <input type="text" class="form-control" value="Doe">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Email</label>
                        <input type="email" class="form-control" value="johndoe@example.com">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" value="+962123456789">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label>Address</label>
                        <input type="text" class="form-control" value="123 Main Street, Amman">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="updateUserProfile()">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Viewing Order Details -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="order-details">
                    <h5>Order ID: <span class="text-primary">#12345</span></h5>
                    <p><strong>Date:</strong> <span class="text-muted">Oct 15, 2024</span></p>
                    <p><strong>Status:</strong> <span class="text-success">Delivered</span></p>
                    <p><strong>Total:</strong> <span class="text-danger">$49.99</span></p>
                    <p><strong>Shipping Address:</strong> <span class="text-muted">123 Main St, City, Country</span>
                    </p>
                    <p><strong>Items Ordered:</strong></p>
                    <div class="order-items">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 1
                                <span class="badge bg-secondary">$19.99</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 2
                                <span class="badge bg-secondary">$30.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 3
                                <span class="badge bg-secondary">$25.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 4
                                <span class="badge bg-secondary">$15.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 5
                                <span class="badge bg-secondary">$40.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Product 6
                                <span class="badge bg-secondary">$20.00</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
$(document).on('click', '.remove-btn', function(event) {
    var form = $(this).closest('form'); // Get the closest form

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: form.attr('action'), // Get the action URL from the form
                type: 'POST',
                data: form.serialize(), // Serialize the form data
                success: function(response) {
                    // Optionally handle success (like updating the UI)
                    Swal.fire(
                        'Removed!',
                        'The item has been removed from your wishlist.',
                        'success'
                    ).then(() => {
                        location.reload(); // Reload the page to update the wishlist
                    });
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'There was an error removing the item. Please try again.',
                        'error'
                    );
                }
            });
        }
    });
});
</script>
<script>
    function updateUserProfile() {
        Swal.fire({
            title: 'Success!',
            text: 'Your profile has been updated.',
            icon: 'success',
            confirmButtonColor: '#3B5D50'
        });
    }

    function removeItem(itemName) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove " + itemName + " from your wishlist!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                        title: 'Removed!',
                        text: itemName + ' has been removed from your wishlist.',
                        icon: 'success',
                        confirmButtonColor: '#3B5D50'
                    }
                );

            }
        });
    }
</script>
