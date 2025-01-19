<?php

Router::apiGet('/banks', function($params) {
  header('Content-Type: application/json');
  return json_encode(['banks' => []]);
});

?>
