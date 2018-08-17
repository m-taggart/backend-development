<?php

/*
 * Acme Controller
 */

//Create or access a Session
session_start();


//Get the database connection file
require_once 'library/connections.php';
//Get the acme model for use as needed
require_once 'model/acme-model.php';
//Get the products model
require_once 'model/products-model.php';
//Get the functions library
require_once 'library/functions.php';

//Get the array of categories
$categories = getCategories();
//var_dump($categories);
//exit;

//Build a navigation bar using the $categories array
$navList = navigation($categories);

//Build a navigation bar using the $categories array
//$navList = '<ul>';
//$navList .= "<li><a href='/acme/index.php'
//        title='View the Acme home page'>Home</a></li>";
//foreach ($categories as $category) {
//    //how to pass a name value pair to the controller
//    $navList .= "<li><a href='/acme/index.php?action=" . urlencode($category['categoryName']) . "' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
//}
//$navList .= '</ul>';

//echo $navList;
//exit;

//if(isset ($_COOKIE['firstname'])){
// $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
//}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}
//Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
 $cookieFirstName = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}

switch ($action) {
    case 'something':
        break;
    default:
        include 'view/home.php';
}



