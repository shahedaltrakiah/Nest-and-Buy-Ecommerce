<?php

class Core {
    protected $routes = [
        // Default route to customer index
        '' => ['CustomerController@index', 'GET'], // This handles the root URL

        // Admin Routes
        'admin/login' => ['AdminController@login', 'POST'],
        'admin/dashboard' => ['AdminController@dashboard', 'GET'],
        'admin/manage_category' => ['AdminController@manageCategory', 'GET'],
        'admin/manage_products' => ['AdminController@manageProducts', 'GET'],
        'admin/manage_orders' => ['AdminController@manageOrders', 'GET'],
        'admin/manage_customers' => ['AdminController@manageCustomers', 'GET'],
        'admin/manage_coupon' => ['AdminController@manageCoupon', 'GET'],
        'admin/messages' => ['AdminController@messages', 'GET'],
        'admin/account_settings' => ['AdminController@accountSettings', 'GET'],
        'admin/logout' => ['AdminController@logout', 'GET'],
        'admin/product_view' => ['AdminController@viewProduct', 'GET'],
        'admin/product_edit' => ['AdminController@editProduct', 'GET'], // Specify POST for updates
        'admin/product_update' => ['AdminController@updateProduct', 'POST'], // Specify POST for updates

        // Super Admin Routes
        'super-admin/login' => ['SuperAdminController@login', 'POST'],
        'super-admin/dashboard' => ['SuperAdminController@dashboard', 'GET'],
        'super-admin/manage_category' => ['SuperAdminController@manageCategory', 'GET'],
        'super-admin/manage_products' => ['SuperAdminController@manageProducts', 'GET'],
        'super-admin/manage_orders' => ['SuperAdminController@manageOrders', 'GET'],
        'super-admin/manage_customers' => ['SuperAdminController@manageCustomers', 'GET'],
        'super-admin/manage_coupon' => ['SuperAdminController@manageCoupon', 'GET'],
        'super-admin/messages' => ['SuperAdminController@messages', 'GET'],
        'super-admin/account_settings' => ['SuperAdminController@accountSettings', 'GET'],
        'super-admin/logout' => ['SuperAdminController@logout', 'GET'],
        'super-admin/manage_admin' => ['SuperAdminController@manageAdmin', 'GET'],

        // Customer Routes
        'customers/login_and_register' => ['CustomerController@login', ['GET', 'POST']],
        'customers/index' => ['CustomerController@index', 'GET'],
        'customers/about' => ['CustomerController@about', 'GET'],
        'customers/contact' => ['CustomerController@contact', 'GET'],
        'customers/category' => ['CustomerController@categoryView', 'GET'],
        'customers/shop' => ['CustomerController@shop', 'GET'],
        'customers/product_details' => ['CustomerController@productDetails', 'GET'],
        'customers/cart' => ['CustomerController@cart', 'GET'],
        'customers/checkout' => ['CustomerController@checkout', 'GET'],
        'customers/profile' => ['CustomerController@profile', 'GET'],
        'customers/logout' => ['CustomerController@logout', 'GET'],
        'customer/cart'=>['CartController@add','POST'],
        'customers/test'=> ['CustomerController@test', 'GET'],
        'customers/cart/checkout' => ['CartController@checkout','POST'],
        'customers/cart/remove' => ['CartController@remove', ['POST', 'GET']],
        'customers/cart/remove-coupon'=>['CartController@removeCoupon','POST'],
        'customers/cart/apply-coupon'=>['CartController@applyCoupon','POST'],
        'customer/profile/add' => ['WishlistController@add', ['POST']],
   'customers/profile/remove' => ['WishlistController@remove', 'POST'],
         'customers/profile'=>['WishlistController@viewWishlist','GET'],
 
        
    ];

    public function __construct() {
        $this->dispatch();
    }

    private function dispatch() {
        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD']; // Get the current request method

        // Split URL into parts
        $urlParts = explode('/', $url);
        $lastPart = end($urlParts);

        // Determine route path and optional ID
        if (ctype_digit($lastPart)) {
            $id = $lastPart;
            $routePath = implode('/', array_slice($urlParts, 0, -1)); // Remove last part for route path
        } else {
            $routePath = $url; // Use full URL as route path
            $id = null;         // No ID
        }

        if (isset($this->routes[$routePath])) {
            $route = $this->routes[$routePath];
            $controllerMethod = explode('@', $route[0]);
            $controllerName = $controllerMethod[0];
            $methodName = $controllerMethod[1];
            $routeMethod = $route[1] ?? 'GET'; // Default to GET if no method is specified

            // Check if route allows the request method
            if ((is_array($routeMethod) && in_array($method, $routeMethod)) || $method === $routeMethod) {
                if (file_exists('controllers/' . $controllerName . '.php')) {
                    require_once 'controllers/' . $controllerName . '.php';
                    $controller = new $controllerName;

                    if (method_exists($controller, $methodName)) {
                        // Call the method with or without ID
                        if ($id !== null) {
                            $controller->$methodName($id);
                        } else {
                            $controller->$methodName();
                        }
                        return;
                    } else {
                        die("ERROR: Method $methodName not found in $controllerName.");
                    }
                } else {
                    die("ERROR: Controller $controllerName not found.");
                }
            } else {
                die("ERROR: Method not allowed for URL '$url'. Expected $routeMethod.");
            }
        } else {
            die("ERROR: Route not found for URL '$url' and method $method.");
        }
    }

    private function getUrl() {
        $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $url = trim($url, '/');  // Trim leading and trailing slashes

        if (strpos($url, '?') !== false) {
            $url = strstr($url, '?', true);  // Remove query strings for clean URL
        }

        return $url;
    }
}