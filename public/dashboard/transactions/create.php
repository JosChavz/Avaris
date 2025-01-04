<?php

global $session;

$title = "Transaction | Create";
ob_start();

use classes\Transaction;
use classes\Bank;
use enums\TransactionType;
use partials\TransactionFormPartial;

$transaction = new Transaction();

if (is_post_request()) {
  var_dump($_POST['transaction']);
  $transaction = new Transaction($_POST['transaction']);

  if (empty($transaction->errors)) {
  
  } else {
    $session->add_errors($transaction->errors);
  }
}

?>
<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Transaction</h1>
</div>

<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <section class="bg-white dark:bg-gray-900">
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
            <li class="me-2" role="presentation">
              <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Expense</button>
            </li>
            <li class="me-2" role="presentation">
              <button 
                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                id="dashboard-tab" 
                data-tabs-target="#dashboard" 
                type="button" 
                role="tab" 
                aria-controls="dashboard" 
                aria-selected="false">Income</button>
            </li>
        </ul>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <?php
          echo TransactionFormPartial::render_create_form($transaction, TransactionType::EXPENSE);
        ?>
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
        <?php
          echo TransactionFormPartial::render_create_form($transaction, TransactionType::INCOME);
        ?>
        </div>
    </div>
    
  </section>
</div>

<?php

$content = ob_get_clean();
require_once(ROOT . "src/templates/dashboard-template.php");

?>
