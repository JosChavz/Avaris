<?php

namespace partials;

use classes\Budget;
use \DateTime;

class BudgetRowPartial {

  /***
   * Renders the row for a budget
   * @param Budget  $budget         The budget to render
   * @param float   $current_sum    The summation of the budget
   * @param bool    $render_actions Whether it should have the options to [edit, view, delete, etc.]
   *
   * @return string 
   ***/
  static public function render_row(Budget $budget, float $current_sum, bool $render_actions=true) : string {
    ob_start();
  ?>
  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
      <td class="py-4 px-2 inline-flex items-center space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
        <?php echo $budget->name ?>
      </td>
      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
        <?php echo "$" . number_format($current_sum, 2) ?>
      </td>
      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
        <?php echo "$" . number_format($budget->max_amount, 2) ?>
      </td>
      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
        <?php 
          $temp_date = DateTime::createFromFormat('Y-m-d', $budget->from_date);
          echo $temp_date->format('m/d/Y');
        ?>
      </td>
      <td class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white">
        <?php 
          $temp_date = DateTime::createFromFormat('Y-m-d', $budget->to_date);
          echo $temp_date->format('m/d/Y');
        ?>
      </td>
      <?php if ($render_actions) : ?>
        <td class="p-4 whitespace-nowrap justify-end">
          <button id="budget_<?php echo $budget->id ?>-dropdown-button" data-dropdown-toggle="budget_<?php echo $budget->id; ?>-dropdown" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
            </svg>
          </button>
          <div 
            id="budget_<?php echo $budget->id ?>-dropdown" 
            class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" 
                aria-labelledby="budget_<?php echo $budget->id; ?>-dropdown-button">
                  <li>
                    <a href="/dashboard/budgets/view/<?php echo $budget->id; ?>" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View</a>
                  </li>
              </ul>
              <div class="py-1">
                <a href="/dashboard/budgets/delete/<?php echo $budget->id; ?>" class="block py-2 px-4 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
              </div>
          </div>
        </td>
      <?php endif; ?>
    </tr>
  <?php
    return ob_get_clean();
  }

}

?>
