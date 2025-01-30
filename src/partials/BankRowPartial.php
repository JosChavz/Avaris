<?php

namespace partials;

use classes\Bank;

class BankRowPartial {

  static public function render_row(Bank $bank, float $sum=0) {
    ob_start();
  ?>
  <tr>
      <td class="py-4 px-2 inline-flex items-center space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
        <?php echo $bank->name ?>
      </td>
      <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
        <?php echo $bank->type->value ?>
      </td>
      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
        <?php echo "$" . number_format($sum, 2) ?>
      </td>
      <td class="p-4 whitespace-nowrap justify-end">
        <button id="bank_<?php echo $bank->id ?>-dropdown-button" data-dropdown-toggle="bank_<?php echo $bank->id; ?>-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
          <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
          </svg>
        </button>
        <div 
          id="bank_<?php echo $bank->id ?>-dropdown" 
          class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" 
              aria-labelledby="bank_<?php echo $bank->id; ?>-dropdown-button">
                <li>
                  <a href="/dashboard/banks/view/<?php echo $bank->id; ?>" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                </li>
                <li>
                  <a href="/dashboard/banks/edit/<?php echo $bank->id; ?>" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                </li>
            </ul>
            <div class="py-1">
              <a href="/dashboard/banks/delete/<?php echo $bank->id; ?>" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
            </div>
        </div>
      </td>
    </tr>
  <?php
    return ob_get_clean();
  }

}

?>
