<div class="acmeHome">
<a href="/acme/index.php" title="Home"><img class="logo" src="/acme/images/site/logo.gif" alt="ACME logo"></a>
</div>
<div id="toplinks">
 <div id='cookieFirstName'>
  <?php
  if (isset($cookieFirstName)) {
   echo "<span class='welcome'><a href='/acme/accounts/index.php'>Welcome $cookieFirstName</a></span>";
  }
  ?>
 </div>
 <?php
 if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
//  $logOut = "<img class='file' src='/acme/images/site/account.gif' alt='File folder icon'>";
//  $logOut .= "<p><a href='/acme/accounts/index.php?action=Logout' id='logout' title='Logout'>Logout</a></p>";
  echo '<img class="file" src="/acme/images/site/account.gif" alt="File folder icon"> <a href="/acme/accounts/index.php?action=Logout" id="logout" title="Logout">Log Out</a>';
 } else {
  echo "<img class='file' src='/acme/images/site/account.gif' alt='File folder icon'> <a href='/acme/accounts/index.php?action=Login' class='login' title='View Account'> My Account </a>";
//  $logIn .= "<p>";
//  $logIn .= "<a href='/acme/accounts/index.php?action=loginView' title='Login to your ACME account.'>My Account</a>";
//  $logIn .= "</p>";
//  echo $logIn;
 }
 ?>
</div>