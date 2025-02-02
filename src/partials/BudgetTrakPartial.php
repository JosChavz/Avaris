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
  public static function render_progress(Budget $budget) : string {
    ob_start();
  ?>
  <?php
    return ob_get_clean();
  }

}

?>
