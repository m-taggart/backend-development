<?php

/*
 * Custom Functions
 */

//validate email from server side
function checkEmail($clientEmail) {
 $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
 return $valEmail;
}

//validate password from server side
//minimum of 8 characters, 1 capital, 1 number, 1 special character
function checkPassword($clientPassword) {
 $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])[[:print:]]{8,}$/';
 return preg_match($pattern, $clientPassword);
}

//navigation bar is displayed through a function
function navigation($categories) {
 $nav = '<ul>';
 $nav .= "<li><a href='/acme/' title='View the Acme home page'>Home</a></li>";
 foreach ($categories as $category) {
  $nav .= "<li><a href='/acme/products/?action=category&type=$category[categoryName]' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
 }
 $nav .= '</ul>';
 return $nav;
}

//Display products within an unordered list
function buildProductsDisplay($products) {
 $pd = '<ul id="prod-display">';
 foreach ($products as $product) {
  $pd .= '<li>';
  $pd .= "<a href='/acme/products/?action=detail&info=$product[invId]' title='Read the $product[invName] details.'><img src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'></a>";
  $pd .= '<hr>';
  $pd .= "<h2><a href='/acme/products/?action=detail&info=$product[invId]' title='Read the $product[invName] details.'>$product[invName]</a></h2>";
  $pd .= "<span>$$product[invPrice]</span>";
  $pd .= '</li>';
 }
 $pd .= '</ul>';
 return $pd;
}

//Display product details
function buildDetailDisplay($description) {
 $dd = '<ul id="detail-display">';
 $dd .= '<li id="topInfo">';
 $dd .= "<aside><img id='topImage' src='$description[invImage]' alt='Image of $description[invName] on Acme.com'> <br> <p>Product<a href='#reviews'>reviews</a> appear at the bottom of the page.</p> </aside>";
 $dd .= "<div id='rightDetail'>";
 $dd .= "<h2>$description[invName] - </h2>";
 $dd .= "<p id='detail'>$description[invDescription]</p>";
 $dd .= "<p id='vendor'>by $description[invVendor]</p>";
 $dd .= "<p id='price'>Price: $$description[invPrice]</p>";
 $dd .= "<p id='stock'>$description[invStock] left in stock!</p>";
 $dd .= "<p class='moreDetail'>- Pick up in $description[invLocation]</p>";
 $dd .= "<p class='moreDetail'>- Size: $description[invSize] Inches</p>";
 $dd .= "<p class='moreDetail'>- Weight: $description[invWeight] Pounds</p>";
 $dd .= "<p class='moreDetail'>- Style: $description[invStyle]</p>";
 $dd .= "</div>";
 $dd .= '</li>';
 $dd .= '</ul>';
 return $dd;
}

/* * ********************************
 * Functions for working with images
 * ********************************* */

// Adds "-tn" designation to file name
//periods separate the file name from the extension
function makeThumbnailName($image) {//needs a string represents a name(the path or file name) of an image. 
 $i = strrpos($image, '.'); //strrpos function looks for the location of the period in the name and sends back location
 $image_name = substr($image, 0, $i); //substr function breaks string apart like an array
 $ext = substr($image, $i); //file extension part of the array
 $image = $image_name . '-tn' . $ext; //add the -tn to the name and file path
 return $image; //thumbnail alteration is returned
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
 $id = '<ul id="image-display">';
 foreach ($imageArray as $image) {
  $id .= '<li>';
  $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
  $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
  $id .= '</li>';
 }
 $id .= '</ul>';
 return $id;
}

