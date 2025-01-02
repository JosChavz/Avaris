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
</head>
<body class="<?php echo $bg_color ?? "" ?>">
  <?php include_once "header.php" ?>
  <div class="container mx-auto my-12 px-4">
    <?php if (count($errors)) echo AlertPartial::render_errors("Error", $errors); ?>
    <?php if ($message) echo AlertPartial::render_message("Success", $message); ?>
    <?php echo $content ?? ""?>
  </div>
  <?php include_once "footer.php" ?>
</body>
</html>
