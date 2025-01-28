<?php

use classes\Bank;

Router::apiGet('/banks', function($params) {
  global $session;
  header('Content-Type: application/json');

  if (empty($session->get_user_id())) {
    http_response_code(401);
    return json_encode(['error' => 'Unauthorized']);
  }

  $banks = Bank::find_by_user_id( $session->get_user_id() );
  return json_encode(['banks' => $banks]);
});

?>
