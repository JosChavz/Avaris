<?php

global $session;

use partials\BudgetRowPartial;
use classes\Budget;
use classes\Transaction;

$title = "Budgets";

$budgets = Budget::find_budgets($session->get_user_id());
$archived_budgets = Budget::find_budgets($session->get_user_id(), true);

ob_start();
?>


<div class="mb-14">
  <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">Budgets</h1>
  <span class="text-base font-normal text-gray-500 dark:text-gray-400">Budgets on the go!</span>
</div>

<!-- This Month Budget -->
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">This Month&apos;s Progress</h2>
  <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Want to change your monthly budget?</span>

  <?php // echo BudgetTrakPartial::render_progress(); ?>
</div>

<div class="mt-8 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Current Budgets</h1>
  <span class="text-base font-normal text-gray-500 dark:text-gray-400">Try not to exceed your budgets!!!</span>

  <!-- Card header -->
  <div class="mt-8 items-center justify-between lg:flex">
    <div class="items-center sm:flex w-full">
      <a href="./create" 
        class="mr-auto text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"> 
          Add new budget
      </a>
    </div>
  </div>

  <!-- Table -->
  <div class="flex flex-col mt-6">
    <div class="overflow-x-auto rounded-lg">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow sm:rounded-lg">
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
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
          <?php 
            foreach ($budgets as $budget) {
              $sum = Transaction::select_summation($session->get_user_id(), [], [ 'budget_id' => $budget->id ]);
              echo BudgetRowPartial::render_row($budget, $sum);
            }
            ?>              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="mt-8 p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">Past Budgets</h1>
  <span class="text-base font-normal text-gray-500 dark:text-gray-400">Reflect in what you have done in the past...</span>

  <!-- Card header -->
  <div class="mt-8 items-center justify-between lg:flex">
    <div class="items-center sm:flex w-full">
      <a href="./archive" 
        class="mr-auto text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"> 
          View All Archived Budgets 
      </a>
    </div>
  </div>

  <!-- Table -->
  <div class="flex flex-col mt-6">
    <div class="overflow-x-auto rounded-lg">
      <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden shadow sm:rounded-lg">
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
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
          <?php 
            foreach ($archived_budgets as $budget) {
              $sum = Transaction::select_summation($session->get_user_id(), [], [ 'budget_id' => $budget->id ]);
              echo BudgetRowPartial::render_row($budget, $sum);
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
