<?php

namespace partials;

use classes\Budget;
use \DateTime;

class BudgetFormPartial {
  static public function render_form(Budget $budget, bool $create=true) {
    ob_start();
  ?>
    <form method="POST" action="/dashboard/budgets/<?php echo (($create) ? "create" : "edit/" . $budget->id) ?>"> 
    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
      <div class="sm:col-span-2 gap-4 flex flex-col">
        <label for="name" class="block mb-2 font-bold text-gray-900 dark:text-white">Name</label>
        <input type="text" 
          id="name" 
          name="budget[name]"
          value="<?php echo $budget->name ?? '' ?>"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
          placeholder="Japan 2025" required />
      </div>

      <div class="sm:col-span-1 gap-4 flex flex-col">
        <label for="from-date" class="block mb-2 font-bold text-gray-900 dark:text-white">From Date</label>
        <div class="relative max-w-sm">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
          </div>
          <input datepicker 
            id="from-date" 
            name="budget[from_date]"
          <?php
            if (isset($budget->from_date)) {
              $temp_format = DateTime::createFromFormat('Y-m-d H:i:s', $budget->from_date); 
              echo "value='" . $temp_format->format('m/d/Y') . "'";
            }
          ?>
            type="text" 
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="Select date">
        </div>
      </div>
      
      <div class="sm:col-span-1 gap-4 flex flex-col">
        <label for="to-date" class="block mb-2 font-bold text-gray-900 dark:text-white">To Date</label>
        <div class="relative max-w-sm">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
            </svg>
          </div>
          <input datepicker 
            id="to-date" 
            name="budget[to_date]"
          <?php
            if (isset($budget->to_date)) {
              $temp_format = DateTime::createFromFormat('Y-m-d H:i:s', $budget->to_date); 
              echo "value='" . $temp_format->format('m/d/Y') . "'";
            }
          ?>
            type="text" 
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
            placeholder="Select date">
        </div>
      </div>

      <div class="sm:col-span-2 gap-4 flex flex-col">
        <label for="max-amount" class="block mb-2 font-bold text-gray-900 dark:text-white">Max Amount</label>
        <input type="number" 
          id="max-amount" 
          name="budget[max_amount]"
          step="1"
          min="1"
          <?php echo ((isset($budget->max_amount) ? 'value=' . $budget->max_amount : '')) ?>
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
          placeholder="300" required />
      </div>

      <div class="flex items-center space-x-4">
        <button 
          type="submit" 
          class="text-white !bg-primary-700 hover:!bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
          <?php echo (($create) ? "Create" : "Update") ?> Budget
        </button>
        <button 
          type="reset" 
          class="text-red-600 inline-flex items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            Reset
        </button>
      </div>
    </div>
  </form>

  <?php
    return ob_get_clean();
  }
}

?>
