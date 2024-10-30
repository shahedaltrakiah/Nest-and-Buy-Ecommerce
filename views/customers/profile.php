<?php require "views/partials/header.php"; ?>

<link href="/public/css/user_profile_style.css" rel="stylesheet">

<div class="main-container">
    <!-- Profile Section -->
    <div class="profile-card">
        <button class="profile-edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
        <div class="profile-info">
            <img src="/public/<?php echo $_SESSION['user']['image_url'] ?? '/public/images/user-profile.png'; ?>">
            <div>
                <h3><?php echo htmlspecialchars($customers->first_name . ' ' . $customers->last_name); ?></h3>
            </div>
        </div>
        <div class="profile-details mt-4">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($customers->first_name); ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($customers->last_name); ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($customers->email); ?>" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($customers->phone_number); ?>" readonly>
                </div>
                <div class="col-md-12 mt-3">
                    <label>Address</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($customers->address); ?>" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Edit Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="editFirstName" value="<?php echo htmlspecialchars($customers->first_name); ?>">
                        </div>
                        <div class="col-md-6">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="editLastName" value="<?php echo htmlspecialchars($customers->last_name); ?>">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label>Email</label>
                            <input type="email" class="form-control" id="editEmail" value="<?php echo htmlspecialchars($customers->email); ?>">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" id="editPhoneNumber" value="<?php echo htmlspecialchars($customers->phone_number); ?>">
                        </div>
                        <div class="col-md-12 mt-3">
                            <label>Address</label>
                            <input type="text" class="form-control" id="editAddress" value="<?php echo htmlspecialchars($customers->address); ?>">
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
            <?php foreach ($orderitems as $order): ?>
                <tr>
                    <td>#<?= htmlspecialchars($order->order_id) ?></td>
                    <td><?= htmlspecialchars(date('M d, Y', strtotime($order->order_date))) ?></td>
                    <td><span class="badge bg-<?= $order->status == 'completed' ? 'success' : 'warning' ?>"><?= htmlspecialchars(ucfirst($order->status)) ?></span></td>
                    <td>JD<?= number_format($order->total_amount, 2) ?></td>
                    <td>
                        <button class="view-details-btn" data-bs-toggle="modal"
                                data-bs-target="#orderDetailsModal" data-order-id="<?= $order->order_id ?>">View Details</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
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
                        <h5>Order ID: <span class="text-primary">#<?= htmlspecialchars($order->order_id) ?></span></h5>
                        <p><strong>Date:</strong> <span class="text-muted"><?= htmlspecialchars(date('M d, Y', strtotime($order->order_date))) ?></span></p>
                        <p><strong>Status:</strong> <span class="badge bg-<?= $order->status == 'completed' ? 'success' : 'warning' ?>"><?= htmlspecialchars(ucfirst($order->status)) ?></span></p>
                        <p><strong>Total:</strong> <span class="text-danger">JD<?= number_format($order->total_amount, 2) ?></span></p>
                        <p><strong>Shipping Address:</strong> <span class="text-muted">Amman,Joradan</span>
                        </p>
                        <p><strong>Items Ordered:</strong></p>
                        <div class="order-items">
                            <?php foreach ($orderitems as $order): ?>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= htmlspecialchars($order->product_name) ?>
                                    <span class="badge bg-secondary">JD<?= number_format($order->product_price, 2) ?></span>
                                </li>
                            </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Wishlist Section -->
    <div class="order-card"">
        <h4>Your Wishlist</h4>
        <div class="row justify-content-center">
            <?php if (!empty($wishlistItems)): ?>
                <?php foreach ($wishlistItems as $item): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="card wishlist-card">
                            <img class="card-img-top" style="height: 80px; width: 80px; object-fit: contain; margin-top: 10px;" src="<?= htmlspecialchars('/public/' . $item['image_url']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                            <div class="card-body text-center">
                                <h6 class="card-title text-dark"><?php echo ucwords(str_replace(['-', '_'], ' ', htmlspecialchars($item['product_name'])));?></h6> <!-- Changed to text-dark -->
                                <p class="card-text text-muted">$<?= htmlspecialchars($item['price']) ?></p>

                                <form class="remove-wishlist-form" action="/customers/profile/remove" method="POST">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product_id']) ?>">
                                    <button type="button" class="btn btn-danger btn-sm remove-btn" style="margin-top: -10px;">Remove</button>
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
</div>


<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
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
