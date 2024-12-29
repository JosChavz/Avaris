<?php 
require_once(ROOT . "/src/partials/alert.php"); 

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
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
  <script src='/js/darkmode.js' defer></script>
  <script src='/js/sidebar.js' defer></script>
  <script type="module" src='/js/charts.js' defer></script>
</head>
<body class="bg-gray-50 dark:bg-gray-800">
  <?php include_once(ROOT . "/src/templates/dashboard-header.php"); ?>
  <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
    <?php include_once(ROOT . "/src/templates/dashboard-aside.php"); ?>
  
    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
      <main>
        <?php if (count($errors)) echo AlertPartial::render_errors("Error", $errors); ?>
        <?php if ($message) echo AlertPartial::render_message("Success", $message); ?>
        <?php echo $content ?? "" ?>
      </main>

      <!-- Footer would go here -->
    </div>
  </div>

  <script src="<?php echo ROOT; ?>/node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>
