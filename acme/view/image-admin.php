<?php
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<!--
Image Admin View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> Image Management </title>
  <link href="/acme/css/acme.css" type="text/css" rel="stylesheet" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 </head>
 <body>
  <header>
   <div class='logofile'>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
   </div>
   <nav>
    <?php echo $navList; ?>
   </nav>
  </header>
  <main>
   <h1> Image Management </h1>
   <br>
   <p> Welcome to the Image Management page. Please choose one of the options below.</p>
   <h2>Add New Product Image</h2>
   <?php
   if (isset($message)) {
    echo $message;
   }
   ?>
   <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
    <p><label for="invId">Product</label></p><br>
    <?php echo $prodSelect; ?><br><br>
    <p><label>Upload Image:</label></p><br>
    <input type="file" name="file1"><br>
    <br>
    <input type="submit" id="updateButton" class="button" value="Upload">
    <input type="hidden" name="action" value="upload">
   </form>
   <hr>
   <h2>Existing Images</h2>
   <p class="alert">If deleting an image, delete the thumbnail too and vice versa.</p>
   <div id="imageDisplay">
   <?php
   if (isset($imageDisplay)) {
    echo $imageDisplay;
   }
   ?>
   </div>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../uploads/index.php")); ?> </p>
  </footer>
 </body>
</html>
<?php unset($_SESSION['message']); ?>

