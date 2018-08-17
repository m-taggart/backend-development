<?php
//create variable to build dynamic drop-down select menu
$catList = "<select name='categoryId' id='categoryId' required>";
$catList .= "<option value='' selected disabled>Choose a Category</option>";
//categories as category how to pass a name value pair to the controller
foreach ($categories as $category) {
 $catList .= "<option value='$category[categoryId]'";
 if (isset($categoryId)) {
  if ($category['categoryId'] === $categoryId) {
   $catList .= (' selected ');
  }
 }

 $catList .= ">$category[categoryName]</option>";
}
$catList .= '</select>'
?>

<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/');//if clientlevel < 2,  send to home page
 exit;
}
?><!DOCTYPE html>
<!--
Add Product View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> ACME Add Product </title>
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
   <h1> Add Product </h1>
   <p id="required">Add a new product below. All fields are required!</p>
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>

   <form id="inventory" method="post" action="/acme/products/index.php">
    <ul>
     <li>
      <label>Category</label>
      <div 
      <?php
      if (isset($categoryId)) {
       echo $categoryId;
      }
      ?>><?php echo $catList ?></div>
     </li>
     <li>
      <label for="invName">Product Name</label>
      <input type="text" name="invName" id="invName" placeholder="Name of new product" required
      <?php
      if (isset($invName)) {
       echo "value='$invName'";
      }
      ?> > 
     </li>
     <li>
      <label for="invDescription">Product Description</label>
      <textarea name="invDescription" id="invDescription" placeholder="Describe the new product" required><?php
      if (isset($invDescription)) {
       echo $invDescription;
      }
      ?></textarea>
     </li>
     <li>
      <label for="invImage">Product Image (path to image)</label>
      <input type="text" name="invImage" id="invImage" value="/acme/images/no-image.png" required       
      <?php
      if (isset($invImage)) {
       echo "value='$invImage'";
      }
      ?>>
     </li>
     <li>
      <label for="invThumbnail">Product Thumbnail (path to thumbnail)</label>
      <input type="text" name="invThumbnail" id="invThumbnail" value="/acme/images/no-image.png" required
      <?php
      if (isset($invThumbnail)) {
       echo "value='$invThumbnail'";
      }
      ?>>
     </li>
     <li>
      <!--pattern="\d+(\.\d{2})?"-->
      <label for="invPrice">Product Price</label>
      <input type="number" name="invPrice" id="invPrice" placeholder="Price of new product" min="0" step=".01" required <?php
      if (isset($invPrice)) {
       echo "value='$invPrice'";
      }
      ?>>
     </li>
     <li>
      <label for="invStock">Product Stock</label>
      <input type="number" name="invStock" id="invStock" placeholder="Amount of product in stock" required       
      <?php
      if (isset($invStock)) {
       echo "value='$invStock'";
      }
      ?>>
     </li>
     <li>
      <label for="invSize">Product Size - L x W x H</label>
      <input type="text" name="invSize" id="invSize" placeholder="Size of product" required       
      <?php
      if (isset($invSize)) {
       echo "value='$invSize'";
      }
      ?>>
     </li>
     <li>
      <label for="invWeight">Product Weight</label>
      <input type="number" name="invWeight" id="invWeight" placeholder="Weight of product" required       
      <?php
      if (isset($invWeight)) {
       echo "value='$invWeight'";
      }
      ?>>
     </li> 
     <li>
      <label for="invLocation">Product Location</label>
      <input type="text" name="invLocation" id="invLocation" placeholder="Location of product" required       
      <?php
      if (isset($invLocation)) {
       echo "value='$invLocation'";
      }
      ?>>
     </li>
     <li>
     <li>
      <label for="invVendor">Product Vendor</label>
      <input type="text" name="invVendor" id="invVendor" placeholder="Product Vendor" required       
      <?php
      if (isset($invVendor)) {
       echo "value='$invVendor'";
      }
      ?>>
     </li>
     <li>
      <label for="invStyle">Product Material/Style</label>
      <input type="text" name="invStyle" id="invStyle" placeholder="Material of product" required       
      <?php
      if (isset($invStyle)) {
       echo "value='$invStyle'";
      }
      ?>>
     </li>
    </ul>
    <input type="submit" name="submit" id="addProductButton" class="button" value="Add Product">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="addInventory">            
   </form>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/add-product.php")); ?> </p>
  </footer>
 </body>
</html>



