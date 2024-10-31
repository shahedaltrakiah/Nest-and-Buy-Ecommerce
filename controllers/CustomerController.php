<?php

class CustomerController extends Controller
{

    // Customer login & registration
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formType = $_POST['form_type'];

            if ($formType === 'signup') {
                $data = [
                    'first_name' => $_POST['first_name'],
                    'last_name' => $_POST['last_name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone_number'],
                    'password' => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password']
                ];

                // Check if the email is already in use
                if ($this->model('Customer')->isEmailTaken($data['email'])) {
                    echo json_encode(['emailTaken' => true]);
                    exit();
                }

                // If registration is successful
                if ($this->model('Customer')->register($data)) {
                    echo json_encode(['registrationSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['registrationSuccess' => false]);
                    exit();
                }
            } elseif ($formType === 'signin') {
                // Handle Sign In
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->model('Customer')->login($email);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'image_url' => $user['image_url'] ?? 'https://cdn.icon-icons.com/icons2/2030/PNG/512/user_icon_124042.png',
                        'name' => $user['first_name'] . ' ' . $user['last_name']
                    ];
                    echo json_encode(['loginSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['loginSuccess' => false]);
                    exit();
                }
            }
        }
        $this->view('customers/login_and_register');
    }



    // Home page for customers
    public function index()
    {
        $products = $this->model('Product')->getMainCategoriesWithProducts();
        $this->view('customers/index', ['products' => $products]);
    }

    // About Us page
    public function about()
    {
        $this->view('customers/about');
    }

    // Contact Us page
    public function contact()
    {
//        $messages = $this->model('Message')->saveMessage($id);
//        $this->view('customers/contact', ['messages' => $messages]);
        $this->view('customers/contact');
    }

    // Category details page
    public function categoryView($id)
    {
        $products = $this->model('Product')->getProductCategory($id);
        $this->view('customers/category', ['products' => $products]);
    }

    // Products page
    public function shop()
    {
        $products = $this->model('Product')->getProducts();
        $this->view('customers/shop', ['products' => $products]);

    }

    //rania: Product details page
    public function productDetails($id)
    {
        $product = $this->model('Product')->getProductById($id);
        $reviews = $this->model('Review')->getReviewsByProductId($id);
        $user = null;

        // Check if the user is logged in
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $user = $this->model('User')->getUserById($customerId); // Assuming a `getUserById` method in User model
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // If form is submitted and user isn't logged in, trigger SweetAlert
            echo "<script>swal('Please log in to submit a review!', '', 'warning');</script>";
        }

        // Handle review submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user) {
            $reviewData = [
                'product_id' => $id,
                'customer_id' => $customerId,
                'rating' => $_POST['rating'],
                'comment' => $_POST['comment']
            ];

            if ($this->model('Review')->addReview($reviewData)) {
                header("Location: /customers/productDetails/$id");
                exit();
            } else {
                echo "<script>swal('Error!', 'Failed to submit review. Please try again.', 'error');</script>";
            }
        }

        $this->view('customers/products_details', [
            'product' => $product,
            'reviews' => $reviews,
            'user' => $user // Pass user data to the view
        ]);
    }
    // Cart page
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; // Check if cart exists
        $this->view('customers/cart', ['cart' => $cart]); // Pass cart data to the view
    }

    // Checkout page
    public function checkout()
    {
        $this->view('customers/checkout');
    }
    public function test() {
        // Include the test view
        require_once __DIR__ . '/../views/customers/test.php';
    }

    // Profile page for customer
    public function profile()
    {
        $customer = $this->model('Customer')->getCustomerById();

        $orderitems = $this->model('OrderItem')->getOrderDetails();

        $this->view('customers/profile', ['customers' => $customer, 'orderitems' => $orderitems]);

    }

    // Customer logout
    public function logout()
    {
        unset($_SESSION['id']);
        session_destroy();
        header('Location: /customers/login_and_register');
    }
}
