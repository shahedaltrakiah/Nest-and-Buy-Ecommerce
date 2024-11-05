<?php require "views/partials/header.php"; ?>

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<div class="untree_co-section" style="margin-top: -50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5 mb-md-0">
                <h2 class="h3 mb-3 text-black">Billing Details</h2>
                <div class=" p-4 border bg-white">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-black font-weight-bold" for="email">Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($customers->email); ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="text-black font-weight-bold" for="phone">Phone:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customers->phone_number); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="text-black font-weight-bold" for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($customers->address); ?>" required>
                        </div>
                    </div>


                    <!-- Checkout Button -->
                        <form id="checkoutForm" action="/customers/cart/checkout" method="POST"
                              onsubmit="return validateForm()">
                            <button type="button" class="btn btn-primary m-auto d-flex p-3" id="proceedBtn">Proceed to
                                Payment
                            </button>
                        </form>

                    <!-- SweetAlert2 Script -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        document.getElementById('proceedBtn').addEventListener('click', function (event) {
                            event.preventDefault(); // Prevent the form from submitting immediately

                            // Show SweetAlert confirmation dialog
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You are about to proceed to payment.",
                                icon: 'warning',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel',
                                confirmButtonText: 'Yes, proceed!',
                                confirmButtonColor: '#3b5d50',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If confirmed, submit the form
                                    document.getElementById('checkoutForm').submit();
                                }
                            });
                        });
                    </script>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <table class="table site-block-order-table mb-5">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $subtotal = 0;

                                // Calculate subtotal
                                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $productId => $product) {
                                        $totalPrice = $product['price'] * $product['quantity'];
                                        $subtotal += $totalPrice;
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars(ucwords(str_replace(['-', '_'], ' ', $product['name']))); ?>
                                                <strong
                                                        class="mx-2">x</strong> <?php echo htmlspecialchars($product['quantity']); ?>
                                            </td>
                                            <td>JD<?php echo number_format($totalPrice, 2); ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                    <td class="text-black">JD<?php echo number_format($subtotal, 2); ?></td>
                                </tr>

                                <?php
                                // Calculate discount if applicable
                                $discount = $_SESSION['discount'] ?? 0;
                                if ($discount > 0) {
                                    echo "<tr>
                                    <td class='text-black font-weight-bold'><strong>Discount</strong></td>
                                    <td class='text-black'>JD" . number_format($discount, 2) . "</td>
                                  </tr>";
                                }

                                // Calculate total amount
                                $totalAmount = $subtotal - $discount;
                                ?>

                                <tr>
                                    <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                    <td class="text-black font-weight-bold">
                                        <strong>JD<?php echo number_format($totalAmount, 2); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require "views/partials/footer.php"; ?>
<script>
    function validateForm() {
        const email = document.getElementById('c_email_address').value;
        const phoneInput = document.getElementById('c_phone').value;

        const phonePattern = /^(\+9627|07)\d{8}$/;
        const emailPattern = /^[a-zA-Z][\w.-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!emailPattern.test(email)) {
            swal("Error", "Email should not start with a number and should be valid.", "error");
            return false;
        }
        if (!phonePattern.test(phoneInput)) {
            swal("Error", "Please enter a valid Jordanian phone number.", "error");
            return false;
        }
        return true;
    }
</script>

