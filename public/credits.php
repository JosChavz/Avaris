<?php

use partials\CreditListPartial;

$title = "Credits";

ob_start();

?>

<main>
  <h1 class="text-4xl font-extrabold dark:text-white">Credits</h1>
  <p class="mb-4 pb-0 pt-4 w-3/5 min-w-48  text-lg font-normal text-gray-500 dark:text-gray-400">This page is dedicated for all the inspiration and UI code from the internet. I can&#39;t really do UI that well, so thanks to the developers who made
this website possible.</p>
  <ul class="my-14 flex gap-8 flex-col">
    <?php 
      echo CreditListPartial::render_item(array(
        "text" => "TailwindCSS",
        "imageURL" => 'https://tailwindcss.com/_next/static/media/tailwindcss-mark.3c5441fc7a190fb1800d4a5c7f07ba4b1345a9c8.svg',
        "url" => 'https://tailwindcss.com/'
      ));

      echo CreditListPartial::render_item(array(
        "text" => "Flowbite",
        "imageURL" => "https://flowbite.s3.amazonaws.com/brand/logo-light/mark/flowbite-logo.svg",
        "url" => "https://flowbite.com/"
      ));

      echo CreditListPartial::render_item(array(
        "text" => "themesberg/flowbite-admin-dashboard",
        "imageURL" => "https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png",
        "url" => "https://github.com/themesberg/flowbite-admin-dashboard"
      ));
    ?>
  </ul>
</main>

<?php

$content = ob_get_clean();
require_once(ROOT . "/src/templates/template.php");

?>
