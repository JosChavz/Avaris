<?php

namespace partials;

use enums\TransactionType;
use classes\Transaction;
use enums\ExpenseType;

class TransactionFormPartial {
  
  /***
   * Only to be used in the `create.php` page
   * @param Transaction $transaction
   * @param TransactionType $type The type of transaction to which will determine which
   *                                  form to use - and will also be used for unique IDs
   * @param Bank[] $banks Array of user banks for options
   * @param Budget[] $budgets Array of user budgets that are still open
   * @param boolean $create Will point to the `./create.php` page if it's meant to create;
   *                                  Otherwise, send to the `./edit.php` page
   * @param array $args Extra arguments mainly due to _GET requests : {
   *                                    budget_id: string
   *                                    bank_id: string
   *                                  }
   *                                  Note: A _POST data will take priority than a _GET query
   * @return string Template that was requested to render for CREATE/UPDATE actions with
   *                any prefilled data if `$args` is present
   *
   */
  public static function render_create_form(Transaction $transaction, TransactionType $type, array $banks, array $budgets, bool $create=true, array $args=[]) : string {
    $selected_bank_id = $transaction->bid ?? $args['bank_id'] ?? null;
    $selected_budget_id = $transaction->budget_id ?? $args['budget_id'] ?? null;

    $action_url = '/dashboard/transactions/' . (($create) ? 'create' : 'edit/' . $transaction->id);
    ob_start();
  ?>
    <!-- Process the document in the same page -->
    <form action="<?php echo $action_url ?>" method="POST">
      <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name<span class="text-red-700">*</span></label>
          <input 
              required
              type="text" 
              name="transaction[name]" 
              id="<?php echo $type->value ?>_name"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
              value="<?php echo $transaction->name ?? '' ?>" 
              placeholder="Type transaction name">
        </div>
        <div>
          <label for="<?php echo $type->value ?>_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                    </svg>
                </div>
                <input datepicker
                       id="<?php echo $type->value ?>_from-date"
                       name="transaction[logged_date]"
                       datepicker-title="From Date"
                       data-date="<?php
                         echo date('m-d-Y');
                       ?>"
                       value="<?php
                        if (isset($transaction->logged_date)) {
                            echo date('m-d-Y', strtotime($transaction->logged_date));
                        } else {
                          echo date('m-d-Y');
                        }
                       ?>"
                       datepicker-format="mm-dd-yyyy"
                       type="text"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Select date">
            </div>
        </div>
        <div class="w-full <?php if ($type == TransactionType::INCOME) echo "col-span-2"; ?>">
            <label for="<?php echo $type->value ?>_amount"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Price<span class="text-red-700">*</span>
            </label>
            <input type="number" 
              name="transaction[amount]" 
              id="<?php echo $type->value ?>_amount"
              step=".01"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
              value="<?php echo $transaction->amount ?? '' ?>" 
              placeholder="299.99" 
              required>
        </div>
      <?php if ($type == TransactionType::EXPENSE) : ?>
        <div>
          <label for="<?php $type->value ?>_category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category<span class="text-red-700">*</span></label>
          <select
              id="<?php echo $type->value ?>_category"
              name="transaction[category]"
              class="bg-gray-50 border border-gray-300 text-gray-900 capitalize text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <?php foreach (ExpenseType::cases() as $t) : ?>
              <option 
                <?php echo ((isset($transaction->category) && $transaction->category === $t)) ? 'selected' : null; ?>
                value="<?php echo $t->value ?>">
                  <?php echo $t->value; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        
        <!-- Bank Selection -->
        <div>
          <label for="<?php echo $type->value ?>_banks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bank (optional)</label>
          <select id="<?php $type->value ?>_banks"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            name="transaction[bid]" >
            <option value="">Cash</option>
          <?php foreach($banks as $bank) : ?>
            <option 
              <?php echo ((isset($selected_bank_id) && ($selected_bank_id== $bank->id)) ? "selected" : "")  ?>
              value="<?php echo $bank->id ?>"><?php echo $bank->name ?></option>
          <?php endforeach; ?>
          </select>
        </div>

        <!-- Budget Selection -->
        <div>
          <label for="<?php echo $type->value ?>_banks" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget (optional)</label>
          <select id="<?php echo $type->value ?>_banks"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            name="transaction[budget_id]" >
            <option value="">---None---</option>
          <?php foreach($budgets as $budget) : ?>
            <option 
              <?php echo ((isset($selected_budget_id) && ($selected_budget_id == $budget->id)) ? "selected" : "")  ?>
              value="<?php echo $budget->id ?>"><?php echo $budget->name ?></option>
          <?php endforeach; ?>
          </select>
        </div>
      <?php endif;  ?>
        <div class="sm:col-span-2">
            <label for="<?php $type->value ?>_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea id="<?php $type->value ?>_description"
              name='transaction[description]'
              rows="8" 
              value="<?php echo $transaction->description ?? ''; ?>"
              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
              placeholder="Write a description here..."><?php echo $transaction->description ?? '' ?></textarea>
        </div>
      </div>
      <input type="hidden" id="<?php echo $type->value ?>_hidden" name="transaction[type]" value="<?php echo $type->value; ?>">
      <div class="flex items-center space-x-4">
        <button 
          type="submit" 
          class="text-white bg-primary-700 hover:!bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            <?php echo (($create) ? 'Create' : 'Update') . ' Transaction' ?>
        </button>
        <button 
          type="reset" 
          class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Reset
        </button>
      </div>
    </form>
  <?php
    return ob_get_clean();
  }

}

?>
