<?php

abstract class Controller {
    
    /**
     * Load a view file
     */
    protected function loadView($viewName, $data = []) {
        $viewPath = __DIR__ . '/../views/' . $viewName . '.php';
        
        if (!file_exists($viewPath)) {
            die("View not found: $viewName");
        }

        // Extract data to make variables available in view
        if (!empty($data)) {
            extract($data, EXTR_PREFIX_ALL, 'data');
        }

        include $viewPath;
    }

    /**
     * Render JSON response
     */
    protected function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if user has a specific role
     */
    protected function hasRole($role) {
        return isset($_SESSION['role']) && $_SESSION['role'] === $role;
    }

    /**
     * Get current user ID
     */
    protected function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current user role
     */
    protected function getUserRole() {
        return $_SESSION['role'] ?? null;
    }

    /**
     * Require authentication
     */
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }

    /**
     * Require specific role
     */
    protected function requireRole($role) {
        $this->requireAuth();
        if (!$this->hasRole($role)) {
            http_response_code(403);
            die('Access denied');
        }
    }
}
?>
