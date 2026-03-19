<?php
/**
 * Router for PHP Built-in Development Server
 * This file routes all requests to index.php for proper routing
 */

// Get the requested path
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requested_file = __DIR__ . $request_uri;

// If it's a real file (not directory), serve it
if (is_file($requested_file)) {
    return false;
}

// If it's a real directory and index.php exists in it, serve that
if (is_dir($requested_file)) {
    if (file_exists($requested_file . '/index.php')) {
        $_SERVER['SCRIPT_FILENAME'] = $requested_file . '/index.php';
        include $requested_file . '/index.php';
        return true;
    }
}

// Route everything else through index.php
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
include __DIR__ . '/index.php';
?>
