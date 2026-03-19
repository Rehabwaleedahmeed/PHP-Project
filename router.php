<?php
// Built-in PHP server router
// This file routes all requests to index.php

// Resolve URL path safely (without query string) for static file handling
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestPath = parse_url($requestUri, PHP_URL_PATH) ?: '/';
$candidatePath = realpath(__DIR__ . DIRECTORY_SEPARATOR . ltrim(urldecode($requestPath), '/'));
$projectRoot = realpath(__DIR__);

// If the requested path is a real file inside project root, let PHP serve it
if (
    $candidatePath !== false
    && $projectRoot !== false
    && str_starts_with($candidatePath, $projectRoot)
    && is_file($candidatePath)
) {
    return false;
}

// Otherwise, route to index.php
require_once __DIR__ . '/index.php';
