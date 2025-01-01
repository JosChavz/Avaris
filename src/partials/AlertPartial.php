<?php

namespace partials;

class AlertPartial {

  static function render_message(string $title, string $message) : string {
    ob_start();
    ?>
    <div 
      class="bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30 mb-8" 
      role="alert" 
      tabindex="-1" 
      aria-labelledby="hs-bordered-success-style-label">
      <div class="flex">
        <div class="shrink-0">
          <!-- Icon -->
          <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
              <path d="m9 12 2 2 4-4"></path>
            </svg>
          </span>
          <!-- End Icon -->
        </div>
        <div class="ms-3">
          <h3 id="hs-bordered-success-style-label" class="text-gray-800 font-semibold dark:text-white my-0">
            Success
          </h3>
          <p class="text-sm text-gray-700 dark:text-neutral-400">
            <?php echo $message; ?>
          </p>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean();
  }

  static function render_errors(string $title, array $errors) : string {
    ob_start();
    ?>
    <div 
      class="bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-800/10 dark:border-red-900 dark:text-red-500 mb-8" 
      role="alert" 
      tabindex="-1" 
      aria-labelledby="hs-with-list-label">
      <div class="flex">
        <div class="shrink-0">
          <svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="m15 9-6 6"></path>
            <path d="m9 9 6 6"></path>
          </svg>
        </div>
        <div class="ms-4">
          <h3 id="hs-with-list-label" class="text-sm font-semibold my-0">
            <?php echo $title; ?>
          </h3>
          <div class="mt-2 text-sm text-red-700 dark:text-red-400">
            <ul class="list-disc space-y-1 ps-5">
              <?php foreach ($errors as $error) : ?>
                <li><span> <?php echo $error ?> </span></li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php
    return ob_get_clean(); 
  }

}

?>
