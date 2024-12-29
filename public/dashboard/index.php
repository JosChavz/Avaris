<?php

global $session;

$title = "Dashboard";
ob_start();
?>

test

<?php
  $content = ob_get_clean();
  require_once(ROOT . "/src/templates/dashboard-template.php");
?>
