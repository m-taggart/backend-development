<!DOCTYPE html>
<!--
Registration View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title> Registration View </title>
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
   <h1> Register For An Account </h1>
   <p id="required">All fields required.</p>
   <div class="alert">
   <?php
   if (isset($message)) {
    echo $message;
   }
   ?>
   </div>
   <form id="register" method="post" action="/acme/accounts/index.php">
    <ul>
     <li>
      <label for="clientFirstName">First Name: </label>
      <input type="text" name="clientFirstName" id="clientFirstName" placeholder="First Name" <?php if (isset($clientFirstName)) {echo "value='$clientFirstName'";} ?> required>

     </li>
     <li>
      <label for="clientLastName">Last Name: </label>
      <input type="text" name="clientLastName" id="clientLastName" placeholder="Last Name" <?php if (isset($clientLastName)) {echo "value='$clientLastName'";} ?> required>
     </li>
     <li>
      <label for="clientEmail">Email: </label>
      <input type="email" name="clientEmail" id="clientEmail" placeholder="Email" <?php if (isset($clientEmail)) {echo "value='$clientEmail'";} ?> required>
     </li>
     <li>
      <label for="clientPassword">Password: </label>
      <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</span>
      <input type="password" name="clientPassword" id="clientPassword" placeholder="Password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
     </li>
    </ul>
    <label>&nbsp;</label>
    <input type="submit" name="submit" id="registerButton" class="button" value="Register">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="register"> 
   </form>

  </main>
  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/registration.php")); ?> </p>
  </footer>
 </body>
</html>