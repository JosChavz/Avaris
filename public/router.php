<?php
require_once '../src/initialize.php';

global $session;

class Router {
    private static array $routes = [];

    public static function get(string $path, callable $callback) {
        self::$routes['GET'][$path] = $callback;
    }

    public static function post(string $path, callable $callback) {
        self::$routes['POST'][$path] = $callback;
    }

    public static function dispatch(string $uri, string $method = 'GET') {
        // Remove query strings
        $uri = parse_url($uri, PHP_URL_PATH);
        if ($uri !== '/' && str_ends_with($uri, '/')) {
          // Remove the last character if it's `/`
          $uri = substr($uri, 0, -1);
        }

        // Check for direct file match first
        $requestedFile = __DIR__ . $uri;
        if (file_exists($requestedFile) && is_file($requestedFile)) {
            // For PHP files, include them
            if (pathinfo($requestedFile, PATHINFO_EXTENSION) === 'php') {
                require_once $requestedFile;
                return true;
            }
            // For other files (css, js, etc), serve directly
            return false;
        }

        // Check routes
        $routes = self::$routes[$method] ?? [];
        foreach ($routes as $path => $callback) {
            $pattern = self::convertPathToRegex($path);
            if (preg_match($pattern, $uri, $matches)) {
                $params = self::extractParams($matches);
                $callback($params);
                return true;
            }
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
  echo 'here';
    // If no route matched and it's not a file, show 404
    if (!file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
        http_response_code(404);
        echo "404 - Not Found";
        h("/404.php");
        die();
    }

  echo 'here';
}

?>
