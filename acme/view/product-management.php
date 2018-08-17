<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/');//if clientlevel < 2,  send to home page
 exit;
}
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<!--
Product Management View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> ACME Product Management </title>
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
   <h1> Product Management </h1>
   <p id="required">Welcome to the product management page.
    Please choose an option below.</p>
   <ul class="newLink">
    <li class="newLink"><a class="newLink" href="../products/index.php?action=categories" title="Add a New Category">Add a New Category</a></li>
    <li class="newLink"><a class="newLink" href="../products/index.php?action=inventory" title="Add a New Product">Add a New Product</a></li>   
   </ul>
   <!-- display table of product list-->
   <?php
   if (isset($message)) {
    echo $message;
   } if (isset($prodList)) {
    echo $prodList;
   }
   ?>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/product-management.php")); ?> </p>
  </footer>
 </body>
</html>

<!--Get rid of message after the session-->
<?php unset($_SESSION['message']); ?>


