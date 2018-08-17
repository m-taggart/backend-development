<!DOCTYPE html>
<!--
Product Detail View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title><?php echo $description['invName']; ?> Details | Acme, Inc.</title>
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
   <h1 id="detail-header"><?php echo $description['invName']; ?> Details</h1>
   <?php
   if (isset($detailDisplay)) {
    echo $detailDisplay;
   }
   ?>
   <hr>
   <?php
   if (isset($thumbnailDisplay)) {
    echo $thumbnailDisplay;
   }
   ?>
   <hr>
   <h2 id="reviews">Customer Reviews</h2>
   <p id="required">Please submit your <?php echo $description['invName']; ?> product review below. </p> 
   <div class="alert">
    <?php
    if (isset($_SESSION['message'])) {
     echo $_SESSION['message'];
    }
    ?>
   </div>
   <br>
   <?php
   if (isset($reviews)) {
    echo $reviews;
   }
   ?>  
   <?php
   if (isset($displayReviews)) {
    echo $displayReviews;
   }
   ?>

  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/product-detail.php")); ?> </p>
  </footer>
 </body>
</html>
<?php unset($_SESSION['message']); ?>

