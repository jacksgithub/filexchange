<?php
require '.cfg.php'; // UPLOAD_PATH
$files = scandir(UPLOAD_PATH);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FileXchange</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <section>
    <h1>FileXchange - Current Files</h1>
    <?php
    if (count($files) > 2) {
      echo "<ul>";
      foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo "<li>{$file}</li>";
      }
      echo "</ul>";
    }
    ?>
  </section>
</body>

</html>