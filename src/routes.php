<?php

use enums\UserRoles;
use classes\Transaction;
use classes\Bank;
use classes\Budget;

function user_redirect_dashboard() {
  global $session;

  // Redirect to dashboard
  if ($session->is_logged_in()) {
    h("/dashboard/");
    die(); 
  }
}

function is_users_transaction($obj_id) : Transaction {
  global $session;
  
  $res = Transaction::find_by_id_auth($obj_id, $session->get_user_id());
  if ($res == null) {
    $session->add_error("Sorry but that ID does not exist!");
    h("/dashboard/");
    die();
  }

  return $res;
}

function is_users_bank($obj_id) : Bank {
  global $session;
  
  $res = Bank::find_by_id_auth($obj_id, $session->get_user_id());
  if ($res == null) {
    $session->add_error("Sorry but that ID does not exist!");
    h("/dashboard/");
    die();
  }

  return $res;
}

function is_users_budget($obj_id) : Budget {
  global $session;
  
  $res = Budget::find_by_id_auth($obj_id, $session->get_user_id());
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
  $transaction = is_users_transaction($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/view.php';
});

Router::get('/dashboard/transactions/edit/:id', function($params) {
  $transaction = is_users_transaction($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/edit.php';
});

Router::post('/dashboard/transactions/edit/:id', function($params) {
  $transaction = is_users_transaction($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/edit.php';
});

Router::get('/dashboard/transactions/delete/:id', function($params) {
  $transaction = is_users_transaction($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/delete.php';
});

Router::post('/dashboard/transactions/delete/:id', function($params) {
  $transaction = is_users_transaction($params['id']);
  extract(['transaction' => $transaction]);
  require_once ROOT . '/public/dashboard/transactions/delete.php';
});

Router::get('/dashboard/banks/view/:id', function($params) {
  $bank = is_users_bank($params['id']);
  extract(['bank' => $bank]);
  require_once ROOT . '/public/dashboard/banks/view.php';
});

Router::get('/dashboard/banks/edit/:id', function($params) {
  $bank = is_users_bank($params['id']);
  extract(['bank' => $bank]);
  require_once ROOT . '/public/dashboard/banks/edit.php';
});

Router::post('/dashboard/banks/edit/:id', function($params) {
  $bank = is_users_bank($params['id']);
  extract(['bank' => $bank]);
  require_once ROOT . '/public/dashboard/banks/edit.php';
});

Router::get('/dashboard/banks/delete/:id', function($params) {
  $bank = is_users_bank($params['id']);
  extract(['bank' => $bank]);
  require_once ROOT . '/public/dashboard/banks/delete.php';
});

Router::post('/dashboard/banks/delete/:id', function($params) {
  $bank = is_users_bank($params['id']);
  extract(['bank' => $bank]);
  require_once ROOT . '/public/dashboard/banks/delete.php';
});

Router::get('/dashboard/budgets/view/:id', function($params) {
  $budget = is_users_budget($params['id']);
  extract(['budget' => $budget]);
  require_once ROOT . '/public/dashboard/budgets/view.php';
});

Router::get('/dashboard/budgets/delete/:id', function($params) {
  $budget = is_users_budget($params['id']);
  extract(['budget' => $budget]);
  require_once ROOT . '/public/dashboard/budgets/delete.php';
});

Router::post('/dashboard/budgets/delete/:id', function($params) {
  $budget = is_users_budget($params['id']);
  extract(['budget' => $budget]);
  require_once ROOT . '/public/dashboard/budgets/delete.php';
});

?>
