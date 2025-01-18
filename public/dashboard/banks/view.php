<?php

global $session;

use partials\BreadcrumbPartial;

$title = "Banks | View";
ob_start();
?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Transactions',
  'url'   => '/dashboard/banks/',
], [
  'name' => 'View',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">View Bank</h1>
</div>


<?php 

$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);

?>
