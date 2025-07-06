<?php
global $session;

use partials\BreadcrumbPartial;
use partials\TransactionRowPartial;

if (empty($transaction)) {
    $session->add_error('That transaction does not exist.');
    h('/dashboard/transactions');
    die();
}

$title = "Transaction | Delete";
ob_start();

if(is_post_request()) {
  if ($transaction->remove()) {
    $session->add_message("Transaction removed.");
    h("/dashboard/transactions");
    die();
  } else {
    $session->add_error("Unable to remove transaction.");
  }
}

?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Transactions',
  'url'   => '/dashboard/transactions/',
], [
  'name' => 'Delete',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Delete Transaction</h1>
</div>

<article class="p-4 max-w-screen-sm m-auto bg-white rounded-lg !rounded-b-none shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <p class="mb-4">Are you sure you want to delete the following?</p>
  <h2 class="mb-4 text-xl font-bold"><?php echo $transaction->name ?></h2>

  <form method="POST" action="/dashboard/transactions/delete/<?php echo $transaction->id; ?>" >
    <input 
      class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" 
      type="submit" aria-label="delete this transaction" value="Delete Transaction">
  </form>
</article>

<?php
$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);
?>
