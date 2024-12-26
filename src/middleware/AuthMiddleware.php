<?php

global $session;

use Middleware\BaseMiddleware;

function authMiddleware($request, $next) {
    // Define protected routes and required roles
    $protectedRoutes = [
        '/dashboard' => [UserRoles::USER],
        '/admin' => [UserRoles::ADMIN]
    ];

    // Get the requested path
    $path = parse_url($request['REQUEST_URI'], PHP_URL_PATH);

    // Check if the route is protected
    if (array_key_exists($path, $protectedRoutes)) {
        // Mock: Extract user role (replace with real logic)
        $userRole = $session->get_user_role();

        // Check if the user has the required role
        if (!$userRole || !in_array($userRole, $protectedRoutes[$path])) {
            http_response_code(403);
            echo "Forbidden: You do not have access to this resource.";
            return null; // Stop further processing
        }
    }

    // Proceed to the next middleware or final handler
    return $next($request);
}

?>
