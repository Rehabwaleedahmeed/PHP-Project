<?php
/**
 * Premium Cafeteria Management System
 * Main Application Entry Point
 * 
 * Refactored Architecture:
 * - Clean, modular route organization
 * - Separated concerns (public, API, admin, user routes)
 * - Minimal bootstrap logic
 * - Professional, maintainable structure
 */

session_start();

// Ensure consistent error reporting during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ============================================================
// CORE CONFIGURATION & DEPENDENCIES
// ============================================================

require_once 'config/dp.php';
require_once 'core/Router.php';
require_once 'core/controller.php';
require_once 'core/model.php';

// Initialize the router
$router = new Router();

// ============================================================
// LOAD ROUTE MODULES
// ============================================================

require_once 'routes/public.php';    // Public routes (home, auth, static pages)
require_once 'routes/api.php';       // API routes (RESTful endpoints)
require_once 'routes/admin.php';     // Admin routes (admin-only pages)
require_once 'routes/user.php';      // User routes (authenticated user pages)

// ============================================================
// 404 HANDLER
// ============================================================

$router->notFound(function() {
    http_response_code(404);
    include '404.php';
});

// ============================================================
// DISPATCH ROUTER & HANDLE RESPONSE
// ============================================================

$isApiRequest = str_starts_with(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/api/')
    || (($_SERVER['HTTP_ACCEPT'] ?? '') && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

try {
    $response = $router->dispatch();

    // If callback returned structured response data, send JSON consistently
    if (is_array($response)) {
        $statusCode = (int)($response['code'] ?? $response['status'] ?? 200);
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');

        // Normalize payload
        if (!isset($response['success'])) {
            $response['success'] = $statusCode >= 200 && $statusCode < 300;
        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // If API endpoint returned no body, return a valid JSON object
    if ($isApiRequest && $response === null) {
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'message' => 'Request completed',
            'code' => 200
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
} catch (Throwable $e) {
    $statusCode = 500;
    http_response_code($statusCode);

    if ($isApiRequest) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'Internal server error',
            'error' => $e->getMessage(),
            'code' => $statusCode
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo '<h1>500 - Internal Server Error</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    exit;
}

// If response is an array (JSON API response), output as JSON
if (is_array($response)) {
    header('Content-Type: application/json');
    echo json_encode($response);
}
