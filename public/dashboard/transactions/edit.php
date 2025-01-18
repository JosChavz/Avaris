<?php

global $session;

use partials\TransactionFormPartial;
use partials\BreadcrumbPartial;
use classes\Transaction;

$title = "Transaction | Edit";

if (is_post_request()) {
  $args = $_POST['transaction'];
  $args['uid'] = $session->get_user_id();
  $args['id'] = $transaction->id;
  $args['created_at'] = $transaction->created_at;
  $transaction = new Transaction($args);

  if (empty($transaction->errors)) {
    if ($transaction->save()) {
      $session->add_message("Successfully edited transaction");
      h("/dashboard/transactions/");
      die();
    } else {
      $session->add_errors($transaction->errors);
    } 
  } else {
    $session->add_errors($transaction->errors);
  }
}

ob_start();
?>
<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Transactions',
  'url'   => '/dashboard/transactions/',
], [
  'name' => 'Edit',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Update Transaction</h1>
</div>

<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <section class="bg-white dark:bg-gray-900">
  <?php
    echo TransactionFormPartial::render_create_form($transaction, $transaction->type, false);
  ?>
  </section>
</div>

<?php 
  $content = ob_get_clean();
  require_once(TEMPLATE_DASHBOARD);
?>
