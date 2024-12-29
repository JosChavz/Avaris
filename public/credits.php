<?php

require_once("../src/initialize.php");
require_once(ROOT . "/src/partials/credit-list.php");

use partials\CreditListPartial;

$title = "Credits";

ob_start();

?>

<main>
  <h1>Credits</h1>
  <p>This page is dedicated for all the inspiration and UI code from the internet. I can&#39;t really do UI that well, so thanks to the developers who made
this website possible.</p>
  <ul class="my-14 flex gap-8 flex-col">
    <?php 
      echo CreditListPartial::render_item(array(
        "text" => "Flowbite",
        "imageURL" => "https://flowbite.s3.amazonaws.com/brand/logo-light/mark/flowbite-logo.svg",
        "url" => "https://flowbite.com/"
      ));

      echo CreditListPartial::render_item(array(
        "text" => "themesberg/flowbite-admin-dashboard",
        "imageURL" => "https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png",
        "url" => "https://github.githubassets.com/assets/GitHub-Mark-ea2971cee799.png" 
      ));
    ?>
  </ul>
</main>

<?php

$content = ob_get_clean();
require_once(ROOT . "/src/templates/template.php");

?>
