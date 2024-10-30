<?php require "views/partials/header.php"; ?>

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<div class="untree_co-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12">
					<div class="border p-4 rounded" role="alert">
						Returning customer? <a href="login.php">Click here</a> to login
					</div>
				</div>
			</div>
			<div class="row">
    <div class="col-md-6 mb-5 mb-md-0">
        <h2 class="h3 mb-3 text-black">Billing Details</h2>
        <div class="p-3 p-lg-5 border bg-white">
        <form action="/customers/cart/checkout" method="POST" onsubmit="return validateForm()">
    <div class="form-group row">
        <div class="col-md-6">
            <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_fname" name="c_fname" required>
        </div>
        <div class="col-md-6">
            <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_lname" name="c_lname" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address" required>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-6">
            <label for="c_state_country" class="text-black">State / Country <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_state_country" name="c_state_country" required>
        </div>
        <div class="col-md-6">
            <label for="c_postal_zip" class="text-black">Postal / Zip <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" required>
        </div>
    </div>

    <div class="form-group row mb-5">
        <div class="col-md-6">
            <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="c_email_address" name="c_email_address" required>
        </div>
        <div class="col-md-6">
            <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number" required>
        </div>
    </div>

    <div class="form-group m-2">
        <label for="c_order_notes" class="text-black">Order Notes</label>
        <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
    </div>

                        <button type="submit" class="btn btn-primary m-auto d-flex p-3">Proceed to Payment</button>
                    </form>
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
                                    <td><?php echo htmlspecialchars($product['name']); ?> <strong class="mx-2">x</strong> <?php echo htmlspecialchars($product['quantity']); ?></td>
                                    <td>$<?php echo number_format($totalPrice, 2); ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <tr>
                            <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                            <td class="text-black">$<?php echo number_format($subtotal, 2); ?></td>
                        </tr>

                        <?php
                        // Calculate discount if applicable
                        $discount = $_SESSION['discount'] ?? 0;
                        if ($discount > 0) {
                            echo "<tr>
                                    <td class='text-black font-weight-bold'><strong>Discount</strong></td>
                                    <td class='text-black'>-$" . number_format($discount, 2) . "</td>
                                  </tr>";
                        }

                        // Calculate total amount
                        $totalAmount = $subtotal - $discount;
                        ?>
                        
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                            <td class="text-black font-weight-bold"><strong>$<?php echo number_format($totalAmount, 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
</div>




<?php require "views/partials/footer.php"; ?>
<script>
function validateForm() {
    const firstName = document.getElementById('c_fname').value;
    const lastName = document.getElementById('c_lname').value;
    const postalCode = document.getElementById('c_postal_zip').value;
    const email = document.getElementById('c_email_address').value;
    const phoneInput = document.getElementById('c_phone').value;

                    const namePattern = /^[A-Za-z\s]+$/;
                    const phonePattern = /^(\+9627|07)\d{8}$/;
                    const postalPattern = /^\d+$/;
                    const emailPattern = /^[a-zA-Z][\w.-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!namePattern.test(firstName)) {
        swal("Error", "First Name should only contain letters.", "error");
        return false;
    }
    if (!namePattern.test(lastName)) {
        swal("Error", "Last Name should only contain letters.", "error",);
        return false;
    }
    if (!postalPattern.test(postalCode)) {
        swal("Error", "Postal/Zip Code should only contain numbers.", "error");
        return false;
    }
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