<?php 

use partials\AlertPartial;

global $session;

$errors = $session->get_errors();
$message = $session->get_message();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $title ?? "Avaris" ?></title>
  <link rel="stylesheet" href="/styles/global.min.css">
  <link rel="stylesheet" href="/styles/dashboard.min.css">
  <link rel="stylesheet" href="/styles/flowbite.min.css">
  <script src='/js/darkmode.min.js' defer></script>
  <script src='/js/flowbite.min.js' defer></script>
  <script src='/js/sidebar.min.js' defer></script>
  <script src='/js/charts.min.js' defer></script>
</head>
<body class="bg-gray-50 dark:bg-gray-800">
  <?php include_once(ROOT . "/src/templates/dashboard-header.php"); ?>
  <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
    <?php include_once(ROOT . "/src/templates/dashboard-aside.php"); ?>
  
    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
      <main class="px-8 py-8 min-h-svh">
        <?php if (count($errors)) echo AlertPartial::render_errors("Error", $errors); ?>
        <?php if ($message) echo AlertPartial::render_message("Success", $message); ?>
        <?php echo $content ?? "" ?>
      </main>

      <!-- Footer would go here -->
    </div>
  </div>
</body>
</html>
