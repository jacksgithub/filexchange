<?php
require '.cfg.php'; // UPLOAD_PATH

$moved         = false;                                     // Initialize
$message       = '';                                        // Initialize
$error         = 'Could not upload file.';                  // Initialize
$upload_path   = UPLOAD_PATH;                               // Upload path
$max_size      = 15728640; // 15MB; 5MB = 5242880;          // Max file size
$allowed_types = ['application/zip', 'application/pdf'];    // Allowed file types
$allowed_exts  = ['zip', 'pdf'];                            // Allowed file extensions

function create_filename($filename, $upload_path)              // Function to make filename
{
  $basename   = pathinfo($filename, PATHINFO_FILENAME);      // Get basename
  $extension  = pathinfo($filename, PATHINFO_EXTENSION);     // Get extension
  $basename   = preg_replace('/[^A-z0-9]/', '-', $basename); // Clean basename
  $clean_filename = $basename . '.' . $extension;
  $i          = 0;                                         // Counter
  while (file_exists($upload_path . $clean_filename)) {    // If file exists
    $i        = $i + 1;                                    // Update counter 
    $clean_filename = $basename . $i . '.' . $extension;   // New filepath
  }
  return $clean_filename;                                  // Return filename
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_FILES['upfile']) {  // If form submitted
  $error = ($_FILES['upfile']['error'] === 1) ? 'too big ' : '';  // Check size error

  if ($_FILES['upfile']['error'] == 0) {                          // If no upload errors
    $error  .= ($_FILES['upfile']['size'] <= $max_size) ? '' : 'too big '; // Check size
    // Check the media type is in the $allowed_types array
    $type   = mime_content_type($_FILES['upfile']['tmp_name']);
    $error .= in_array($type, $allowed_types) ? '' : 'wrong type ';
    // Check the file extension is in the $allowed_exts array
    $ext    = strtolower(pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION));
    $error .= in_array($ext, $allowed_exts) ? '' : 'wrong file extension ';

    // If there are no errors create the new filepath and try to move the file
    if (!$error) {
      $filename    = create_filename($_FILES['upfile']['name'], $upload_path);
      $destination = $upload_path . $filename;
      $moved       = move_uploaded_file($_FILES['upfile']['tmp_name'], $destination);
    }
  }
  if ($moved === true) {                                            // If it moved
    $message = 'Success! Uploaded: ' . $filename;   // Show upfile
  } else {                                                          // Otherwise
    $error = 'Error! Could not upload file: ' . $error;         // Show errors
  }
}

if ($message) {
  header("Location: index.php?message={$message}");
  exit;
} else {
  header("Location: index.php?error={$error}");
}
