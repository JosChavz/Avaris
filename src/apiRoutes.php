<?php

/***
 * APIs are already protected by requiring the caller to be logged-in
 * Queries can be found, if they exist, under:
 *  $params[query]
 ***/

use classes\Bank;
use classes\Transaction;

Router::apiGet('/banks', function($params) {
  global $session;
  header('Content-Type: application/json');
  $banks = Bank::find_by_user_id( $session->get_user_id() );
  return json_encode(['banks' => $banks]);
});

/***
 * Gets the summation of transactions
 * Queries: [
 *            month : int
 *            year  : int
 *          ]
 ***/
Router::apiGet('/transactions/sum', function($params) {
  global $session;
  header('Content-Type: application/json');

  if (!is_numeric($params['bid'])) {
    http_response_code(400);
    return ['error' => 'bid must be an integer type'];
  }

  $month = $params['query']['month'] ?? null;
  $year = $params['query']['year'] ?? null;

  if (!is_null($month) && is_numeric($month)) $args['month'] = (int)$month;
  if (!is_null($year) && is_numeric($year)) $args['year'] = (int)$year; 

  $transactions = Transaction::select_all_type_summation($session->get_user_id(), [], $args);
  return json_encode(['transactions' => $transactions]);
});

/***
 * Gets the summation of all expense categories with the associated bank_id
 * Queries: [
 *            month : int
 *            year  : int
 *          ]
 ***/
Router::apiGet('/transactions/sum/:bid', function($params) {
  global $session;
  header('Content-Type: application/json');

  if (!is_numeric($params['bid'])) {
    http_response_code(400);
    return ['error' => 'bid must be an integer type'];
  }

  $month = $params['query']['month'] ?? null;
  $year = $params['query']['year'] ?? null;

  $args = array( "bank_id" => $params['bid'] );
  if (!is_null($month) && is_numeric($month)) $args['month'] = (int)$month;
  if (!is_null($year) && is_numeric($year)) $args['year'] = (int)$year; 

  $transactions = Transaction::select_all_type_summation($session->get_user_id(), [], $args);
  return json_encode(['transactions' => $transactions]);
});

?>
