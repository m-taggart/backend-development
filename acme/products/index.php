<?php

/*
 * Products Controller
 */

//Create or access a Session
session_start();

//Get the database connection file
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
 case 'categories':
  include '../view/add-category.php';
  break;

 case 'inventory':
  include '../view/add-product.php';
  break;

 case 'addCategory':
  //filter and store the data
  $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);
  //Check for missing data
  if (empty($categoryName)) {
   $message = '<p>Please provide a name for the new category.</p>';
   include '../view/add-category.php';
   exit;
  }
  //Send the data to the model
  $catOutcome = newCategory($categoryName);

  //Check and report the result
  if ($catOutcome === 1) {
   //$message = "<p>The new category, $categoryName, has been added.</p>";
   header('location: ../products/index.php');
   exit;
  } else {
   $message = "<p>Please try again. The category was not added.</p>";
   include '../view/add-category.php';
   exit;
  }
  break;

 case 'addInventory':
  //filter and store the data
  $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
  $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
  $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
  $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
  $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //matching php
  $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
  $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_STRING);
  $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
  $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
  $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
  $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
  $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);

  //apply the Price function
  //$invPrice = checkPrice($invPrice);
  //Check for missing data
  if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
   $message = '<p>Please fill out all fields.</p>';
   include '../view/add-product.php';
   exit;
  }

  //Send the data to the model
  $invOutcome = newInventory($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle);

  //Check and report the result
  if ($invOutcome === 1) {
   $message = "<p>Your new product, $invName, has been added.</p>";
   include '../view/add-product.php';
   exit;
  } else {
   $message = "<p>Error, please try again.</p>";
   include '../view/add-product.php';
   exit;
  }
  break;

 //this case modifies or updates the product information
 case 'mod':
  //capture the value of second name-value pair
  $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  //getProductInfo function
  $prodInfo = getProductInfo($invId);
  //check if $prodInfo has any data, else send message
  if (count($prodInfo) < 1) {
   $message = 'Sorry, no product information could not be found.';
  }
  include '../view/prod-update.php';
  exit;
  break;

 //updates or modifies the products in the inventory
 case 'updateProd':
  //filter and store the data
  $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
  $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
  $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
  $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
  $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //matching php
  $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
  $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_STRING);
  $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_INT);
  $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
  $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);
  $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
  $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
  $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

  //Check for missing data
  if (empty($invName) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) || empty($invWeight) || empty($invLocation) || empty($categoryId) || empty($invVendor) || empty($invStyle)) {
   $message = '<p>Please fill out all fields. Double check the category of the item.</p>';
   include '../view/prod-update.php';
   exit;
  }

  //Send the data to the model
  $updateResult = updateProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle, $invId);
  //Check and report the result
  if ($updateResult) {
   $message = "<p class='alert'>Congratulations, $invName was successfully updated.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/products/');
   exit;
  } else {
   $message = "<p class='alert'>Error, $invName was not updated.</p>";
   include '../view/prod-update.php';
   exit;
  }
  break;

 //start the delete and deliver the info for confirmation
 case 'del':
  $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  $prodInfo = getProductInfo($invId);
  if (count($prodInfo) < 1) {
   $message = 'Sorry, no product information could be found.';
  }
  include '../view/prod-delete.php';
  exit;
  break;

 //process the delete and report the results
 case 'deleteProd':
  //filter and store the data
  $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
  $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

  $deleteResult = deleteProduct($invId);
  if ($deleteResult) {
   $message = "<p class='alert'>$invName was sucessfully deleted.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/products/');
   exit;
  } else {
   $message = "<p class='alert'>Error: $invName was not deleted.</p>";
   $_SESSION['message'] = $message;
   header('location: /acme/products/');
   exit;
  }
  break;

//displays categorys of products
 case 'category':
  $type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
  $products = getProductsByCategory($type); //products-model.php
  if (!count($products)) {
   $message = "<p class='notice'>Sorry, no $type products could be found.</p>";
  } else {
   $prodDisplay = buildProductsDisplay($products); //functions.php
  }
  //echo $prodDisplay;
  //exit;
  include '../view/category.php';
  break;

//product details page
//displays details of a specific product
 case 'detail':
  $invId = filter_input(INPUT_GET, 'info', FILTER_SANITIZE_STRING);
  //call function when the product detail page is requested
  $description = getProductDetail($invId); //products-model.php
//shows the product details
  if (!count($description)) {
   $message = "<p class='notice'>Sorry, information for $description could not be found.</p>";
  } else {
   $detailDisplay = buildDetailDisplay($description); //functions.php
  }

  $thumbnails = getThumbnailImages($invId); //uploads-model.php
  if (count($thumbnails)) {
   $thumbnailDisplay = buildAdditionalThumbnail($thumbnails); //functions.php
  }

  $clientId = filter_input(INPUT_GET, 'clientId', FILTER_SANITIZE_NUMBER_INT);
  $screenName = filter_input(INPUT_GET, 'screenName', FILTER_SANITIZE_STRING);

  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) {
   $clientId = $_SESSION['clientData']['clientId'];
   $clientFirst = substr($_SESSION['clientData']['clientFirstName'], 0, 1);
   $screenName = $clientFirst . $_SESSION['clientData']['clientLastName'];
  
   //build the review form to add a review
   $reviews = buildReviewForm($clientId, $invId, $screenName);
  } else {
   $reviews = "<h3 id='logoutReview'>To submit a review please <a href='../accounts/index.php?action=Login'>login.</a></h3>"; //when you are logged out
  }
//once the user has filled out the review, put the review on the product page
  $allReviews = getInvReviews($invId); //get all inventory reviews
//if there is a review for the product, display it in the review display in the admin page
  if (count($allReviews)) {
   $displayReviews = buildReviewDisplay($allReviews);
  }

  include '../view/product-detail.php';
  break;

 default:
  //function to get a list of product names and ids from inventory table
  $products = getProductBasics();
  //test to see if products were returned
  if (count($products) > 0) {
   //if true, create table of products
   $prodList = '<table>';
   $prodList .= '<thead>';
   $prodList .= '<tr><th><p>Product Name</p></th><td>&nbsp;</td><td>&nbsp;</td></tr>';
   $prodList .= '</thead>';
   $prodList .= '<tbody>';
   foreach ($products as $product) {
    $prodList .= "<tr><td><p>$product[invName]</p></td>";
    $prodList .= "<td><p><a href='/acme/products?action=mod&id=$product[invId]' title='Click to modify'>Modify</a></p></td>";
    $prodList .= "<td><p><a href='/acme/products?action=del&id=$product[invId]' title='Click to delete'>Delete</a></p></td></tr>";
   }
   $prodList .= '</tbody></table>';
  } else {
   //else false, there are no products in inventory
   $message = '<p class="notify">Sorry, no products were returned.</p>';
  }
  include '../view/product-management.php';
  break;
}
 
