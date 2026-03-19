<?php
/**
 * Public Routes
 * These routes are accessible to all users (authenticated and non-authenticated)
 */

// Home page
$router->get('/', function() {
    include 'views/user/home.php';
});

// Login - GET (display form)
$router->get('/login', function() {
    if (isset($_SESSION['user_id'])) {
        header('Location: /');
        exit;
    }
    include 'views/auth/login.php';
});

// Login - POST (authenticate user)
$router->post('/login', function() {
    require_once 'models/users.php';
    $user = new User();
    
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!$email || !$password) {
        header('Location: /login?error=Invalid request');
        exit;
    }
    
    $userRecord = $user->authenticate($email, $password);
    
    if ($userRecord) {
        $_SESSION['user_id'] = $userRecord['id'];
        $_SESSION['role'] = $userRecord['role'] ?? 'user';
        header('Location: /');
    } else {
        header('Location: /login?error=Invalid credentials');
    }
    exit;
});

// Register - GET (display form)
$router->get('/register', function() {
    if (isset($_SESSION['user_id'])) {
        header('Location: /');
        exit;
    }
    include 'views/auth/register.php';
});

// Register - POST (create new user)
$router->post('/register', function() {
    require_once 'models/users.php';
    
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (!$name || !$email || !$password) {
        header('Location: /register?error=All fields are required');
        exit;
    }
    
    if ($password !== $confirm) {
        header('Location: /register?error=Passwords do not match');
        exit;
    }
    
    $user = new User();
    
    // Check if email exists
    if ($user->findOneBy('email', $email)) {
        header('Location: /register?error=Email already registered');
        exit;
    }
    
    // Create user
    $result = $user->insert([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'room_no' => $_POST['room'] ?? '',
        'ext' => $_POST['ext'] ?? '',
        'building' => $_POST['building'] ?? '',
        'role' => 'user',
        'created_at' => date('Y-m-d H:i:s')
    ]);
    
    if ($result) {
        header('Location: /login?success=Registration successful! Please login.');
    } else {
        header('Location: /register?error=Registration failed. Please try again.');
    }
    exit;
});

// Logout
$router->get('/logout', function() {
    session_destroy();
    header('Location: /');
    exit;
});

// Products page (user browsing)
$router->get('/products', function() {
    include 'views/products.php';
});

// Static Pages
$router->get('/about', function() {
    include 'views/about.php';
});

$router->get('/contact', function() {
    include 'views/contact.php';
});

$router->post('/contact/send', function() {
    // Simple contact form handler
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    if (!$name || !$email || !$subject || !$message) {
        header('Location: /contact?error=All fields are required');
        exit;
    }
    
    // Here you could add email sending or database storage
    header('Location: /contact?success=Thank you for your message! We will get back to you soon.');
    exit;
});

// Product Detail Page (Dynamic)
$router->get('/product/{id}', function($id) {
    require_once 'models/products.php';
    $product = new Product();
    $productData = $product->getProductById($id);
    
    if (!$productData) {
        http_response_code(404);
        include '404.php';
        return;
    }
    
    // Pass product data to view
    include 'views/product/detail.php';
});
