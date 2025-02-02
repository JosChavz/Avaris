<?php

namespace partials;

use classes\Bank;
use enums\BankType;

class BankFormPartial {
  static public function render_form(Bank $bank, bool $create=true) {
    ob_start();
  ?>
    <form method="POST" action="/dashboard/banks/<?php echo (($create) ? "create" : "edit/" . $bank->id) ?>"> 
    <div class="grid gap-4 mb-4 sm:grid-cols-2 sm:gap-6 sm:mb-5">
      <div class="sm:col-span-2 gap-4 flex flex-col">
        <div>
            <label for="name" class="block mb-2 font-bold text-gray-900 dark:text-white">Name</label>
            <input type="text" 
              id="name" 
              name="bank[name]"
              value="<?php echo $bank->name ?? '' ?>"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
              placeholder="Bank of America" required />
        </div>
      </div>
      <div class="sm:col-span-2">
        <fieldset class="gap-4 flex flex-col">
          <legend class="font-bold mb-4 text-gray-900 dark:text-white">Check type of Bank</legend>
          <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
              <input 
                id="bordered-radio-1" 
                type="radio" 
                value="<?php echo BankType::DEBIT->value ?>" 
                <?php echo ((isset($bank->type) && ($bank->type == BankType::DEBIT)) ? "checked" : "")  ?>
                name="bank[type]" 
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="bordered-radio-1" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Debit</label>
          </div>
          <div class="flex items-center ps-4 border border-gray-200 rounded dark:border-gray-700">
              <input 
                id="bordered-radio-2" 
                type="radio" 
                value="<?php echo BankType::CREDIT->value ?>"
                <?php echo ((isset($bank->type) && ($bank->type == BankType::CREDIT)) ? "checked" : "" ) ?>
                name="bank[type]" 
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
              <label for="bordered-radio-2" class="w-full py-4 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Credit</label>
          </div>
        </fieldset>
      </div>

      <div class="flex items-center space-x-4">
        <button 
          type="submit" 
          class="text-white !bg-primary-700 hover:!bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
          <?php echo (($create) ? "Create" : "Update") ?> Bank
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
