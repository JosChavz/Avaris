<?php

require_once '../src/initialize.php';
require_once ROOT . "/src/middleware/AuthMiddleware.php";

use Middleware\AuthMiddleware;
use enums\UserRoles;

global $session;

class Router {
    private static array $routes = [];
    private static array $apiRoutes = [];
    private static array $protectedDirs = [ 
      array(
        'dir'   => '/dashboard/', 
        'roles' => UserRoles::USER
      ),
      array(
        'dir'   => '/admin/',
        'roles' => UserRoles::ADMIN
      ),
      array(
        'dir'   => '/api/',
        'roles' => [UserRoles::ADMIN, UserRoles::USER]
      ), 
    ];

    public static function get(string $path, callable $callback) {
        self::$routes['GET'][$path] = $callback;
    }

    public static function post(string $path, callable $callback) {
        self::$routes['POST'][$path] = $callback;
    }

    public static function apiGet($path, $callback) {
      self::$apiRoutes['GET'][$path] = $callback;
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
          // Exact match to routes def
          $pattern = self::convertPathToRegex($path);
          if (preg_match($pattern, $uri, $matches)) {
            $params = self::extractParams($matches);
            $callback($params);
            return true;
          }

          // Some routes can be a PHP file
          $pattern = self::convertPathToRegex($path . '.php');
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

    public static function dispatchAPI($uri, $method) {
      global $session;

      // MUST be logged-in for API calls
      if(!$session->is_logged_in()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        return false;
      }

      // Removes '/api'
      $uri = substr($uri, 4);

      // Check routes
      $apiRoutes = self::$apiRoutes[$method] ?? [];
      foreach ($apiRoutes as $path => $callback) {
        // Exact match to routes def
        $pattern = self::convertPathToRegex($path);
        if (preg_match($pattern, $uri, $matches)) {
          header('Content-Type: application/json');
          $params = self::extractParams($matches);
          $result = $callback($params);

          // If result is not already encoded JSON, encode it
          if (!is_string($result) || !is_array(json_decode($result, true))) {
            $result = json_encode($result);
          }

          echo $result;
          return true;
        }
      }

      return false;
    }

    private static function convertPathToRegex(string $path): string {
      // First escape any special regex characters in the path
      $path = preg_quote($path, '/');
      // Then convert our :param markers to regex groups
      // We need to handle the escaped colon from preg_quote
      $pattern = preg_replace('/\\\:([a-zA-Z]+)/', '(?P<$1>[^\/]+)', $path);
      
     return '/^' . $pattern . '$/';
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
require_once ROOT . '/src/apiRoutes.php';

// Dispatch the request
if (strpos($_SERVER['REQUEST_URI'], '/api') === 0) {
  // Handle API routes
  if (!Router::dispatchAPI($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'])) {
    // If no API route matched, return 404 JSON response
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'API endpoint not found']);
    die();
  }
} else {
  if (!Router::dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD'])) {
      // If no route matched and it's not a file, show 404
      if (!file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
        http_response_code(404);
        h("/404.php");
        die();
      }
  }
}
?>
