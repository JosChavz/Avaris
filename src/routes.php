<?php

use enums\UserRoles;
use classes\Transaction;

function user_redirect_dashboard() {
  global $session;

  // Redirect to dashboard
  if ($session->is_logged_in()) {
    h("/dashboard/");
    die(); 
  }
}

function is_users_object($obj_id) : Transaction {
  global $session;

  // Redirect to dashboard
  if (!$session->is_logged_in()) {
    h("/login");
    die(); 
  }
  
  $res = Transaction::find_by_id_auth($obj_id, $session->get_user_id());
  if ($res == null) {
    $session->add_error("Sorry but that ID does not exist!");
    h("/dashboard/");
    die();
  }

  return $res;
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

Router::get('/dashboard/transactions/view', function($params) {
  h("/dashboard/transactions");
  die();
});

Router::get('/dashboard/transactions/view/:id', function($params) {
  $transaction = is_users_object($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/view.php';
});

Router::get('/dashboard/transactions/edit/:id', function($params) {
  $transaction = is_users_object($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/edit.php';
});

Router::post('/dashboard/transactions/edit/:id', function($params) {
  $transaction = is_users_object($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/edit.php';
});
// Add more routes as needed
//
?>
