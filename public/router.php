<?php

require_once '../src/initialize.php';
require_once ROOT . "/src/middleware/AuthMiddleware.php";

use Middleware\AuthMiddleware;
use enums\UserRoles;

global $session;

class Router {
    private static array $routes = [];
    private static array $protectedDirs = [ 
      array(
        'dir'   => '/dashboard/', 
        'roles' => UserRoles::USER
      ),
      array(
        'dir'   => '/admin/',
        'roles' => UserRoles::ADMIN
      ) 
    ];

    public static function get(string $path, callable $callback) {
        self::$routes['GET'][$path] = $callback;
    }

    public static function post(string $path, callable $callback) {
        self::$routes['POST'][$path] = $callback;
    }

    public static function dispatch(string $uri, string $method = 'GET') {
        // Remove query strings
        $uri = parse_url($uri, PHP_URL_PATH);

        // Normalize directory requests 
        $requestedFile = ROOT . "/public" . $uri;
        if (is_dir($requestedFile) && !str_ends_with($uri, '/') && $uri !== '/') {
            header("Location: $uri/");
            die();
        }

        // Remove trailing slash except for root
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = substr($uri, 0, -1);
        }

        // Check protected directories
        foreach (self::$protectedDirs as $dir) {
            $dirPath = rtrim($dir['dir'], '/');
            if (str_starts_with($uri, $dirPath)) {
                if (!AuthMiddleware::check($dir['roles'])) {
                    header('Location: /auth/login');
                    die();
                }
                break;
            }
        }
  
        // Remove the last character if it's `/`
        if ($uri !== '/' && str_ends_with($uri, '/')) {
          $uri = substr($uri, 0, -1);
        }

        // Check routes
        $routes = self::$routes[$method] ?? [];
        foreach ($routes as $path => $callback) {
          $pattern = self::convertPathToRegex($path);
          // Exact match
          if (preg_match($pattern, $uri, $matches)) {
            $params = self::extractParams($matches);
            $callback($params);
            return true;
          }
        }

        // Check for direct PHP file first
        $requestedFile = ROOT . "public" . $uri;
        if (!is_dir($requestedFile)) {
            // Try with .php extension if not provided
            if (!str_ends_with($uri, '.php')) {
                $requestedFile .= '.php';
            }
            
            if (file_exists($requestedFile)) {
                require_once $requestedFile;
                return true;
            }
        }

        // Check for index.php in directory
        $requestedFile = ROOT . "public" . $uri;
        if (is_dir($requestedFile)) {
            $indexFile = rtrim($requestedFile, '/') . '/index.php';
            if (file_exists($indexFile)) {
                require_once $indexFile;
                return true;
            }
        }

        // Check for direct file match first
        $requestedFile = ROOT . "public" . $uri;
        if (file_exists($requestedFile) && is_file($requestedFile)) {
            // For PHP files, include them
            if (pathinfo($requestedFile, PATHINFO_EXTENSION) === 'php') {
                require_once $requestedFile;
                return true;
            }
            // For other files (css, js, etc), serve directly
            return false;
        }

        return false;
    }

    private static function convertPathToRegex(string $path): string {
        // Convert :param to named capture groups
        $pattern = preg_replace('/\:([a-zA-Z]+)/', '(?P<$1>[^\/]+)', $path);
        return '/^' . str_replace('/', '\/', $pattern) . '$/';
    }

    private static function extractParams(array $matches): array {
        $params = [];
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $params[$key] = $value;
            }
        }
        return $params;
    }
}

// Load routes
require_once ROOT . '/src/routes.php';

// Dispatch the request
if (!Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'])) {
    // If no route matched and it's not a file, show 404
    if (!file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
      http_response_code(404);
      h("/404.php");
      die();
    }
}

?>
