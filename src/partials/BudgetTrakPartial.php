<?php
namespace partials;

use classes\Budget;

// Ode to BudgetTrak

class BudgetTrakPartial {

  /***
   * Renders the progress of a budget
   * @param Budget $budget    The Budget to render :p
   * @param float  $curr_sum  The current sum to the budget
   * @return string The progress partial
   **/
  public static function render_progress(Budget $budget, float $sum) : string {
    $progress = ($sum / $budget->max_amount) * 100;
    if ($progress > 100) $progress = 100;
    ob_start();
  ?>
  <div>
    <div class="flex justify-between mb-1">
      <span class="text-base font-medium text-blue-700 dark:text-white">$<?php echo number_format($sum, 2) ?></span>
      <span class="text-sm font-medium text-blue-700 dark:text-white">$<?php echo number_format($budget->max_amount, 2) ?></span>
    </div>
    <div class="w-full h-6 bg-gray-200 rounded-full mb-8 dark:bg-gray-700">
      <div class="h-6 bg-green-600 rounded-full dark:bg-green-500" style="width: <?php echo $progress ?>%"></div>
    </div>
  </div>
  <?php
    return ob_get_clean();
  }

}

?>
