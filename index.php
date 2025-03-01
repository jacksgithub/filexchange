<?php
$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
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
    <h1>FileXchange</h1>

    <p>Upload a .zip file (a compressed archive file) or a .pdf (Portable Document Format file).</p>

    <?php if ($error) { ?><p class="error"><?= htmlentities($error) ?></p><?php } ?>
    <?php if ($message) { ?><p class="message"><?= htmlentities($message) ?></p><?php } ?>

    <form method="POST" action="upload.php" enctype="multipart/form-data">
      <p>
        <label for="upfile">Select file to upload (max size 15MB): </label>
        <input type="file" name="upfile" accept=".zip,.pdf" id="upfile" required><br>
      </p>
      <p>
        <input type="submit" value="Upload">
      </p>
    </form>
  </section>
</body>

</html>