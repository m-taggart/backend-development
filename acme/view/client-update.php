<?php
if (!$_SESSION['loggedin']) {
 header('Location: /acme/index.php');
}
?><!DOCTYPE html>
<!--
Client Update View - change name, email, and password
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>Client Update</title>
  <link href="/acme/css/acme.css" type="text/css" rel="stylesheet" media="screen">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 </head>
 <body>
  <header>
   <div class='logofile'>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
   </div>
   <nav>
    <!--?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/nav.php'; ?-->
    <?php echo $navList; ?>
   </nav>
  </header>
  <main>

   <h1> Update Account </h1>
   <div class="alert">
    <?php
    if (isset($message)) {
     echo $message;
    }
    ?>
   </div>
   <p id="required1">Use this form to update your name or email information.</p>

   <form id="updateAccount" method="post" action="/acme/accounts/">
    <ul>
     <li>
      <label for="clientFirstName">First Name: </label>
      <input type="text" name="clientFirstName" id="clientFirstName" required <?php
      $firstName = $_SESSION['clientData']['clientFirstName'];
      if (isset($clientFirstName)) {
       echo "value='$clientFirstName'";
      } elseif (isset($firstName)) {
       echo "value='$firstName'";
      }
      ?> >
     </li>

     <li>
      <label for="clientLastName">Last Name: </label>
      <input type="text" name="clientLastName" id="clientLastName" placeholder="Last Name" required <?php
      $lastName = $_SESSION['clientData']['clientLastName']; 
      if (isset($clientLastName)) {
       echo "value='$clientLastName'";
      } elseif (isset($lastName)) {
       echo "value='$lastName'";
      }
      ?> >
     </li>

     <li>
      <label for="clientEmail">Email: </label>
      <input type="email" name="clientEmail" id="clientEmail" placeholder="Email" required <?php
      $email = $_SESSION['clientData']['clientEmail'];
      if (isset($clientEmail)) {
       echo "value='$clientEmail'";
      } elseif (isset($email)) {
       echo "value='$email'";
      }
      ?> >
     </li>
    </ul>
    <label>&nbsp;</label>
    <input type="submit" name="submit" id="updateButton" class="button" value="Update Account">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="updateAccount"> 
    <input type="hidden" name="clientId" value="<?php
      $id = $_SESSION['clientData']['clientId'];
      if (isset($id)) {
       echo "value='$id'";
      } elseif (isset($accountInfo['clientId'])) {
       echo "value='$accountInfo[clientId]'";
      }
      ?>">
   </form>
   <br>
   <br>
   <h1> Change Password </h1>
   <div class="alert">
    <?php
    if (isset($passwordmessage)) {
     echo $passwordmessage;
    }
    ?>
   </div>
   <p id="required">Use this form to change your password.</p>

   <form id="updatePassword" method="post" action="/acme/accounts/">
    <ul>
     <li>
      <label for="clientPassword">New Password:</label>
      <br>
      <p id='small'>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</p>
      <input type="password" name="clientPassword" id="clientPassword" placeholder="Password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
     </li>
    </ul>
    <label>&nbsp;</label>
    <input type="submit" name="submit" id="updatePasswordButton" class="button" value="Change Password">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="changePassword"> 
    <input type="hidden" name="clientId" value="<?php
      $id = $_SESSION['clientData']['clientId'];
      if (isset($id)) {
       echo "value='$id'";
      } elseif (isset($accountInfo['clientId'])) {
       echo "value='$accountInfo[clientId]'";
      }
      ?>">
   </form>
  </main>
  <footer> 
<?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/client-update.php")); ?> </p>
  </footer>
 </body>
</html>





