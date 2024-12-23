<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $title ?? "Avaris" ?></title>
  <link rel="stylesheet" href="/styles/global.min.css">
  <script src='/js/darkmode.js' defer></script>
</head>
<body class="<?php echo $bg_color ?? "" ?>">
  <?php include_once "header.php" ?>
  <div class="container mx-auto my-12">
    <?php echo $content ?? ""?>
  </div>
  <?php include_once "footer.php" ?>
</body>
</html>
