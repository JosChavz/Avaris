<?php

global $session;

use classes\Transaction;
use classes\Budget;
use partials\BreadcrumbPartial;
use partials\TransactionRowPartial;

$title = "Budgets | View";

$budget_transactions = Transaction::select_from_budget_auth($session->get_user_id(), $budget->id);
$sum = Transaction::select_summation($session->get_user_id(), [], [ 'budget_id' => $budget->id ]);
$progress = ($sum / $budget->max_amount) * 100;
if ($progress > 100) $progress = 100;

ob_start();

?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Budget',
  'url'   => '/dashboard/budgets/',
], [
  'name' => 'View',
])); ?>
<div class="mb-14">
  <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">Transactions</h1>
  <p class="text-base font-normal text-gray-500 dark:text-gray-400">
    <?php echo DateTime::createFromFormat('Y-m-d', $budget->from_date)->format('m/d/Y'); ?> through <?php echo DateTime::createFromFormat('Y-m-d', $budget->to_date)->format('m/d/Y'); ?>
  </p>
</div>

<div>
  <div class="flex justify-between mb-1">
    <span class="text-base font-medium text-blue-700 dark:text-white">$<?php echo number_format($sum, 2) ?></span>
    <span class="text-sm font-medium text-blue-700 dark:text-white">$<?php echo number_format($budget->max_amount, 2) ?></span>
  </div>
  <div class="w-full h-6 bg-gray-200 rounded-full mb-8 dark:bg-gray-700">
    <div class="h-6 bg-green-600 rounded-full dark:bg-green-500" style="width: <?php echo $progress ?>%"></div>
  </div>
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
