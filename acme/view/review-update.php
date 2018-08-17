<?php
if (!$_SESSION['loggedin']) {
 header('Location: /acme/index.php');
}
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<!--
Review Update View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>Modify Review | Acme, Inc</title>
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
    if (isset($specReview['invName'])) {
     echo "Modify $specReview[invName] ";
    } elseif (isset($invName)) {
     echo $invName;
    }
    ?> </h1>
   <p id="required">Update the review below. All fields are required!</p>
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>

   <form id="reviews" method="post" action="/acme/reviews/">
    <ul>  
     <li>
      <label for="invName">Product Name</label>
      <input type="text" name="invName" id="invName" readonly
      <?php
      if (isset($invName)) {
       echo "value='$invName'";
      } elseif (isset($specReview['invName'])) {
       echo "value = '$specReview[invName]'";
      }
      ?> > 
     </li>
     <li>
      <label for="reviewText">Product Review: </label>
      <textarea name="reviewText" id="reviewText" required><?php
       if (isset($reviewText)) {
        echo $reviewText;
       } elseif (isset($specReview['reviewText'])) {
        echo $specReview['reviewText'];
       }
       ?></textarea>
     </li>
    </ul>
    <input type="submit" name="submit" class="button" value="Update Review">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="updateRev">
    <input type="hidden" name="reviewId" value="<?php if(isset($specReview['reviewId'])){ echo $specReview['reviewId'];} elseif(isset($reviewId)){ echo $reviewId; } ?>">
   </form>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/review-update.php")); ?> </p>
  </footer>
 </body>
</html>
<?php unset($_SESSION['message']); ?>



