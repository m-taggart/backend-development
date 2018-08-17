<?php
if (!$_SESSION['loggedin']) {
 header('Location: /acme/index.php');
}
if (isset($_SESSION['message'])) {
 $message = $_SESSION['message'];
}
?><!DOCTYPE html>
<!--
Admin View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> Admin View</title>
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
   <h1><?php echo $_SESSION['clientData']['clientFirstName'], " ", $_SESSION['clientData']['clientLastName']; ?> </h1>
   <br>
   <p id='required'> You are logged in to your account. </p>
   <ul id="userLogin">
    <li><p>First Name: <?php echo $firstName = $_SESSION['clientData'] ['clientFirstName']; ?></p></li>
    <li><p>Last Name: <?php echo $lastName = $_SESSION['clientData'] ['clientLastName']; ?></p></li>
    <li><p>Email: <?php echo $email = $_SESSION['clientData'] ['clientEmail']; ?></p></li>
   </ul>

   <p><a href="../accounts/index.php?action=updateView">Update Account Information</a></p>
   <div class="newLink">
    <?php
    if ($_SESSION['clientData']['clientLevel'] > 1) {
     echo '<h1>Administrative Functions</h1>';
     echo '<p id="required">Use the link below to manage products.</p>';
     echo "<h3><a href='../products/index.php'>Product Management</a></h3>";
    }
    ?></div> 
   <br>
   <h2> Products Review</h2>
   <!-- display table of reviews list-->
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>
   <?php
   if (isset($reviewList)) {
    echo $reviewList;
   }
   ?>
  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/admin.php")); ?> </p>
  </footer>
 </body>
</html>
<?php unset($_SESSION['message']); ?>





