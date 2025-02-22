<?php
namespace partials;
// Ode to BudgetTrak

class BudgetTrakPartial {

  /***
   * Renders the progress of a budget
   * @param Budget $budget    The Budget to render :p
   * @param float  $curr_sum  The current sum to the budget
   * @return string The progress partial
   **/
  public static function render_progress(Budget $budget, float $current_sum) : string {
    $progress = $current_sum / $budget->max_amount;
    ob_start();
  ?>
    <div class="px-8 py-4 rounded-sm">

      <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
        <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?php echo $progress ?>%"></div>
      </div>
    </div>
  <?php
    return ob_get_clean();
  }

}

?>
