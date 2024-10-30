<?php
class SuperAdminController extends Controller {

    // Admin login action
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the login form
            $username = $_POST['email'];
            $password = $_POST['password'];

            $admin = $this->model('Admin')->login($username, $password);

            if ($admin) {
                // Set session and redirect
                $_SESSION['admin_id'] = $admin->id;
                header('Location: /admin/dashboard');
            } else {
                $this->view('admin/login', ['error' => 'Invalid credentials']);
            }
        } else {
            // Load the login view
            $this->view('admin/login');
        }
    }

    // Load the dashboard
    public function dashboard()
    {
        $this->view('admin/dashboard');
    }

    // Manage Admins (Only accessible to Super Admin)
    public function manageAdmin()
    {
        // Logic for managing admin accounts
        $admins = $this->model('Admin')->getAllAdmins();
        $this->view('super_admin/manage_admin', ['admins' => $admins]);
    }

    // Manage categories
    public function manageCategory()
    {
        $categories = $this->model('Category')->getAllCategories();
        $this->view('admin/manage_category', ['categories' => $categories]);
    }

    // Manage products
    public function manageProducts()
    {
        $products = $this->model('Product')->getAllProducts();
        $this->view('admin/manage_products', ['products' => $products]);
    }

    // Manage orders
    public function manageOrders()
    {
        $orders = $this->model('Order')->getAllOrders();
        $this->view('admin/manage_orders', ['orders' => $orders]);
    }

    // Manage customers
    public function manageCustomers()
    {
        $customers = $this->model('Customer')->getAllCustomers();
        $this->view('admin/manage_customers', ['customers' => $customers]);
    }

    // Manage coupons
    public function manageCoupon()
    {
        $coupons = $this->model('Coupon')->getAllCoupons();
        $this->view('admin/manage_coupon', ['coupons' => $coupons]);
    }

    // Handle messages
    public function messages()
    {
        $messages = $this->model('Message')->getAllMessages();
        $this->view('admin/messages', ['messages' => $messages]);
    }

    // Admin account settings
    public function accountSettings()
    {
        $admin = $this->model('Admin')->getAdminById($_SESSION['admin_id']);
        $this->view('admin/account_settings', ['admin' => $admin]);
    }

    // Logout action
    public function logout()
    {
        unset($_SESSION['admin_id']);
        session_destroy();
        header('Location: /admin/login');
    }
}