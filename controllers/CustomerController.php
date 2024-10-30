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
//                if ($this->model('Customer')->isEmailTaken($data['email'])) {
//                    echo "<script>
//                    swal('Error!', 'This email is already in use.', 'error');
//                  </script>";
//                    return; // Stop further processing
//                }

                // If registration is successful
//                if ($this->model('Customer')->register($data)) {
//                    echo "<script>
//                    swal('Success!', 'Registration successful! You can now log in.', 'success').then(() => {
//                        window.location = '/customers/login_and_register';
//                    });
//                  </script>";
//                    exit();
//                }

                if ($this->model('Customer')->register($data)) {
                    header("Location: /customers/login_and_register"); // Redirect to login page or success page
                    exit();
                }

            } elseif ($formType === 'signin') {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->model('Customer')->login($email);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'image_url' => $user['image_url'] ?? 'https://cdn.icon-icons.com/icons2/2030/PNG/512/user_icon_124042.png',
                        'name' => $user['first_name'] . ' ' . $user['last_name']
                    ];
                    header("Location: /customers/index");
                    exit();
                } else {
                    echo "<script>
                    swal('Error!', 'Invalid credentials. Please try again.', 'error');
                  </script>";
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

    // Product details page
    public function productDetails($id)
    {
        $products = $this->model('Product')->find($id);
        $this->view('customers/products_details', ['products' => $products]);
    }

    // Cart page
    public function cart()
    {
        $cart = $_SESSION['cart'];
        $this->view('customers/cart', ['cart' => $cart]);
    }

    // Checkout page
    public function checkout()
    {
        $this->view('customers/checkout');
    }

    // Profile page for customer
    public function profile()
    {
//        $customer = $this->model('Customer')->getCustomerById($_SESSION['customer_id']);
//        $this->view('customers/profile', ['customer' => $customer]);
        $this->view('customers/profile');
    }

    // Customer logout
    public function logout()
    {
        unset($_SESSION['id']);
        session_destroy();
        header('Location: /customers/login_and_register');
    }
}
