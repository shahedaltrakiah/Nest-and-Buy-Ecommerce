<?php

class AdminController extends Controller
{
    // Admin login
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $formType = $_POST['form_type'];

            if ($formType === 'signin') {
                // Handle Sign In
                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = $this->model('Admin')->login($email);
                if ($user && password_verify($password, $user['password'])) {

                    // Store user information in the session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'role' => $user['role'],
                        'image_url' => 'images/user-profile.png',
                    ];
                    echo json_encode(['loginSuccess' => true]);
                    exit();
                } else {
                    echo json_encode(['loginSuccess' => false]);
                    exit();
                }

            }
        }
        $this->view('admin/login');
    }

    // Admin dashboard
    public function dashboard()
    {
        $this->view('admin/dashboard');
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

    // Manage Admins (Only accessible to Super Admin)
    public function manageAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'super admin') {
            header('Location: /admin/dashboard');
            exit();
        }

        $admins = $this->model('Admin')->getAllAdmins();
        $this->view('admin/superAdmin_manage_admin', ['admins' => $admins]);
    }


    // Handle messages
    public function messages()
    {
        $messages = $this->model('Message')->getAllMessages();
        $this->view('admin/messages', ['messages' => $messages]);
    }

    // Account settings page
    public function accountSettings()
    {
        $admin = $this->model('Admin')->getAdminById($_SESSION['admin_id']);
        $this->view('admin/account_settings', ['admins' => $admin]);
    }

    // Admin logout
    public function logout()
    {
        unset($_SESSION['admin_id']);
        session_destroy();
        header('Location: /admin/login');
    }
}


