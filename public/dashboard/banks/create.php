<?php

global $session;

use partials\BreadcrumbPartial;
use partials\BankFormPartial;
use classes\Bank;
use enums\BankType;

$title = "Banks | Create";

$bank = new Bank();

if (is_post_request()) {
  $args = $_POST['bank'];
  $args['uid'] = $session->get_user_id();
  $bank = new Bank($args);

  if (empty($bank->errors)) {
    if ($bank->save()) {
      $session->add_message("Successfully added bank!");
      h("/dashboard/banks");
      exit();
    } else {
      $session->add_errors($bank->errors);
    }
  } else {
    $session->add_errors($bank->errors);
  }
}


ob_start();
?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Banks',
  'url'   => '/dashboard/banks/',
], [
  'name' => 'Create',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Bank</h1>
</div>

<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <?php echo BankFormPartial::render_form($bank) ?>
</div>

<?php 
$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);

?>