// Build the products select list
function buildProductsSelect($products) {
 $prodList = '<select name="invId" id="invId">';
 $prodList .= "<option>Choose a Product</option>";
 foreach ($products as $product) {
  $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
 }
 $prodList .= '</select>';
 return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
 // Gets the paths, full and local directory
 global $image_dir, $image_dir_path;
 if (isset($_FILES[$name])) {
  // Gets the actual file name
  $filename = $_FILES[$name]['name'];
  if (empty($filename)) {
   return;
  }
  // Get the file from the temp folder on the server
  $source = $_FILES[$name]['tmp_name'];
  // Sets the new path - images folder in this directory
  $target = $image_dir_path . '/' . $filename;
  // Moves the file to the target folder
  move_uploaded_file($source, $target);
  // Send file for further processing
  processImage($image_dir_path, $filename);
  // Sets the path for the image for Database storage
  $filepath = $image_dir . '/' . $filename;
  // Returns the path where the file is stored
  return $filepath;
 }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
 // Set up the variables
 $dir = $dir . '/';

 // Set up the image path
 $image_path = $dir . $filename;

 // Set up the thumbnail image path
 $image_path_tn = $dir . makeThumbnailName($filename);

 // Create a thumbnail image that's a maximum of 200 pixels square
 resizeImage($image_path, $image_path_tn, 200, 200);

 // Resize original to a maximum of 500 pixels square
 resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {

 // Get image type
 $image_info = getimagesize($old_image_path);
 $image_type = $image_info[2];

 // Set up the function names
 switch ($image_type) {
  case IMAGETYPE_JPEG:
   $image_from_file = 'imagecreatefromjpeg';
   $image_to_file = 'imagejpeg';
   break;
  case IMAGETYPE_GIF:
   $image_from_file = 'imagecreatefromgif';
   $image_to_file = 'imagegif';
   break;
  case IMAGETYPE_PNG:
   $image_from_file = 'imagecreatefrompng';
   $image_to_file = 'imagepng';
   break;
  default:
   return;
 }

 // Get the old image and its height and width
 $old_image = $image_from_file($old_image_path);
 $old_width = imagesx($old_image);
 $old_height = imagesy($old_image);

 // Calculate height and width ratios
 $width_ratio = $old_width / $max_width;
 $height_ratio = $old_height / $max_height;

 // If image is larger than specified ratio, create the new image
 if ($width_ratio > 1 || $height_ratio > 1) {

  // Calculate height and width for the new image
  $ratio = max($width_ratio, $height_ratio);
  $new_height = round($old_height / $ratio);
  $new_width = round($old_width / $ratio);

  // Create the new image
  $new_image = imagecreatetruecolor($new_width, $new_height);

  // Set transparency according to image type
  if ($image_type == IMAGETYPE_GIF) {
   $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
   imagecolortransparent($new_image, $alpha);
  }

  if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
   imagealphablending($new_image, false);
   imagesavealpha($new_image, true);
  }

  // Copy old image to new image - this resizes the image
  $new_x = 0;
  $new_y = 0;
  $old_x = 0;
  $old_y = 0;
  imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);

  // Write the new image to a new file
  $image_to_file($new_image, $new_image_path);
  // Free any memory associated with the new image
  imagedestroy($new_image);
 } else {
  // Write the old image to a new file
  $image_to_file($old_image, $new_image_path);
 }
 // Free any memory associated with the old image
 imagedestroy($old_image);
}

// Build thumbnail images display for product detail view
function buildAdditionalThumbnail($thumbnails) {
 $tn = '<h2>Product Thumbnails</h2>';
 $tn .= '<ul id="thumbnail-display">';
 foreach ($thumbnails as $thumbnail) {
  $tn .= '<li>';
  $tn .= "<img src='$thumbnail[imgPath]' title='$thumbnail[imgName] image on Acme.com' alt='$thumbnail[imgName] image on Acme.com'>";
  $tn .= '</li>';
 }
 $tn .= '</ul>';
 return $tn;
}

function buildReviewForm($clientId, $invId, $screenName) {
 $reviewForm = '<form id="newRev" method="post" action="/acme/reviews/">';
 $reviewForm .= '<ul>';
 $reviewForm .= '<li class="reviewList">';
 $reviewForm .= '<label for="screenName">Screen Name: </label><br>';
 $reviewForm .= "<input type='text' id='screenName' name='screenName' value='$screenName' readonly>";
 $reviewForm .= '</li>';
 $reviewForm .= '<li class="reviewList">';
 $reviewForm .= '<label for="reviewText">Review: </label><br>';
 $reviewForm .= "<textarea name='reviewText' id='reviewText' placeholder='Enter review here' required> </textarea>";
 $reviewForm .= '</li>';
 $reviewForm .= '</ul>';
 $reviewForm .= "<input type='submit' name='submit' id='reviewButton' class='reviewButton' value='Submit Review'>";
 $reviewForm .= "<input type='hidden' name='clientId' value='$clientId'>";
 $reviewForm .= "<input type='hidden' name='invId' value='$invId'>";
 $reviewForm .= "<input type='hidden' name='action' value='newRev'>";
 $reviewForm .= '</form>';
 return $reviewForm;
}

//function that displays all reviews for an inventory item
function buildReviewDisplay($allReviews) {
 $reviewDisplay = '<ul id="displayProductReview">';
 foreach ($allReviews as $review) {
  $screenName = substr($review['clientFirstName'],0,1) .$review['clientLastName'];
  $reviewDisplay .= '<li id="reviewDesign">';
  $reviewDisplay .= "<p><strong>$screenName</strong> wrote this on $review[reviewDate]</p> <br>";
  $reviewDisplay .= "<p>$review[reviewText]</p>";
  $reviewDisplay .= '<hr>';
  $reviewDisplay .= '</li>';
 }
 $reviewDisplay .= '</ul>';
 return $reviewDisplay;
}

function buildClientReview($clientReviews) {
 $reviewList = '<ul>';
 foreach ($clientReviews as $clientReview) {
  $reviewList .= '<li>';
  $reviewList .= "$clientReview[reviewText]<br>"; //
  $reviewList .= "<p><a href='../reviews/index.php?action=editView&id=$clientReview[reviewId]'>Update Review</a></p>";
  $reviewList .= "<p><a href='../reviews/index.php?action=deleteView&id=$clientReview[reviewId]'>Delete Review</a></p>";
  $reviewList .= '</li>';
 }
 $reviewList .= '</ul>';
 return $reviewList;
}
