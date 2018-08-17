<?php

/* Reviews Controller
 */

session_start();

require_once '../library/connections.php';
require_once '../model/acme-model.php';
require_once '../model/products-model.php';
require_once '../model/uploads-model.php';
require_once '../model/accounts-model.php';
require_once '../library/functions.php';
require_once '../model/reviews-model.php';

$categories = getCategories();
$navList = navigation($categories);


$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

if (isset($_COOKIE['firstname'])) {
 $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
 //1. Add a new review
 case 'newRev':
  $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
  $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
  $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

  if (empty($reviewText)) {
   $_SESSION['message'] = "<p class='alert'> Please fill out the review field.</p>";

   header("location: /acme/products/index.php?action=detail&info=$invId");
//   header('location: /acme/view/product-detail.php');
   exit;
  }

  $insertReview = insertReview($reviewText, $reviewDate, $invId, $clientId);

  if ($insertReview === 1) {
   $_SESSION['message'] = "<p class='alert'>Thank you! Your review has been submitted.</p>";
//   $allReviews = getInvReviews($invId); //get all inventory reviews
//
//   if (count($allReviews)) {
//    $displayReviews = buildReviewDisplay($allReviews);
//   }
   header("location: /acme/products/index.php?action=detail&info=$invId");
//   include '../view/product-detail.php'; //header
   exit;
  } else {
   $_SESSION['message'] = "<p class='alert'> Sorry, your review was not submitted. Please try again.</p>";
   header("location: /acme/products/index.php?action=detail&info=$invId");
   exit;
  }
  break;

//2. Deliver a view to edit a review
 case 'editView':
  $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
//  echo $reviewId;
//  exit;
  $specReview = getSpecificReview($reviewId);
//  print_r($specReview);
//  exit;
  if (($specReview) < 1) {
   $message = "<p class='alert'>Sorry, the review was not found.</p>";
  }
   include '../view/review-update.php';
   exit;
//  include '../view/review-update.php';
//  header('location: /acme/view/review-update.php');
//  exit;
  break;

 //3. Handle the review update
 case 'updateRev':
  $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
  $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
  $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
//  $specReview = getSpecificReview($reviewId);
  
  if (empty($invName) || empty($reviewText)) {
   $message = "<p class='alert'>Your review is empty. Please add a review.</p>";
   include '../view/review-update.php';
   exit;
  }
  $reviewUpdate = updateReview($reviewText, $reviewId);

  if ($reviewUpdate === 1) {  //=== 1
   $message = "<p class='alert'>Your review has been updated.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/accounts/');
   exit;
  } else {
   $message = "<p class='alert'>Error, your review has not been updated. Please try again.</p>";
   include '../view/review-update.php';
//   $_SESSION['message'] = $message;
//   header('location: /acme/accounts/');
   exit;
  }
  break;

 //4. Deliver a view to confirm deletion of a review
 case 'deleteView':
  $reviewId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
  $specReview = getSpecificReview($reviewId);
  if (count($specReview) < 1) {
   $message = 'Sorry, no product information could be found. Product was not deleted.';
   include '../view/admin.php';
   exit;
  }
  include '../view/review-delete.php';
  exit;
  break;

 //5. Handle the review deletion
 case 'deleteRev':
  // Filter and store the data
//  $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
  $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
  //Send Data to the model
  $deleteReview = deleteReview($reviewId);
  if ($deleteReview) {
   $message = "<p class='alert'>Congratulations, your review was successfully deleted.</p>";
  
   header('location: /acme/accounts/');
   exit;
  } else {
   $message = "<p class='alert'>Error: your review was not deleted.</p>";
   header('location: /acme/accounts/');
   exit;
  }
  break;

 //6. A default that will deliver the admin view if the client is logged in or the acme home view if not
 default:
  if ($_SESSION['loggedin'] === TRUE) {
   include '../view/admin.php';
   exit;
  } elseif ($_SESSION['loggedin'] === FALSE) {
   include '../view/home.php';
   exit;
  }
  break;
}




