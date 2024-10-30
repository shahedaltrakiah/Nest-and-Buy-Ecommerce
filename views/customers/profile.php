<?php require "views/partials/header.php"; ?>

<link href="../public/css/user_profile_style.css" rel="stylesheet">

<div class="main-container">
    <!-- Profile Section -->
    <div class="profile-card">
        <button class="profile-edit-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit
            Profile</button>
        <div class="profile-info">
            <img src="../public/images/shahed.jpeg" alt="Profile Picture">
            <div>
                <h3>John Doe</h3>
            </div>
        </div>
        <div class="profile-details mt-4">
            <div class="row">
                <div class="col-md-12">
                    <label>Username</label>
                    <input type="text" class="form-control" value="johndoe" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="John" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="Doe" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="johndoe@example.com" readonly>
                </div>
                <div class="col-md-6 mt-3">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" value="+962123456789" readonly>
                </div>
                <div class="col-md-12 mt-3">
                    <label>Address</label>
                    <input type="text" class="form-control" value="123 Main Street, Amman" readonly>
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

    <!-- Wishlist Section -->
    <div class="order-card">
        <h4>Your Wishlist</h4>
        <div class="wishlist-item">
            <img src="../public/images/sofa.png" alt="Product 1">
            <div class="wishlist-details">
                <h6>Product 1</h6>
                <p class="text-muted">$19.99</p>
            </div>
            <button class="btn btn-danger btn-sm" onclick="removeItem('Product 1')">Remove</button>
            <!-- Pass item name -->
        </div>

        <div class="wishlist-item">
            <img src="../public/images/sofa.png" alt="Product 2">
            <div class="wishlist-details">
                <h6>Product 2</h6>
                <p class="text-muted">$19.99</p>
            </div>
            <button class="btn btn-danger btn-sm" onclick="removeItem('Product 2')">Remove</button>
            <!-- Pass item name -->
        </div>
        <!-- Repeat for more wishlist items -->
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
