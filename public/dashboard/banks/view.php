<?php

global $session;

use partials\BreadcrumbPartial;
use partials\TransactionRowPartial;
use classes\Transaction;

$user_id = $session->get_user_id();
$args = array(
  "month" => date("m"),
  "year"  => date("Y"),
);
$transactions = Transaction::select_from_bank($user_id, $bank->id, $args);
$summation = Transaction::select_summation($user_id, [], array(
  "bank_id" => $bank->id,
  ...$args
));

$extra_deps = ["<script type='module' async src='/js/bankgraph.min.js'></script>"];

$title = "Banks | View";
ob_start();
?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Banks',
  'url'   => '/dashboard/banks/',
], [
  'name' => 'View',
])); ?>

<div class="grid gap-4 md:grid-cols-2">
  <!-- Main widget -->
  <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm col-span-2 md:col-span-1 md:row-start-1 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="flex items-center justify-between mb-4">
      <div class="flex-shrink-0">
        <h2 class="text-4xl font-bold leading-none text-gray-900 dark:text-white mb-6"><?php echo $bank->name; ?></h2>
        <div class="flex gap-4 items-end flex-shrink-0">
          <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Monthly Spent</h3>
          <span class="text-xl font-bold leading-none text-gray-900 dark:text-white">$<?php echo number_format($summation, 2); ?></span>
        </div>
      </div>
    </div>

    <!-- Eh, up/down icon -->
    <div class="hidden flex items-center justify-between mb-4 col-span-2 md:col-span-1">
      <div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400">
        12.5%
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
            clip-rule="evenodd"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Donut widget -->
  <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm col-span-2 lg:col-span-1 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="py-6" id="donut-chart"></div>
  </div>
</div>

  <a href="/dashboard/transactions/create?bank_id=<?php echo urlencode($bank->id) ?>" 
    class="inline-block my-8 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    Add Transaction
  </a>

  <!-- Table -->
  <div class="flex flex-col mt-6 col-span-2">
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
require_once(TEMPLATE_DASHBOARD);

?>
