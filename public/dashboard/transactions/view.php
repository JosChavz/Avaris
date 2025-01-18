<?php

use enums\TransactionType;
use partials\BreadcrumbPartial;

global $session;

$title = "Transaction | View";
$extra_deps = [
  "<style>@import url('https://fonts.googleapis.com/css2?family=MonteCarlo&display=swap');</style>",
  '<link rel="stylesheet" href="/styles/font.min.css">'
];
ob_start();
?>

<?php echo BreadcrumbPartial::render_breadcrumb(array([
  'name'  => 'Transactions',
  'url'   => '/dashboard/transactions/',
], [
  'name' => 'View',
])); ?>

<div class="mb-8">
  <h1 class="text-2xl font-bold text-gray-900 dark:text-white">View Transaction</h1>
</div>

<article class="relative p-4 max-w-screen-sm m-auto bg-white rounded-lg !rounded-b-none shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="flex gap-4 mb-4">
      <span class="text-sm text-slate-600 dark:text-slate-400"><?php echo (new \DateTimeImmutable($transaction->created_at))->format('M d Y H:s') ?></span>
    </div>

    <div class="flex gap-4 items-center justify-between mb-4">
      <div class="flex gap-2 items-center">
        <?php if ($transaction->type == TransactionType::EXPENSE) : ?>
            <?php echo $transaction->category->icon(); ?>
        <?php endif; ?>
        <h2 class="font-bold text-2xl"><?php echo html($transaction->name); ?></h2>
      </div>
      <div class="flex gap-2 items-center">
        <?php echo $transaction->type->icon() ?>
        <span class="font-bold">
          $<?php echo $transaction->amount ?> 
        </span>
      </div>
    </div>

    <div class="flex justify-between items-center">
      <span class="text-sm font-bold">PAYMENT METHOD:</span>
      <span><?php echo $transaction->bid ?? 'Cash' ?></span>
    </div>

    <p class="text-sm mt-10 mb-10"><span class="italic text-sm">Notes:</span><br><?php echo html($transaction->description) ?></p>

    <div class="w-60 border-b border-gray-500 m-auto">
      <span class="mr-2">x</span>
      <span class="text-4xl monteCarlo"><?php echo $session->get_user_name(); ?></span>
    </div>

    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
    <div class="m-auto w-4/7">
      <img class="m-auto" src="/images/transaction-qr.svg" width="100px" />
      <p class="text-center">Thank You!<br>Please Come Again!</p>
    </div>
    <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

    <div class="flex flex-col mt-4">
      <span class="text-sm text-slate-300 dark:text-slate-500">Updated at <?php echo (new \DateTimeImmutable($transaction->updated_at))->format('M d Y H:s') ?></span>
    </div>

    <!-- Torn paper effect -->
    <div class="absolute -bottom-4 left-0 w-full overflow-hidden z-10">
        <div class="flex justify-between" style="height: 16px;">
            <?php for($i = 0; $i < 40; $i++) : ?>
                <div class="bg-white dark:bg-gray-800" style="width: 20px; height: 16px; clip-path: polygon(0 0, 100% 0, 50% 100%);"></div>
            <?php endfor; ?>
        </div>
    </div>
    <div class="absolute w-full -bottom-4 right-0 h-4 bg-gradient-to-b from-gray-200/60 to-transparent dark:from-gray-500/60"></div>
</article>

<?php
$content = ob_get_clean();
require_once(TEMPLATE_DASHBOARD);

?>
