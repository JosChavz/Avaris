<?php
global $session;

use partials\BreadcrumbPartial;
use partials\TransactionRowPartial;

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
  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
    <thead class="bg-gray-50 dark:bg-gray-700">
      <tr>
        <th scope="col" class="tracking-wider"></th>
        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Transaction
        </th>
        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Date &amp; Time
        </th>
        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Amount
        </th>
        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Category 
        </th>
        <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
          Status
        </th>
      </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-800">
    <?php 
      echo TransactionRowPartial::render_row($transaction); 
    ?>
    </tbody>
  </table>

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
