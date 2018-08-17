<?php

/*
 * Accounts Controller
 */

//Create or access a Session
session_start();


require_once '../library/connections.php';
//Get the acme model for use as needed
require_once '../model/acme-model.php';
//Get the products model
require_once '../model/products-model.php';
//Get the functions library
require_once '../library/functions.php';
//get the uploads model
require_once '../model/uploads-model.php';
//get the accounts model
require_once '../model/accounts-model.php';
//get the reviews model
require_once '../model/reviews-model.php';

//Get the array of categories
$categories = getCategories();

//Build a navigation bar using the $categories array
$navList = navigation($categories);

//Get the value from the action name - value pair
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action');
}

if (isset($_COOKIE['firstname'])) {
 $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
 case 'loginView':
  include '../view/login.php';
  break;

 case 'registerView':
  include '../view/registration.php';
  break;

 case 'register':
//filter and store the data
  $clientFirstName = filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING);
  $clientLastName = filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING);
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);

//apply the email function
  $clientEmail = checkEmail($clientEmail);
//apply the password function
  $checkPassword = checkPassword($clientPassword);
  //check for an existing email in the database
  $existingEmail = checkExistingEmail($clientEmail);

  //check if new variable is true or false, if there is already an existing email there is no need to continue with the rest of the code on the page
  if ($existingEmail) {   //this is true
   $message = '<p class="alert">The email you entered already exists. Do you want to login instead?</p>';
   include '../view/login.php';
   exit;
  }

  //if the data is false, the regular registration process will proceed
  //Check for missing data
  if (empty($clientFirstName) || empty($clientLastName) || empty($clientEmail) || empty($checkPassword)) {
   $message = '<p>Please provide information for all empty form fields.</p>';
   include '../view/registration.php';
   exit;
  }

//Hash the checked password
  $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

//Send the data to the model
  $regOutcome = regClient($clientFirstName, $clientLastName, $clientEmail, $hashedPassword);

//Check and report the result
  if ($regOutcome === 1) {
   setcookie('firstname', $clientFirstName, strtotime('+1 year'), '/');

   $message = "<p>Thanks for registering $clientFirstName. Please use your email and password to login.</p>";
   include '../view/login.php';
   exit;
  } else {
   $message = "<p>I'm sorry $clientFirstName, but the registration failed. Please try again.</p>";
   include '../view/registration.php';
   exit;
  }
  break;

 case 'Login':
//filter and store the email and password in variables
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  //apply the email function to validate the email
  $clientEmail = checkEmail($clientEmail);

  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
//apply the password function to check the format of the password
  $checkPassword = checkPassword($clientPassword);

//check if the variables are empty and send appropriate messages
  if (empty($clientEmail) || empty($checkPassword)) {
   $message = '<p>Please provide information for all empty form fields.</p>';
   include '../view/login.php';
   exit;
  }
// A valid password exists, proceed with the login process
// Query the client data based on the email address
  $clientData = getClient($clientEmail);
// Compare the password just submitted against
// the hashed password for the matching client
  $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
// If the hashes don't match create an error
// and return to the login view
  if (!$hashCheck) {
   $message = '<p class="notice">Please check your password and try again.</p>';
   include '../view/login.php';
   exit;
  }

// A valid user exists, log them in
  $_SESSION['loggedin'] = TRUE;
// Remove the password from the array
// the array_pop function removes the last
// element from an array
  array_pop($clientData);
// Store the array into the session
  $_SESSION['clientData'] = $clientData;
  setcookie('firstname', $_SESSION['clientData']['clientFirstName'], strtotime('+1 year'), '/');
//  $productsLink = "<p><a href='../products/index.php'>Product Management</a></p>";

  $clientReviews = getClientReviews($clientId);

