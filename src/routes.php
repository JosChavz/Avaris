<?php

use enums\UserRoles;

// Define your routes
Router::get('/dashboard', function($params) {
  global $session;

  // Must be logged-in and a user
  if (!$session->is_logged_in() || $session->get_user_role() != UserRoles::USER) {
    h("/auth/login");
    die();
  }

  require_once ROOT . '/public/dashboard/index.php';
});

Router::get('/auth/login', function($params) {
    require_once ROOT . '/public/auth/login.php';
});

Router::get('/', function($params) {
  global $session;

  // Redirect to dashboard
  if ($session->is_logged_in()) {
    h("/dashboard");
    die(); 
  }

  require_once ROOT . '/public/index.php';
});

// Add more routes as needed
//
?>
