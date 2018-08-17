<?php
//if ($_SESSION['loggedin'] && ['loggedin'] === TRUE) {
// header('location: ../view/review-delete.php');
// //if loggedin, send to home page
// exit;
//} else {
// header('location: /acme/');
// exit;
//}
if (!$_SESSION['loggedin']) {
 header('Location: /acme/index.php');
}
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<!--
Delete Review View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>Delete Review | Acme, Inc</title>
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
   <h1>Delete <?php
    if (isset($specReview['invName'])) {
     echo $specReview['invName'];
    }
    ?> Review
   </h1>
   <p id="required">Confirm Review Deletion. The delete is permanent.</p>
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
      <label>Product: </label>
      <p><?php echo $specReview['invName']
    ?></p>
     </li>
     <li>
      <label for="reviewText">Product Review: </label>
      <textarea name="reviewText" id="reviewText" readonly><?php echo $specReview['reviewText']
    ?></textarea>
     </li>
    </ul>
    <input type="submit" name="submit" id="deleteButton" class="button" value="Delete Review">
    <input type="hidden" name="action" value="deleteRev">
    <input type="hidden" name="reviewId" value="<?php echo $reviewId ?>">
   </form>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/review-delete.php")); ?> </p>
  </footer>
 </body>
</html>
<?php unset($_SESSION['message']); ?>




