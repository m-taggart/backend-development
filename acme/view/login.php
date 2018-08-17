<!DOCTYPE html>
<!--
Login View
-->
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>Login View</title>
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
   <h1>Login To Your ACME Account</h1>
   <div class="alert">
    <?php
   if (isset($message)) {
    echo $message;
   }
   ?>
   </div>
   <form id="login" method="post" action="/acme/accounts/index.php">
    <ul>
     <li>
      <label for="clientEmail">Username:</label>
      <input name="clientEmail" id="clientEmail" type="email" placeholder="Username" <?php if (isset($clientEmail)) {echo "value='$clientEmail'";} ?> required>
     </li>
     <li>
      <label for="clientPassword">Password: </label>
      <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter, and 1 special character.</span>
      <input name="clientPassword" id="clientPassword" type="password" placeholder="Password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">         
     </li>
    </ul>
    <input type="submit" name="submit" id="loginButton" class="button" value="Login">
    <!--Add the action name-value pair-->
    <input type="hidden" name="action" value="Login">
   </form>


   <h2 id="newAccount">Not a member?</h2>
   <div id="button"><a role="button" id="createAccount" href="../accounts/index.php?action=registerView">Create Your Account</a></div>
  </main>

  <footer> 
   <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
   <p><?php echo "Last modified: " . date("F d, Y", filemtime("../view/login.php")); ?> </p>
  </footer>
 </body>
</html>



