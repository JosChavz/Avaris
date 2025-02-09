<?php

global $session;

use classes\Budget;
use partials\BreadcrumbPartial;
use partials\BudgetFormPartial;

$title = "Budget | Create";
$extra_deps = ["<script type='module' async src='/js/budgetdate.min.js'></script>"];

$budget = new Budget();

if (is_post_request()) {
  $args = $_POST['budget'];
  $args['uid'] = $session->get_user_id();
  $budget = new Budget($args);

  if (empty($budget->errors)) {
    if ($budget->save()) {
      $session->add_message("Successfully added budget!");
      h("/dashboard/budgets");
      exit();
    } else {
      $session->add_errors($budget->errors);
    }
  } else {
    $session->add_errors($budget->errors);
  }
}


ob_start();
?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Budget',
  'url'   => '/dashboard/budgets/',
], [
  'name' => 'Create',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Budget</h1>
</div>

<div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
  <?php echo BudgetFormPartial::render_form($budget) ?>
</div>

<?php 
$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);

?>
