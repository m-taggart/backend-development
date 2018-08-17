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
 } elseif (isset($prodInfo['categoryId'])) {
  if ($category['categoryId'] === $prodInfo['categoryId']) {
   $catList .= ' selected ';
  }
 }
 $catList .= ">$category[categoryName]</option>";
}
$catList .= '</select>'
?>

<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /acme/'); //if clientlevel < 2,  send to home page
 exit;
}
?><!DOCTYPE html>
<!--
Add Product View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title><?php
   if (isset($prodInfo['invName'])) {
    echo "Delete $prodInfo[invName] ";
   }
   ?> | Acme, Inc</title>
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
   <h1><?php
    if (isset($prodInfo['invName'])) {
     echo "Delete $prodInfo[invName]";} ?>
   </h1>
   <p id="required">Confirm Product Deletion. The delete is permanent.</p>
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>

   <form id="inventory" method="post" action="/acme/products/">
    <ul>
     <li>
      <label for="invName">Product Name</label>
      <input type="text" name="invName" id="invName" placeholder="Name of new product"readonly
      <?php
      if (isset($prodInfo['invName'])) {
       echo "value = '$prodInfo[invName]'";
      }
      ?> > 
     </li>
     <li>
      <label for="invDescription">Product Description</label>
      <textarea name="invDescription" id="invDescription" placeholder="Describe the new product" readonly><?php
       if (isset($prodInfo['invDescription'])) {
        echo $prodInfo['invDescription'];
       }
       ?></textarea>
     </li>
    </ul>
    <input type="submit" name="submit" id="addProductButton" class="button" value="Delete Product">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="deleteProd">
    <input type="hidden" name="invId" value="<?php
       if (isset($prodInfo['invId'])) {
        echo $prodInfo['invId'];
       }
       ?>">
   </form>
  </main>
  <footer> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/prod-delete.php")); ?> </p>
  </footer>
 </body>
</html>



