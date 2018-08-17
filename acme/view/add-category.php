<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/');//if clientlevel < 2,  send to home page
 exit;
}
?><!DOCTYPE html>
<!--
Add Category View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> ACME Add Category </title>
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
   <h1>Add Category</h1>
   <p id="required">Add a new category of products below.</p>
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>    
   <form id="categories" method="post" action="../products/index.php">
    <ul>
     <li>
      <label for="categoryName">New Category Name</label>
      <input type="text" name="categoryName" id="categoryName" placeholder="Name of new category" required >
     </li>
    </ul>
    <input type="submit" name="submit" id="addCategoryButton" class="button" value="Add Category">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="addCategory">
   </form>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/add-category.php")); ?> </p>
  </footer>
 </body>
</html>


