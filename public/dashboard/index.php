<?php

global $session;

use classes\Budget;
use classes\Transaction;
use partials\BudgetTrakPartial;
use partials\TransactionRowPartial;

$title = "Dashboard";
$user_id = $session->get_user_id();

$month = (int)date('m');
$year = (int)date('Y');

$monthly_budget = Budget::find_by_id_auth($session->get_monthly_budget_id(), $user_id);
$budgets = Budget::find_budgets($user_id);
$transactions = Transaction::find_by_user_id(
  $user_id,
  array(
    "month"   => $month,
    "year"    => $year,
    "limit"  => 5,
  )
);
$monthly_sum = Transaction::select_summation($user_id, [], [ 'month' => $month, 'year' => $year ]);

$extra_deps = array('<script type="module" src="/js/yearlychart.min.js"></script>');

ob_start();
?>
<div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3">
  <!-- Main widget -->
  <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="flex items-center justify-between">
      <div class="flex-shrink-0">
        <span class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">$<?php echo number_format($monthly_sum, 2); ?></span>
        <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Transactions this month</h3>
      </div>
      <!--<div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400">
        12.5%
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
            clip-rule="evenodd"></path>
        </svg>
      </div>-->
    </div>
    <div id="yearly-chart"></div>
  </div>
  <!--Tabs widget -->
  <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <h3 class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white">Mothly Budget</h3>
    <?php echo BudgetTrakPartial::render_progress($monthly_budget, $monthly_sum); ?>
    
    <?php 
      foreach ($budgets ?? [] as $budget) :
    ?>  
      <h3 class="flex items-center text-lg font-semibold text-gray-900 dark:text-white"><?php echo $budget->name?></h3>
      <span class="text-sm text-slate-500 mb-4">Ends <?php echo (Datetime::createFromFormat('Y-m-d', $budget->to_date))->format('m/d/Y'); ?></span>
    <?php
        $curr_sum = Transaction::select_summation($user_id, [], [ 'budget_id' => $budget->id ]);
        echo BudgetTrakPartial::render_progress($budget, $curr_sum);
      endforeach;
    ?>
  </div>
</div>

<!-- Table -->
<div class="flex flex-col mt-6">
  <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
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
              foreach ($transactions as $transaction) {
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
  require_once(ROOT . "/src/templates/dashboard-template.php");
?>
