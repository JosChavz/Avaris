<?php

use enums\UserRoles;

function user_redirect_dashboard() {
  global $session;

  // Redirect to dashboard
  if ($session->is_logged_in()) {
    h("/dashboard/");
    die(); 
  }
}

Router::get('/auth/login', function($params) {
  user_redirect_dashboard();  
  require_once ROOT . '/public/auth/login.php';
});

Router::get('/auth/register', function($params) {
  user_redirect_dashboard();  
  require_once ROOT . '/public/auth/register.php';
});

Router::get('/auth/forgot-password', function($params) {
  user_redirect_dashboard();  
  require_once ROOT . '/public/auth/forgot-password.php';
});

Router::get('/', function($params) {
  user_redirect_dashboard();  
  require_once ROOT . '/public/index.php';
});


// Add more routes as needed
//
?>
