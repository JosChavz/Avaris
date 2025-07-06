<?php
global $session;

use partials\BudgetRowPartial;
use partials\BreadcrumbPartial;

if (empty($budget)) {
    $session->add_error("That budget does not exist.");
    h('/dashboard/budgets/');
    die();
}

$title = "Budget | Delete";

if(is_post_request()) {
  if ($budget->remove()) {
    $session->add_message("Budget removed.");
    h("/dashboard/budgets");
    die();
  } else {
    $session->add_error("Unable to remove budget.");
  }
} else {
	$session->add_error("Unable to remove budget.");
}

ob_start();

?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Budgets',
  'url'   => '/dashboard/budgets/',
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
       <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
        Name
      </th>
      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
        Current Spending  
      </th>
      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
        Max Spending 
      </th>
      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
        From Date
      </th>
      <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
        To Date
      </th>
      </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-800">
    <?php 
      echo BudgetRowPartial::render_row($budget, 0, false); 
    ?>
    </tbody>
  </table>

  <form method="POST" action="/dashboard/budgets/delete/<?php echo $budget->id; ?>" >
    <input 
      class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" 
      type="submit" aria-label="delete this transaction" value="Delete Budget">
  </form>
</article>

<?php
$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);
?>
