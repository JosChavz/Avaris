<?php

require_once("../src/initialize.php");

$title = "Credits";

ob_start();

?>

<main>
  <h1>Credits</h1>
  <p>This page is dedicated for all the inspiration and UI code from the internet. I can&#39;t really do UI that well, so thanks to the developers who made
this website possible.</p>
  <ul class="my-14">
    <li>
      <a href="https://flowbite.com/" class="flex flex-row gap-2 items-center w-fit">
        <img src="https://flowbite.s3.amazonaws.com/brand/logo-light/mark/flowbite-logo.svg" class="w-[50px]" />
        <span class="text-2xl font-bold">Flowbite</span>
      </a>
    </li>
  </ul>
</main>

<?php

$content = ob_get_clean();
require_once(ROOT . "/src/templates/template.php");

?>
