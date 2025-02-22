<?php

global $session;

use classes\Transaction;
use classes\Budget;
use partials\BreadcrumbPartial;
use partials\TransactionRowPartial;

$title = "Budget | View";

$budget_transactions = Transaction::select_from_budget_auth($session->get_user_id(), $budget->id);
var_dump($budget_transactions); 

ob_start();

?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Budget',
  'url'   => '/dashboard/budgets/',
], [
  'name' => 'Create',
])); ?>
<div class="mb-14">
  <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">Transactions</h1>
  <span class="text-base font-normal text-gray-500 dark:text-gray-400">This is a list of latest transactions</span>
</div>


<!-- Transaction Table  -->
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <div class="flex flex-col mt-6">
    <div class="overflow-x-auto rounded-lg">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow sm:rounded-lg">
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
                foreach ($budget_transactions ?? [] as $transaction) {
                  echo TransactionRowPartial::render_row($transaction); 
                }
              ?>              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);

?>
