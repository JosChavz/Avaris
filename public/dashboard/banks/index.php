<?php

global $session;
use classes\Transaction;
use classes\Bank;
use partials\BankRowPartial;

$title = "Banks";
$banks = Bank::find_by_user_id($session->get_user_id());

ob_start();
?>

<div class="mb-14">
  <h1 class="mb-2 text-4xl font-bold text-gray-900 dark:text-white">Banks</h1>
</div>

<!-- Bank Table  -->
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <!-- Card header -->
  <div class="items-center justify-between lg:flex">
    <div class="items-center sm:flex w-full">
      <a href="./create" 
        class="mr-auto text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800"> 
          Add new bank
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
                  Type
                </th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                  Month&#39;s Spending
                </th>
                <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                  Status
                </th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800">
            <?php 
              foreach($banks ?? [] as $bank) {
                $sum = Transaction::select_summation($session->get_user_id(), [], array(
                  "bank_id" => $bank->id,
                  "year"    => date('Y'),
                  "month"   => date('m'),
                ));
                echo BankRowPartial::render_row($bank, $sum); 
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
