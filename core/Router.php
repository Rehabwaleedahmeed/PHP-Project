<?php

class Router {
    private $routes = [];
    private $notFoundCallback = null;

    /**
     * Register a GET route
     */
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
        return $this;
    }

    /**
     * Register a POST route
     */
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
        return $this;
    }

    /**
     * Register a PUT route
     */
    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
        return $this;
    }

    /**
     * Register a DELETE route
     */
    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
        return $this;
    }

    /**
     * Set 404 handler
     */
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
        return $this;
    }

    /**
     * Dispatch the current request to appropriate handler
     */
    public function dispatch($uri = null, $method = null) {
        if ($uri === null) {
            $uri = $_SERVER['REQUEST_URI'] ?? '/';
        }
        
        if ($method === null) {
            $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        }

        // Remove query string from URI
        $uri = strtok($uri, '?');
        
        // Remove trailing slash except for root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        // Check for exact match
        if (isset($this->routes[$method][$uri])) {
            return $this->executeRoute($this->routes[$method][$uri]);
        }

        // Check for pattern matching with parameters
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $pattern => $callback) {
                if ($params = $this->matchRoute($pattern, $uri)) {
                    return $this->executeRoute($callback, $params);
                }
            }
        }

        // Route not found
        if ($this->notFoundCallback) {
            return $this->executeRoute($this->notFoundCallback);
        }

        return $this->sendResponse(404, 'Route not found');
    }

    /**
     * Match URI pattern with optional parameters (e.g., /user/{id})
     */
    private function matchRoute($pattern, $uri) {
        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '([a-zA-Z0-9_-]+)', $pattern);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove full match
            return $matches;
        }

        return false;
    }

    /**
     * Execute a route callback
     */
    private function executeRoute($callback, $params = []) {
        if (is_string($callback)) {
            // Format: "ControllerName@methodName"
            list($controller, $method) = explode('@', $callback);
            
            $controllerClass = ucfirst($controller) . 'Controller';
            $controllerFile = __DIR__ . '/../controllers/' . $controllerClass . '.php';
            
            if (!file_exists($controllerFile)) {
                return $this->sendResponse(404, "Controller not found: $controllerClass");
            }

            require_once $controllerFile;
            
            if (!class_exists($controllerClass)) {
                return $this->sendResponse(500, "Class not found: $controllerClass");
            }

            $instance = new $controllerClass();
            
            if (!method_exists($instance, $method)) {
                return $this->sendResponse(500, "Method not found: $method");
            }

            // Call method with parameters
            return call_user_func_array([$instance, $method], $params);
        } elseif (is_callable($callback)) {
            return call_user_func_array($callback, $params);
        }

        return $this->sendResponse(500, 'Invalid route callback');
    }

    /**
     * Send a response
     */
    private function sendResponse($code, $message) {
        http_response_code($code);
        return [
            'status' => $code,
            'message' => $message
        ];
    }

    /**
     * Get all registered routes
     */
    public function getRoutes() {
        return $this->routes;
    }
}
?>
