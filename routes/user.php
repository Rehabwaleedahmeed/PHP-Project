<?php
/**
 * User Routes
 * User-specific pages and operations (requires authentication)
 */

// Order creation page
$router->get('/order/create', function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    include 'views/order/create.php';
});

// User's orders list
$router->get('/orders', function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    include 'views/orders.php';
});

// My orders (alternative route)
$router->get('/my-orders', function() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    include 'views/user/my_order.php';
});

// Store order (POST)
$router->post('/orders/store', function() {
    if (!isset($_SESSION['user_id'])) {
        return ['success' => false, 'message' => 'Unauthorized: Please login', 'code' => 401];
    }

    require_once 'controllers/orderController.php';
    $controller = new OrderController();
    
    return $controller->store();
});