// Send them to the admin view
  header('location: /acme/accounts/');
  exit;
  break;

 case 'Logout':
  setcookie('firstname', '', (-3600), '/');
  $_SESSION['loggedin'] = FALSE;
  session_destroy();
  header('location: /acme/accounts/');
  break;

 //updateView data can be displayed so that changes can be made to data
 case 'updateView':
  $clientId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $accountInfo = getAccountInfo($clientId);
  if (count($accountInfo) < 1) {
   $message = 'Sorry, no account information could be found.';
  }
  include '../view/client-update.php';
  exit;
  break;

//updateAccount recieves and check the data sent from the updateView
 case 'updateAccount':
  $clientFirstName = filter_input(INPUT_POST, 'clientFirstName', FILTER_SANITIZE_STRING);
  $clientLastName = filter_input(INPUT_POST, 'clientLastName', FILTER_SANITIZE_STRING);
  $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
  $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
  //apply the email function
  $clientEmail = checkEmail($clientEmail);
  //check for an existing email in the database
//  $existingEmail = checkExistingEmail($clientEmail);

  if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
   $existingEmail = checkExistingEmail($clientEmail);

   if ($existingEmail) {   //this is true
    $message = '<p>The email you entered already exists. Try a new email.</p>';
    include '../view/client-update.php';
    exit;
   }
  }
  if (empty($clientFirstName) || empty($clientLastName) || empty($clientEmail)) {
   $message = '<p>Please complete all information fields.</p>';
   include '../view/client-update.php';
   exit;
  } $updateAccountResult = updateAccount($clientFirstName, $clientLastName, $clientEmail, $clientId);
  $clientData = getClient($clientEmail);
  $_SESSION['clientData'] = $clientData;

  if ($updateAccountResult === 1) {
   $message = "<p>Congratulations $clientFirstName, your account was successfully updated.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/accounts/');
   exit;
  } else {
   $message = "<p>Error. Your account was not updated.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/accounts/');
   exit;
  }
// Store the array into the session
  $_SESSION['clientData'] = $clientData;
// Send them to the admin view
  include '../view/admin.php';
  break;

 case 'changePassword':
  $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
  $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
//apply the password function to check the format of the password
  $checkPassword = checkPassword($clientPassword);
//check that the password meets requirements
  if (empty($checkPassword)) {
   $passwordmessage = '<p>Please provide a valid password.</p>';
   include '../view/client-update.php';
   exit;
  }
//Hash the checked password
  $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
  //send to a function to be updated in database
  $updatePasswordResult = updatePassword($hashedPassword, $clientId);
  //Check and report the result
  if ($updatePasswordResult === 1) {
   $message = "<p>Success! A new password has been created for your account.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/accounts/');
   exit;
  } else {
   $passwordmessage = "<p>Error, please udate your password again.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/accounts/');
   exit;
  }
  include "../view/admin.php";
  break;


 default:

//  function to get a list of client reviews from inventory table
  $clientReviews = getClientReviews($_SESSION['clientData']['clientId']);
//  test to see if reviws were returned
  if (count($clientReviews) > 0) {
   //if true, create table of products
   $reviewList = '<table>';
   $reviewList .= '<thead>';
   $reviewList .= '<tr><th><p>Client Reviews</p></th><td>&nbsp;</td><td>&nbsp;</td><td></td></tr>';
   $reviewList .= '</thead>';
   $reviewList .= '<tbody>';
   foreach ($clientReviews as $clientReview) {
    $reviewList .= "<tr><td><p>$clientReview[invName]</p></td>";
    $reviewList .= "<td><p>$clientReview[reviewText]</p></td>";
    $reviewList .= "<td><p><a href='/acme/reviews?action=editView&id=$clientReview[reviewId]'>Update Review</a></p></td>";
    $reviewList .= "<td><p><a href='/acme/reviews?action=deleteView&id=$clientReview[reviewId]'>Delete Review</a></p></td></tr>";
   }
   $reviewList .= '</tbody></table>';
  } else {
   //else false, there are no reviews stored
   $message = '<p class="notify">Sorry, no reviews were returned.</p>';
  }

  include '../view/admin.php';
  break;
}




